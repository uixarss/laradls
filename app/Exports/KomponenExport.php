<?php

namespace App\Exports;

use App\Models\Komponen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KomponenExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data_komponen = Komponen::orderBy('kode_komponen', 'ASC')->get();
        return view('exports.file.komponen', compact('data_komponen'));
    }
}
