<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lokasi;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Klasifikasi;

class Document extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'deleted_at' => 'datetime:Y-m-d H:i',
    ];
    protected $fillable = [
        'uuid','kode_klasifikasi', 'title', 
        'description', 'location_file', 'offline_location',
        'nomor_berkas', 'published_at', 'jumlah',
        'author', 'offline_location', 'status',
        'deleted_at', 'created_by', 'updated_by'
    ];

    protected $dates = ['deleted_at'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function lokasi()
    {
        return $this->belongsToMany(Lokasi::class, 'lokasi_documents' ,'id', 'document_id')
        ->withPivot('name', 'created_by', 'updated_by')
    	->withTimestamps();;
    }

    public function klasifikasi()
    {
        return $this->belongsTo(Klasifikasi::class, 'kode_klasifikasi' ,'kode_klasifikasi');
    }
}
