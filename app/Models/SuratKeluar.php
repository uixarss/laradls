<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Klasifikasi;
use App\Models\Lampiran;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Helpers\Utils;
use Illuminate\Support\Carbon;

class SuratKeluar extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'nama_penerima',
        'tanggal_surat',
        'nomor_surat',
        'isi_ringkas',
        'indeks_berkas',
        'kd_klasifikasi',
        'no_agenda',
        'jenis_surat',
        'dikirim_oleh',
        'tanggal_dikirim',
        'keterangan',
        'status',
        'file_lokasi',
        'created_by',
        'updated_by',
    ];

    public function indeks()
    {
        return $this->belongsTo(Klasifikasi::class, 'indeks_berkas', 'kode_klasifikasi');
    }

    public function kode()
    {
        return $this->belongsTo(Klasifikasi::class, 'kd_klasifikasi', 'kode_klasifikasi');
    }

    public function lampirans()
    {
        return $this->morphMany(Lampiran::class, 'lampiranable');
    }

    public function urut(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => sprintf("%03s", $this->no_agenda),
        );
    }

    public function jenis()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat', 'kode');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function nomor(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>  $this->urut . '/' . $this->kode->kode_klasifikasi . '/' . Utils::convertToRoman(Carbon::parse($this->tanggal_surat)->format('m')) . '/' . Carbon::parse($this->tanggal_surat)->format('Y')
        );
    }
}
