<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tabel_jenis;
use App\tabel_mobil;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class JenisController extends Controller
{
    public function index($id_jenis)
    {
        if(Auth::user()->level=="admin"){
            $tabel_jenis=DB::table('jenis_mobil')
            ->where('jenis_mobil.id_mobil',$id)
            ->get();
            $count = $datas->count();
            return response()->json($tabel_jenis , $count);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_jenis'=>'required',
            'harga_perhari'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=tabel_jenis::create([
            'nama_jenis'=>$req->nama_jenis,
            'harga_perhari'=>$req->harga_perhari
        ]);
        $status=1;
        $message="Jenis Mobil Berhasil Ditambahkan";
        if($simpan){
          return Response()->json(compact('status','message'));
        }else {
          return Response()->json(['status'=>0]);
        }
      }
      else {
          return response()->json(['status'=>'anda bukan admin']);
      }
  }
    public function update($id_jenis,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'nama_jenis'=>'required',
                'harga_perhari'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=tabel_jenis::where('id_jenis',$id_jenis)->update([
            'nama_jenis'=>$request->nama_jenis,
            'harga_perhari'=>$request->harga_perhari
        ]);
        $status=1;
        $message="Jenis Mobil Berhasil Diubah";
        if($ubah){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
        }
    else {
    return response()->json(['status'=>'anda bukan admin']);
    }
}
    public function destroy($id_jenis){
        if(Auth::user()->level=="admin"){
        $hapus=tabel_jenis::where('id_jenis',$id_jenis)->delete();
        $status=1;
        $message="Jenis Mobil Berhasil Dihapus";
        if($hapus){
        return Response()->json(compact('status','message'));
        }else {
        return Response()->json(['status'=>0]);
        }
    }
    else {
        return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function tampil(){
        if(Auth::user()->level=="admin"){
            $datas = tabel_jenis::get();
            $count = $datas->count();
            $jenismobil = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $jenismobil[] = array(
                    'id_jenis' => $dt_jc->id_jenis,
                    'nama_jenis' => $dt_jc->nama_jenis,
                    'harga_perhari' => $dt_jc->harga_perhari
                );
            }
            return Response()->json(compact('count','jenismobil'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
