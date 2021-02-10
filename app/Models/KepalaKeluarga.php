<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaKeluarga extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'kepala_keluarga';

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_NAMA_KK = 'nama_kk';
    const ATTRIBUTE_NO_KK = 'no_kk';
    const ATTRIBUTE_NIK = 'nik';
    const ATTRIBUTE_ALAMAT = 'alamat';
    
    protected $guarded;

    protected $fillable = [
        self::ATTRIBUTE_ID,
        self::ATTRIBUTE_NAMA_KK,
        self::ATTRIBUTE_NO_KK,
        self::ATTRIBUTE_NIK,
        self::ATTRIBUTE_ALAMAT
    ];

    public function anggota_keluarga()
    {
        $this->hasMany(AnggotaKeluarga::class, AnggotaKeluarga::ATTRIBUTE_NO_KK, 'no_kk');
    }
}
