<?php

namespace App\Imports;

use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Validators\ValidationException;
use Illuminate\Support\Str;

class DocumentImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    use Importable;

    public function model(array $row)
    {
        try {

            DB::beginTransaction();
            $document = Document::updateOrCreate(
                [
                    'nomor_berkas' => $row['nomor_berkas'] ?? '-',
                ],
                [
                    'uuid' => Str::uuid(),
                    'title' => $row['uraian'] ?? '-',
                    'kode_klasifikasi' => $row['kode_klasifikasi'] ?? '-',
                    'published_at' => $row['tanggal'] ?? null,
                    'jumlah' => $row['jumlah'] ?? 0,
                    'deleted_at' => null,
                    'author' => Auth::user()->name,
                    'created_by' => Auth::id()
                ]
            );
            DB::commit();
            return $document;
        } catch (ValidationException $e) {
            DB::rollBack();
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function uniqueBy()
    {
        return 'nomor_berkas';
    }
}
