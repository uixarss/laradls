<?php
namespace App\Services;

use App\Models\Komponen;
use Illuminate\Http\Request;

class KomponenService
{
    public function createKomponen(Request $request): Komponen
    {
        $komponen = Komponen::create([
            'kode_komponen' => $request->kode_komponen,
            'name' => $request->name
        ]);
        return $komponen;
    }
}