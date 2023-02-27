<?php

namespace App\Exports;

use App\Models\Klasifikasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KlasifikasiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data_klasifikasi = Klasifikasi::orderBy('kode_klasifikasi', 'ASC')->get();
        return view('exports.file.klasifikasi', compact('data_klasifikasi'));
    }
}
