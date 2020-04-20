<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tabel_mobil;
use App\tabel_jenis;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class MobilController extends Controller
{
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $jeniscuci=DB::table('mobil')
            ->where('mobil.id',$id)
            ->get();
            $count = $datas->count();
            return response()->json($jeniscuci , $count);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama_mobil'=>'required',
            'plat_mobil'=>'required',
            'kondisi'=>'required',
            'id_jenis_mobil'=>'required'
        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=tabel_mobil::create([
            'nama_mobil'=>$req->nama_mobil,
            'plat_mobil'=>$req->plat_mobil,
            'kondisi'=>$req->kondisi,
            'id_jenis_mobil'=>$req->id_jenis_mobil,

        ]);
        $status=1;
        $message="Mobil Berhasil Ditambahkan";
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
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'nama_mobil'=>'required',
                'plat_mobil'=>'required',
                'kondisi'=>'required',
                'id_jenis_mobil'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=tabel_mobil::where('id_mobil',$id)->update([
            'nama_mobil'=>$request->nama_mobil,
            'plat_mobil'=>$request->plat_mobil,
            'kondisi'=>$request->kondisi,
            'id_jenis_mobil'=>$request->id_jenis_mobil,
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
    public function destroy($id){
        if(Auth::user()->level=="admin"){
        $hapus=tabel_mobil::where('id_mobil',$id)->delete();
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
            $datas = tabel_mobil::get();
            $count = $datas->count();
            $mobil = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $mobil[] = array(
                    'id_mobil' => $dt_jc->id_mobil,
                    'nama_mobil'=>$dt_jc->nama_mobil,
                    'plat_mobil'=>$dt_jc->plat_mobil,
                    'kondisi'=>$dt_jc->kondisi,
                    'id_jenis_mobil'=>$dt_jc->id_jenis_mobil
                );
            }
            return Response()->json(compact('count','mobil'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
