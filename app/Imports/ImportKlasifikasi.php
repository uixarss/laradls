<?php

namespace App\Imports;

use App\Models\Klasifikasi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Validators\ValidationException;

class ImportKlasifikasi implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, WithUpserts, ShouldQueue
{

    use Importable;

    public function model(array $row)
    {
        try {

            DB::beginTransaction();
            $klasifikasi = Klasifikasi::withTrashed()->updateOrCreate(
                [
                    'kode_klasifikasi' => $row['kode']
                ],
                [
                    'name' => $row['nama'] ?? '-',
                    'deleted_at' => null,
                ]
            );
            DB::commit();
            return $klasifikasi;
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
        return 'kode_klasifikasi';
    }
}
