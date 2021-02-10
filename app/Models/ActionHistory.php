<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionHistory extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'action_history';

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_NO_KK = 'no_kk';
    const ATTRIBUTE_NAMA = 'nama';
    const ATTRIBUTE_NIK = 'nik';
    const ATTRIBUTE_ACTION = 'action';
    const ATTRIBUTE_TUJUAN_ASAL = 'tujuan_asal';
    const ATTRIBUTE_ALASAN = 'alasan';
    const ATTRIBUTE_TANGGAL = 'tanggal';
    
    protected $guarded;

    protected $fillable = [
        self::ATTRIBUTE_ID,
        self::ATTRIBUTE_NO_KK,
        self::ATTRIBUTE_NAMA,
        self::ATTRIBUTE_NIK,
        self::ATTRIBUTE_ACTION,
        self::ATTRIBUTE_TUJUAN_ASAL,
        self::ATTRIBUTE_ALASAN,
        self::ATTRIBUTE_TANGGAL
    ];

    public function anggota_keluarga()
    {
        $this->belongsTo(AnggotaKeluarga::class, AnggotaKeluarga::ATTRIBUTE_NO_KK, 'no_kk');
    }
}
