<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komponen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_komponen', 'name', 'deleted_at'
    ];
}
