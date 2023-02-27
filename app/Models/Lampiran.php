<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Lampiran extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'file_lokasi',
        'lampiranable_type', 'lampiranable_id',
        'created_by', 'updated_by'
    ];

    public function urlFile(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Storage::url($this->file_lokasi),
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
