<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RiwayatSuratKeluar extends Model
{
    use HasFactory;
    const TERKIRIM = '<span class="svg-icon svg-icon-muted svg-icon-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
        viewBox="0 0 24 24" fill="none">
        <path
            d="M9.89557 13.4982L7.79487 11.2651C7.26967 10.7068 6.38251 10.7068 5.85731 11.2651C5.37559 11.7772 5.37559 12.5757 5.85731 13.0878L9.74989 17.2257C10.1448 17.6455 10.8118 17.6455 11.2066 17.2257L18.1427 9.85252C18.6244 9.34044 18.6244 8.54191 18.1427 8.02984C17.6175 7.47154 16.7303 7.47154 16.2051 8.02984L11.061 13.4982C10.7451 13.834 10.2115 13.834 9.89557 13.4982Z"
            fill="currentColor" />
    </svg>
</span>
Terkirim';

    const DITERIMA = '<span class="svg-icon svg-icon-primary svg-icon-2">
    
<svg width="25" height="16" viewBox="0 0 25 16" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.9333 4L6.59993 11.3333L3.2666 8" stroke="#74B169" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M21.9333 4L14.5999 11.3333L11.2666 8" stroke="#74B169" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>


</span>Diterima';

    const PENDING = '
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_667_16674)">
    <path d="M8 12V14.6667" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M10.8271 10.8267L12.7138 12.7133" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M3.28711 12.7133L5.17378 10.8267" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M12 8H14.6667" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M1.33301 8H3.99967" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M10.8271 5.17329L12.7138 3.28662" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M3.28711 3.28662L5.17378 5.17329" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M8 1.33325V3.99992" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </g>
    <defs>
    <clipPath id="clip0_667_16674">
    <rect width="16" height="16" fill="white"/>
    </clipPath>
    </defs>
    </svg>
    PENDING';

    const PROSES = '
    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M13.3337 4.5L6.00033 11.8333L2.66699 8.5" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    PROSES';

    const REVISI = '
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M8 13.3333H14" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M11 2.3334C11.2652 2.06819 11.6249 1.91919 12 1.91919C12.1857 1.91919 12.3696 1.95577 12.5412 2.02684C12.7128 2.09791 12.8687 2.20208 13 2.3334C13.1313 2.46472 13.2355 2.62063 13.3066 2.79221C13.3776 2.96379 13.4142 3.14769 13.4142 3.3334C13.4142 3.51912 13.3776 3.70302 13.3066 3.8746C13.2355 4.04618 13.1313 4.20208 13 4.3334L4.66667 12.6667L2 13.3334L2.66667 10.6667L11 2.3334Z" stroke="#92929D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    REVISI';



    protected $fillable = [
        'kd_surat', 'diteruskan_kepada', 'catatan', 'status',
        'tanggal_disahkan', 'created_by', 'updated_by'
    ];
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function by()
    {
        return $this->belongsTo(User::class, 'diteruskan_kepada', 'id');
    }

    public function from()
    {
        return $this->belongsTo(SuratMasuk::class, 'kd_surat', 'uuid');
    }

    public function scopeFilter($query, $value)
    {
        return $query->whereIn('created_by', $value);
    }

    public function scopeActive($query)
    {
        return $query->where('diteruskan_kepada', '=', Auth::id());
    }
}
