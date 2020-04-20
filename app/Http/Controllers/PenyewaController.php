<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tabel_penyewa;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;

class PenyewaController extends Controller
{
    
    public function index($id)
    {
        if(Auth::user()->level=="admin"){
            $jeniscuci=DB::table('penyewa')
            ->where('penyewa.id',$id)
            ->get();
            return response()->json($jeniscuci);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
    public function store(Request $req)
    {
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($req->all(),
        [
            'nama'=>'required',
            'nik'=>'required',
            'foto_ktp'=>'required',
            'telp'=>'required',
            'alamat'=>'required'

        ]
        );
        if($validator->fails()){
            return Response()->json($validator->errors());
        }

        $simpan=tabel_penyewa::create([
            'nama'=>$req->nama,
            'nik'=>$req->nik,
            'foto_ktp'=>$req->foto_ktp,
            'telp'=>$req->telp,
            'alamat'=>$req->alamat

        ]);
        $status=1;
        $message="Data Penyewa Berhasil Ditambahkan";
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
                'nama'=>'required',
                'nik'=>'required',
                'foto_ktp'=>'required',
                'telp'=>'required',
                'alamat'=>'required'
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=tabel_penyewa::where('id',$id)->update([
            'nama'=>$request->nama,
            'nik'=>$request->nik,
            'foto_ktp'=>$request->foto_ktp,
            'telp'=>$request->telp,
            'alamat'=>$request->alamat
        ]);
        $status=1;
        $message="Data Penyewa Berhasil Diubah";
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
        $hapus=tabel_penyewa::where('id',$id)->delete();
        $status=1;
        $message="Data Penyewa Berhasil Dihapus";
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
            $datas = tabel_penyewa::get();
            $count = $datas->count();
            $penyewa = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $penyewa[] = array(
                    'id' => $dt_jc->id,
                    'nama'=>$dt_jc->nama,
                    'nik'=>$dt_jc->nik,
                    'foto_ktp'=>$dt_jc->foto_ktp,
                    'telp'=>$dt_jc->telp,
                    'alamat'=>$dt_jc->alamat
                );
            }
            return Response()->json(compact('count','penyewa'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
