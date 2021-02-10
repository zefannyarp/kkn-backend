<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\KepalaKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\ActionHistory;
use Validator;

class AnggotaKeluargaController extends Controller
{
    public function addAnggotaKeluarga ($id, Request $request, KepalaKeluarga $kepalaKeluarga, AnggotaKeluarga $anggotaKeluarga, ActionHistory $actionHistory) {
        $nama_ak = $request->input('nama_ak');
        $nik = $request->input('nik');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $tempat_lahir = $request->input('tempat_lahir');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $agama = $request->input('agama');
        $pendidikan = $request->input('pendidikan');
        $jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $status_perkawinan = $request->input('status_perkawinan');
        $status_hubungan_dalam_keluarga = $request->input('status_hubungan_dalam_keluarga');
        $kewarganegaraan = $request->input('kewarganegaraan');
        $nama_ayah = $request->input('nama_ayah');
        $nama_ibu = $request->input('nama_ibu');
        $alasan = $request->input('alasan');
        $tujuan_asal = $request->input('asal');

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|unique:anggota_keluarga'
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        } else {
            $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
            $no_kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);

            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_ID_KK, $id);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NO_KK, $no_kk);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AK, $nama_ak);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NIK, $nik);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_JENIS_KELAMIN, $jenis_kelamin);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_TEMPAT_LAHIR, $tempat_lahir);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_TANGGAL_LAHIR, $tanggal_lahir);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_AGAMA, $agama);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_PENDIDIKAN, $pendidikan);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_JENIS_PEKERJAAN, $jenis_pekerjaan);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_PERKAWINAN, $status_perkawinan);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_HUBUNGAN_DALAM_KELUARGA, $status_hubungan_dalam_keluarga);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_KEWARGANEGARAAN, $kewarganegaraan);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AYAH, $nama_ayah);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_IBU, $nama_ibu);
            $anggotaKeluarga->save();

            $date = Carbon::now();

            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NO_KK, $no_kk);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NAMA, $nama_ak);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NIK, $nik);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ACTION, 'Masuk');
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TUJUAN_ASAL, $tujuan_asal);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ALASAN, $alasan);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TANGGAL, $date);
            $actionHistory->save();

            return response()->json($anggotaKeluarga, 201);
        }
    }

    public function editAnggotaKeluarga ($id, Request $request, AnggotaKeluarga $anggotaKeluarga) {
        $nama_ak = $request->input('nama_ak');
        $nik = $request->input('nik');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $tempat_lahir = $request->input('tempat_lahir');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $agama = $request->input('agama');
        $pendidikan = $request->input('pendidikan');
        $jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $status_perkawinan = $request->input('status_perkawinan');
        $status_hubungan_dalam_keluarga = $request->input('status_hubungan_dalam_keluarga');
        $kewarganegaraan = $request->input('kewarganegaraan');
        $nama_ayah = $request->input('nama_ayah');
        $nama_ibu = $request->input('nama_ibu');

        $anggotaKeluarga = AnggotaKeluarga::findOrFail($id);
        $niko = $anggotaKeluarga->getAttribute(AnggotaKeluarga::ATTRIBUTE_NIK);
        $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NIK, null);
        
        if ($nik != $niko) {

        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|unique:anggota_keluarga'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        } else {
            $anggotaKeluarga = AnggotaKeluarga::findOrFail($id);
            $anggotaKeluarga->update([
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AK, $nama_ak),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NIK, $nik),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_JENIS_KELAMIN, $jenis_kelamin),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_TEMPAT_LAHIR, $tempat_lahir),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_TANGGAL_LAHIR, $tanggal_lahir),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_AGAMA, $agama),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_PENDIDIKAN, $pendidikan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_JENIS_PEKERJAAN, $jenis_pekerjaan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_PERKAWINAN, $status_perkawinan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_HUBUNGAN_DALAM_KELUARGA, $status_hubungan_dalam_keluarga),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_KEWARGANEGARAAN, $kewarganegaraan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AYAH, $nama_ayah),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_IBU, $nama_ibu)
            ]);

            return response()->json($anggotaKeluarga, 200);
            } 
        } else {
             $anggotaKeluarga = AnggotaKeluarga::findOrFail($id);
            $anggotaKeluarga->update([
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AK, $nama_ak),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NIK, $nik),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_JENIS_KELAMIN, $jenis_kelamin),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_TEMPAT_LAHIR, $tempat_lahir),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_TANGGAL_LAHIR, $tanggal_lahir),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_AGAMA, $agama),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_PENDIDIKAN, $pendidikan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_JENIS_PEKERJAAN, $jenis_pekerjaan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_PERKAWINAN, $status_perkawinan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_HUBUNGAN_DALAM_KELUARGA, $status_hubungan_dalam_keluarga),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_KEWARGANEGARAAN, $kewarganegaraan),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AYAH, $nama_ayah),
                $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_IBU, $nama_ibu)
            ]);

            return response()->json($anggotaKeluarga, 200);
        }
    }

    public function getAnggotaKeluarga($id) {
        return AnggotaKeluarga::findOrFail($id);
    }

    public function getAnggotaKeluargaID($id) {
        AnggotaKeluarga::findOrFail($id);

        $anggotaKeluarga = $anggotaKeluarga->getAttribute(AnggotaKeluarga::ATTRIBUTE_ID);
        return $anggotaKeluarga;
    }

    public function deleteAnggotaKeluarga ($id, Request $request, AnggotaKeluarga $anggotaKeluarga, ActionHistory $actionHistory, KepalaKeluarga $kepalaKeluarga) {
        $tujuan_asal = $request->input('tujuan_asal');
        $alasan = $request->input('alasan');

        $anggotaKeluarga = AnggotaKeluarga::findOrFail($id);

        $no_kk = $anggotaKeluarga->getAttribute(AnggotaKeluarga::ATTRIBUTE_NO_KK);
        $nama_ak = $anggotaKeluarga->getAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AK);
        $nik = $anggotaKeluarga->getAttribute(AnggotaKeluarga::ATTRIBUTE_NIK);
        
        $id_kk = $anggotaKeluarga->getAttribute(AnggotaKeluarga::ATTRIBUTE_ID_KK);

        $date = Carbon::now();
        
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NO_KK, $no_kk);
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NAMA, $nama_ak);
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NIK, $nik);
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ACTION, 'Pindah');
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TUJUAN_ASAL, $tujuan_asal);
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ALASAN, $alasan);
        $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TANGGAL, $date);
        $actionHistory->save();

        $anggotaKeluarga->delete();

        $hoho = [
            "id_kk" => $id_kk
        ];

        $hehe = $anggotaKeluarga->where('id_kk', 'LIKE', '%' . $id_kk . '%')->get();

        

        $pop = $anggotaKeluarga->where('status_hubungan_dalam_keluarga', 'LIKE', '%' . 'Kepala Keluarga' . '%')->get();

        if (count($pop) == 0) {
            $anggotaKeluarga->where('id_kk', 'LIKE', '%' . $id_kk . '%')->delete();

            $kepalaKeluarga->where('id', 'LIKE', '%' . $id_kk . '%')->delete();

            return response()->json($hoho, 203);
        } else {
            $hehe = $anggotaKeluarga->where('id_kk', 'LIKE', '%' . $id_kk . '%')->get();

            if (count($hehe) == 0 ) {
                $kepalaKeluarga = $kepalaKeluarga->where('id', 'LIKE', '%' . $id_kk . '%')->delete();
                
                return response()->json($hoho, 200);
            } else {

                return response()->json($hoho, 200);
            }
        }
    }
}
