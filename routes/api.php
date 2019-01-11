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
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('details', 'API\UserController@details');

Route::group(['middleware' => ['pasien']], function() {
    Route::get('pasien/profile/{id}', 'API\PasienController@getPasienByID');
    Route::get('pasien/keluhan/{id}', 'API\PasienController@getListKeluhanByID');
    Route::get('pasien/keluhan/detail/{id}', 'API\PasienController@getDetailsKeluhanByID');
    Route::post('pasien/keluhan', 'API\PasienController@storeKeluhan');
    Route::get('pasien/rekammedis/{id}', 'API\PasienController@getListRekamMedic');
    Route::get('pasien/rekammedis/detail/{id}', 'API\PasienController@getDetailsRekamMedicByID');
    Route::post('pasien/kritiksaran', 'API\PasienController@storeKritikSaran');
});

Route::group(['middleware' => ['dokter']], function() {
	Route::get('dokter/profile/{id}', 'API\DokterController@getDokterByID');
	Route::get('dokter/antrian', 'API\DokterController@getAntrianPasien');
	Route::get('dokter/antrian/detail/{id}', 'API\DokterController@getDetailAntrian');
});
