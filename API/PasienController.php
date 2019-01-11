<?php

namespace App\Http\Controllers\API;

use App\Masukan;
use App\TransMedisFisik;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Keluhan;
use Validator;

class PasienController extends Controller
{
    public $successStatus = 200;

    public function getPasienByID($id) {
		$user = User::find($id);
		return response()->json($user, $this->successStatus);
    }

    public function getListKeluhanByID($id) {
    	$keluhan = Keluhan::where('id', $id)->get();
        $data = [];
        foreach ($keluhan as $item) {
            $data[] = [
                'id_user' => $item->id,
                'id_keluhan' => $item->id_keluhan,
                'nama' => $item->user->name,
                'deskripsi' => $item->deskripsi,
                'tanggal' => $item->tanggal,
            ];
        }
        return response()->json($data, $this->successStatus);
    }

    public function getDetailsKeluhanByID($id) {
        $detail = Keluhan::find($id);
        return response()->json([
            'id_user' => $detail->id,
            'id_keluhan' => $detail->id_keluhan,
            'nama' => $detail->user->name,
            'deskripsi' => $detail->deskripsi,
            'tanggal' => $detail->tanggal,
        ], $this->successStatus);
    }
    
    public function storeKeluhan(Request $request) {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => $validator->errors()], 401);
        }

        $keluhan = new Keluhan();
        $keluhan->id = $request->id;
        $keluhan->deskripsi = $request->deskripsi;
        $keluhan->tanggal = $request->tanggal;
        if ($keluhan->save()) {
            $success['status'] = 'data berhasil dimasukkan';
            return response()->json(['status' => $success['status']], $this->successStatus);
        } else {
            $success['status'] = 'data gagal dimasukkan';
            return response()->json(['status' => $success['status']], 401);
        }
    }

    public function getListRekamMedic($id) {
        $rekamMedic = TransMedisFisik::where('users_id', $id)->get();
        $data = [];
        foreach ($rekamMedic as $item) {
            $data[] = [
                'id' => $item->id,
                'trans_keluhan_id' => $item->trans_keluhan_id,
                'users_id' => $item->users_id,
                'tgl_pemeriksaan' => $item->tgl_pemeriksaan,
                'deskripsi' => $item->keluhan->deskripsi,
            ];
        }
        return response()->json($data, $this->successStatus);
    }

    public function getDetailsRekamMedicByID($id) {
        $detail = TransMedisFisik::find($id);
        return response()->json($detail, $this->successStatus);
    }

    public function getDetailsTabelPoedjiRochjatiByID() {

    }

    public function storeKritikSaran(Request $request) {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => $validator->errors()], 401);
        }

        $kritik_saran = new Masukan();
        $kritik_saran->id_user = $request->id_user;
        $kritik_saran->deskripsi = $request->deskripsi;
        $kritik_saran->tanggal = $request->tanggal;
        if ($kritik_saran->save()) {
            $success['status'] = 'data berhasil dimasukkan';
            return response()->json(['status' => $success['status']], $this->successStatus);
        } else {
            $success['status'] = 'data gagal dimasukkan';
            return response()->json(['status' => $success['status']], 401);
        }
    }
}
