<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klasifikasi extends Model
{
    use SoftDeletes;

    // protected static $logAttributes = [
    //     'name', 'kode_klasifikasi'
    // ];
    // protected static $ignoreChangedAttributes = [
    //     'created_at'
    // ];

    // protected static $recordEvents = ['created', 'updated', 'deleted'];

    // protected static $logOnlyDirty = true;
    // protected static $logName = 'klasifikasi';

    // public function getDescriptionForEvent(string $eventName): string
    // {
    //     return "You have {$eventName} klasifikasi";
    // }

    // public function getActivitylogOptions(): LogOptions
    // {
    //     return LogOptions::defaults();
    // }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'deleted_at' => 'datetime:Y-m-d H:i',
    ];
    protected $fillable = [
        'kode_klasifikasi', 'name', 'deleted_at'
    ];

    protected $dates = ['deleted_at'];
}
