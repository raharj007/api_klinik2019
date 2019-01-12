<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Keluhan;
use App\TransMedisFisik;
use App\TransPudji;
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
                'alamat' => $item->user->alamat_tinggal,
                'no_telp' => $item->user->no_telp,
            ];
        }
    	return response()->json($data, $this->successStatus);
    }
    
    public function getDetailAntrian($id) {
        $detail = Keluhan::find($id);
        return response()->json([
            'id' => $detail->id,
            'id_keluhan' => $detail->id_keluhan,
            'nama' => $detail->user->name,
            'deskripsi' => $detail->deskripsi,
            'tanggal' => $detail->tanggal,
            'alamat' => $detail->user->alamat_tinggal,
            'no_telp' => $detail->user->no_telp,
        ], $this->successStatus);
    }

    public function storePemeriksaanFisik(Request $request) {
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

        return $is_saved ? response()->json(['status' => 'Data berhasil disimpan'], $this->successStatus) : response()->json(['status' => 'Data gagal disimpan'], $this->successStatus);
    }

    public function storePoedjiRochjati(Request $request) {
        $trans_pudji = new TransPudji();
        $trans_pudji->users_id= $request->users_id;
        $trans_pudji->trans_keluhan_id = $request->trans_keluhan_id;
        $trans_pudji->terlalu_muda_hamil = $request->terlalu_muda_hamil;
        $trans_pudji->terlalu_tua_hamil = $request->terlalu_tua_hamil;
        $trans_pudji->terlalu_lambat_hamil = $request->terlalu_lambat_hamil;
        $trans_pudji->terlalu_lama_hamil_lagi = $request->terlalu_lama_hamil_lagi;
        $trans_pudji->terlalu_cepat_hamil_lagi = $request->terlalu_cepat_hamil_lagi;
        $trans_pudji->terlalu_banyak_anak = $request->terlalu_banyak_anak;
        $trans_pudji->terlalu_tua_umur = $request->terlalu_tua_umur;
        $trans_pudji->terlalu_pendek = $request->terlalu_pendek;
        $trans_pudji->pernah_gagal_kehamilan = $request->pernah_gagal_kehamilan;
        $trans_pudji->terikan_tang = $request->terikan_tang;
        $trans_pudji->uri_dirogoh = $request->uri_dirogoh;
        $trans_pudji->diberi_infus = $request->diberi_infus;
        $trans_pudji->pernah_operasi_sesar = $request->pernah_operasi_sesar;
        $trans_pudji->kurang_darah = $request->kurang_darah;
        $trans_pudji->malaria = $request->malaria;
        $trans_pudji->tbc = $request->tbc;
        $trans_pudji->payah = $request->payah;
        $trans_pudji->diabetes = $request->diabetes;
        $trans_pudji->penyakit_menular_seksual= $request->penyakit_menular_seksual;
        $trans_pudji->bengkak_pada_muka= $request->bengkak_pada_muka;
        $trans_pudji->hamil_kembar = $request->hamil_kembar;
        $trans_pudji->hydramnion = $request->hydramnion;
        $trans_pudji->bayi_mati_dalam_kandungan = $request->bayi_mati_dalam_kandungan;
        $trans_pudji->kehamilan_lebih_bulan = $request->kehamilan_lebih_bulan;
        $trans_pudji->letak_sungsang = $request->letak_sungsang;
        $trans_pudji->letak_lintang = $request->letak_lintang;
        $trans_pudji->perdarahan = $request->perdarahan;
        $trans_pudji->kehamilan_lebih_bulan = $request->kehamilan_lebih_bulan;
        $trans_pudji->preeklampsia = $request->preeklampsia;

        $trans_pudji->skor = 2
            + $trans_pudji->terlalu_muda_hamil
            + $trans_pudji->terlalu_tua_hamil
            + $trans_pudji->terlalu_lambat_hamil
            + $trans_pudji->terlalu_lama_hamil_lagi
            + $trans_pudji->terlalu_cepat_hamil_lagi
            + $trans_pudji->terlalu_banyak_anak
            + $trans_pudji->terlalu_tua_umur
            + $trans_pudji->terlalu_pendek
            + $trans_pudji->pernah_gagal_kehamilan
            + $trans_pudji->terikan_tang
            + $trans_pudji->uri_dirogoh
            + $trans_pudji->diberi_infus
            + $trans_pudji->pernah_operasi_sesar
            + $trans_pudji->kurang_darah
            + $trans_pudji->malaria
            + $trans_pudji->tbc
            + $trans_pudji->payah
            + $trans_pudji->diabetes
            + $trans_pudji->penyakit_menular_seksual
            + $trans_pudji->bengkak_pada_muka
            + $trans_pudji->hamil_kembar
            + $trans_pudji->hydramnion
            + $trans_pudji->bayi_mati_dalam_kandungan
            + $trans_pudji->kehamilan_lebih_bulan
            + $trans_pudji->letak_sungsang
            + $trans_pudji->letak_lintang
            + $trans_pudji->perdarahan
            + $trans_pudji->preeklampsia;
        $is_saved = $trans_pudji->save();

        return $is_saved ? response()->json(['status' => 'Data berhasil disimpan'], $this->successStatus) : response()->json(['status' => 'Data gagal disimpan'], $this->successStatus);
    }
}
