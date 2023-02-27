<?php

namespace App\Exports;

use App\Models\Document;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DocumentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data_document = Document::orderBy('created_at', 'ASC')->get();
        return view('exports.file.document', compact('data_document'));
    }
}
