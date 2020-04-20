<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::get('/petugas', 'PetugasController@tampil')->middleware('jwt.verify');
Route::put('/update_petugas/{id}', 'PetugasController@update')->middleware('jwt.verify');
Route::delete('/hapus_petugas/{id}', 'PetugasController@destroy')->middleware('jwt.verify');

//CRUD Penyewa
Route::post('/create_penyewa', 'PenyewaController@store')->middleware('jwt.verify');
Route::get('/penyewa', 'PenyewaController@tampil')->middleware('jwt.verify');
Route::put('/update_penyewa/{id}', 'PenyewaController@update')->middleware('jwt.verify');
Route::delete('/hapus_penyewa/{id}', 'PenyewaController@destroy')->middleware('jwt.verify');

Route::post('/create_mobil', 'MobilController@store')->middleware('jwt.verify');
Route::get('/mobil', 'MobilController@tampil')->middleware('jwt.verify');
Route::put('/update_mobil/{id}', 'MobilController@update')->middleware('jwt.verify');
Route::delete('/hapus_mobil/{id}', 'MobilController@destroy')->middleware('jwt.verify');

Route::post('/create_jenis', 'JenisController@store')->middleware('jwt.verify');
Route::get('/jenis', 'JenisController@tampil')->middleware('jwt.verify');
Route::put('/update_jenis/{id_jenis}', 'JenisController@update')->middleware('jwt.verify');
Route::delete('/hapus_jenis/{id}', 'JenisController@destroy')->middleware('jwt.verify');


    