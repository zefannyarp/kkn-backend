<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'anggota_keluarga';

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_ID_KK = 'id_kk';
    const ATTRIBUTE_NO_KK = 'no_kk';
    const ATTRIBUTE_NAMA_AK = 'nama_ak';
    const ATTRIBUTE_NIK = 'nik';
    const ATTRIBUTE_JENIS_KELAMIN = 'jenis_kelamin';
    const ATTRIBUTE_TEMPAT_LAHIR = 'tempat_lahir';
    const ATTRIBUTE_TANGGAL_LAHIR = 'tanggal_lahir';
    const ATTRIBUTE_AGAMA = 'agama';
    const ATTRIBUTE_PENDIDIKAN = 'pendidikan';
    const ATTRIBUTE_JENIS_PEKERJAAN = 'jenis_pekerjaan';
    const ATTRIBUTE_STATUS_PERKAWINAN = 'status_perkawinan';
    const ATTRIBUTE_STATUS_HUBUNGAN_DALAM_KELUARGA = 'status_hubungan_dalam_keluarga';
    const ATTRIBUTE_KEWARGANEGARAAN = 'kewarganegaraan';
    const ATTRIBUTE_NAMA_AYAH = 'nama_ayah';
    const ATTRIBUTE_NAMA_IBU = 'nama_ibu';
    
    
    protected $guarded;

    protected $fillable = [
        self::ATTRIBUTE_ID,
        self::ATTRIBUTE_NO_KK,
        self::ATTRIBUTE_NAMA_AK,
        self::ATTRIBUTE_NIK,
        self::ATTRIBUTE_JENIS_KELAMIN,
        self::ATTRIBUTE_TEMPAT_LAHIR,
        self::ATTRIBUTE_TANGGAL_LAHIR,
        self::ATTRIBUTE_AGAMA,
        self::ATTRIBUTE_PENDIDIKAN,
        self::ATTRIBUTE_JENIS_PEKERJAAN,
        self::ATTRIBUTE_STATUS_PERKAWINAN,
        self::ATTRIBUTE_STATUS_HUBUNGAN_DALAM_KELUARGA,
        self::ATTRIBUTE_KEWARGANEGARAAN,
        self::ATTRIBUTE_NAMA_AYAH,
        self::ATTRIBUTE_NAMA_IBU
    ];

    public function kepala_keluarga()
    {
        $this->hasOne(KepalaKeluarga::class, KepalaKeluarga::ATTRIBUTE_NO_KK, 'no_kk');
    }

    public function action_history()
    {
        $this->hasOne(AnggotaKeluarga::class, AnggotaKeluarga::ATTRIBUTE_NO_KK, 'no_kk');
    }
}
