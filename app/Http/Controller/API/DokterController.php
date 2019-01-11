<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Keluhan;
use App\TransMedisFisik;
use App\Masukan;
use Validator;

class DokterController extends Controller
{
    public $successStatus = 200;

    public function getDokterByID($id) {
    	$user = User::find($id);
    	return response()->json($user, $this->successStatus);
    }

    public function getAntrianPasien() {
    	$now = \Carbon\Carbon::today();
    	$now = $now->toDateString();
    	$antrian = Keluhan::where('tanggal', $now)->get();
    	$data = [];
    	foreach ($antrian as $item) {
            $data[] = [
                'id' => $item->id,
                'id_keluhan' => $item->id_keluhan,
                'nama' => $item->user->name,
                'deskripsi' => $item->deskripsi,
                'tanggal' => $item->tanggal,
                'no_telp' => $item->user->no_telp,
            ];
        }
    	return response()->json($data, $this->successStatus);
    }
    
    public function getDetailAntrian($id) {
        $detail = Keluhan::find($id);
        $pasien = User::find($detail->id);
        return response()->json([
            'id' => $detail->id,
            'id_keluhan' => $detail->id_keluhan,
            'nama' => $pasien->name,
            'deskripsi' => $detail->deskripsi,
            'tanggal' => $detail->tanggal,
            'no_telp' => $pasien->no_telp,
        ], $this->successStatus);
    }

    public function storePemeriksaanFisik(Request $request) {
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['sukses' => 'Data belum lengkap'], $this->successStatus);
        }

        $periksa = new TransMedisFisik();
        $periksa->users_id = $request->users_id;
        $periksa->trans_keluhan_id = $request->trans_keluhan_id;
        $periksa->tekanan_darah_atas = $request->tekanan_darah_atas;
        $periksa->tekanan_darah_bawah = $request->tekanan_darah_bawah;
        $periksa->berat_badan = $request->berat_badan;
        $periksa->tinggi_badan = $request->tinggi_badan;
        $periksa->riwayat_penyakit = $request->riwayat_penyakit;
        $periksa->riwayat_alergi = $request->riwayat_alergi;
        $periksa->subjective = $request->subjective;
        $periksa->objective = $request->objective;
        $periksa->diagnosa = $request->diagnosa;
        $periksa->planning = $request->planning;
        $periksa->tgl_periksa_selanjutnya = $request->tgl_periksa_selanjutnya;
        $is_saved = $periksa->save();

        return $is_saved ? response()->json(['sukses' => 'Data berhasil disimpan'], $this->successStatus) : response()->json(['sukses' => 'Data gagal disimpan'], $this->successStatus);
    }

    public function storePoedjiRochjati(Request $request) {

    }
}
