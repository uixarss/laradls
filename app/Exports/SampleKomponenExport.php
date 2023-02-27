<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SampleKomponenExport implements FromView
{
    public function view(): View
    {
        return view('exports.sample.komponen');
    }
}
