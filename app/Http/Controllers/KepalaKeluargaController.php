<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\KepalaKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\ActionHistory;
use Validator;

class KepalaKeluargaController extends Controller
{
    public function addKepalaKeluarga (Request $request, KepalaKeluarga $kepalaKeluarga, AnggotaKeluarga $anggotaKeluarga, ActionHistory $actionHistory) {
        $nama_kk = $request->input('nama_kk');
        $no_kk = $request->input('no_kk');
        $nik = $request->input('nik');
        $alamat = $request->input('alamat');
        $tujuan_asal = $request->input('asal');
        $alasan = $request->input('alasan');
        
        $validator = Validator::make($request->all(), [
            'no_kk' => 'required|string|unique:kepala_keluarga',
            'nik' => 'required|string|unique:kepala_keluarga',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        } else {
            $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NAMA_KK, $nama_kk);
            $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK, $no_kk);
            $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NIK, $nik);
            $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_ALAMAT, $alamat);
            $kepalaKeluarga->save();
            
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_ID_KK, $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_ID));
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NO_KK, $no_kk);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NIK, $nik);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_NAMA_AK, $nama_kk);
            $anggotaKeluarga->setAttribute(AnggotaKeluarga::ATTRIBUTE_STATUS_HUBUNGAN_DALAM_KELUARGA, 'Kepala Keluarga');
            $anggotaKeluarga->save();

            $date = Carbon::now();

            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NO_KK, $no_kk);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NAMA, $nama_kk);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_NIK, $nik);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ACTION, 'Masuk');
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TUJUAN_ASAL, $tujuan_asal);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_ALASAN, $alasan);
            $actionHistory->setAttribute(ActionHistory::ATTRIBUTE_TANGGAL, $date);
            $actionHistory->save();

            return response()->json($kepalaKeluarga, 201);
        }
    }

    public function editKepalaKeluarga ($id, Request $request, KepalaKeluarga $kepalaKeluarga, AnggotaKeluarga $anggotaKeluarga) {
        $nama_kk = $request->input('nama_kk');
        $no_kk = $request->input('no_kk');
        $alamat = $request->input('alamat');
        $nik = $request->input('nik');

        $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
        $no_kuku = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);

        $nok = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NIK);

        if ($no_kk == $no_kuku & $nik == $nok) {
            $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
            $kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);
    
            AnggotaKeluarga::where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')
            ->update(['nama_ak' => $nama_kk,
            'nik' => $nik]);

            AnggotaKeluarga::where('no_kk', $kk)
            ->update(['no_kk' => $no_kk]); 

            $kepalaKeluarga->update([
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NAMA_KK, $nama_kk),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK, $no_kk),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_ALAMAT, $alamat),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NIK, $nik)
            ]);

            return response()->json([
                'message' => 'kepala keluarga has been edited'
            ], 200);
        } else {
            if ($no_kk == $no_kuku & $nik != $nok) {

            $validator = Validator::make($request->all(), [
                'nik' => 'required|string|unique:anggota_keluarga|unique:kepala_keluarga',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 400);
            } else {
            $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
            $kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);
    
            AnggotaKeluarga::where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')
            ->update(['nama_ak' => $nama_kk,
            'nik' => $nik]);

            AnggotaKeluarga::where('no_kk', $kk)
            ->update(['no_kk' => $no_kk]); 

            $kepalaKeluarga->update([
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NAMA_KK, $nama_kk),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK, $no_kk),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_ALAMAT, $alamat),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NIK, $nik)
            ]);

            return response()->json([
                'message' => 'kepala keluarga has been edited'
            ], 200);
            }
        } else {
            if ($no_kk != $no_kuku & $nik == $nok) {
                $validator = Validator::make($request->all(), [
                    'no_kk' => 'required|string|unique:kepala_keluarga'
                ]);
                
                if ($validator->fails()) {
                    return response()->json($validator->errors()->toJson(), 400);
                } else {
                    $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
                    $kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);
            
                    AnggotaKeluarga::where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')
                    ->update(['nama_ak' => $nama_kk,
                    'nik' => $nik]);
        
                    AnggotaKeluarga::where('no_kk', $kk)
                    ->update(['no_kk' => $no_kk]); 
        
                    $kepalaKeluarga->update([
                        $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NAMA_KK, $nama_kk),
                        $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK, $no_kk),
                        $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_ALAMAT, $alamat),
                        $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NIK, $nik)
                    ]);
        
                    return response()->json([
                        'message' => 'kepala keluarga has been edited'
                    ], 200);
                }
            }
        } 
        }
        $validator = Validator::make($request->all(), [
            'no_kk' => 'required|string|unique:kepala_keluarga',
            'nik' => 'required|string|unique:anggota_keluarga',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        } else {
            $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
            $kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);
    
            AnggotaKeluarga::where('status_hubungan_dalam_keluarga', 'Kepala Keluarga')
            ->update(['nama_ak' => $nama_kk,
            'nik' => $nik]);

            AnggotaKeluarga::where('no_kk', $kk)
            ->update(['no_kk' => $no_kk]); 

            $kepalaKeluarga->update([
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NAMA_KK, $nama_kk),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK, $no_kk),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_ALAMAT, $alamat),
                $kepalaKeluarga->setAttribute(KepalaKeluarga::ATTRIBUTE_NIK, $nik)
            ]);

            return response()->json([
                'message' => 'kepala keluarga has been edited'
            ], 200);
        }
    }

    public function deleteKepalaKeluarga($id, KepalaKeluarga $kepalaKeluarga, AnggotaKeluarga $anggotaKeluarga)
    {
        $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
        $kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);
        $act = $anggotaKeluarga->where('no_kk', 'LIKE', '%' . $kk . '%')->get();
        
        $act->delete();
        $kepalaKeluarga->delete();
        return response()->json([
            'message' => 'kepala keluarga has been deleted'
        ], 200);
    }

    public function searchKepalaKeluarga (Request $request, KepalaKeluarga $kepalaKeluarga) {
        $input = $request->input('input');

        $kk = KepalaKeluarga::where('nama_kk', 'LIKE', '%' . $input . '%')
        ->orWhere('no_kk', 'LIKE', '%' . $input . '%')
        // etc
        ->get();

        return response()->json($kk);
    }

    public function showAllKepalaKeluarga (KepalaKeluarga $kepalaKeluarga) {
        $jumlahKK = KepalaKeluarga::count();
        $kepalaKeluarga = KepalaKeluarga::all();

        $response = [
            'jumlah_kk' => $jumlahKK
        ];

        return response()->json([
            'kepala_keluarga' => $kepalaKeluarga, 
            'jumlah_kk' => $response
        ]);
    }

    public function getKepalaKeluargaDetails($id, AnggotaKeluarga $anggotaKeluarga, KepalaKeluarga $kepalaKeluarga)
    {
        $kepalaKeluarga = KepalaKeluarga::findOrFail($id);
        
        $nama_kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NAMA_KK);
        $no_kk = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_NO_KK);
        $alamat = $kepalaKeluarga->getAttribute(KepalaKeluarga::ATTRIBUTE_ALAMAT);

        $data = [
            'nama_kk' => $nama_kk,
            'no_kk' => $no_kk,
            'alamat' => $alamat
        ];

        $anggotaKeluarga = AnggotaKeluarga::where(AnggotaKeluarga::ATTRIBUTE_ID_KK, $id)->get();
        
        return response()->json([
            'anggota_keluarga' => $anggotaKeluarga,
            'data' => $data
        ]);
    }

    public function getKepalaKeluarga($id) {
        return KepalaKeluarga::findOrFail($id);
    }

}
