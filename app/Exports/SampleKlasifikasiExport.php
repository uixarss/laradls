<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SampleKlasifikasiExport implements FromView
{
   
    public function view(): View
    {
        return view('exports.sample.klasifikasi');
    }
}
