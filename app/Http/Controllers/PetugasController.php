<?php

namespace App\Http\Controllers;

use App\tabel_petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth;

class PetugasController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',            
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required',
            'telp' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = tabel_petugas::create([
            'nama_petugas' => $request->get('nama_petugas'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level'),
            'telp' => $request->get('telp'),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
    public function update($id,Request $request){
        if(Auth::user()->level=="admin"){
        $validator=Validator::make($request->all(),
            [
                'nama_petugas' => 'required|string|max:255',            
                'username' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
                'level' => 'required',
                'telp' => 'required|string|max:255',
            ]
        );

        if($validator->fails()){
        return Response()->json($validator->errors());
        }

        $ubah=tabel_petugas::where('id',$id)->update([
            'nama_petugas' => $request->get('nama_petugas'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level'),
            'telp' => $request->get('telp'),
        ]);
        $status=1;
        $message="Data Petugas Berhasil Diubah";
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
        $hapus=tabel_petugas::where('id',$id)->delete();
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
            $datas = tabel_petugas::get();
            $count = $datas->count();
            $petugas = array();
            $status = 1;
            foreach ($datas as $dt_jc){
                $petugas[] = array(
                    'id' => $dt_jc->id,
                    'nama_petugas'=>$dt_jc->nama_petugas,
                    'username'=>$dt_jc->username,
                    'password'=>$dt_jc->password,
                    'telp'=>$dt_jc->telp,
                    'level'=>$dt_jc->level
                );
            }   
            return Response()->json(compact('count','petugas'));
        } else {
            return Response()->json(['status'=> 'Tidak bisa, anda bukan admin']);
        }
    }
}
