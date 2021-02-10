<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//KepalaKeluarga
Route::get('/getKepalaKeluarga/{id}', 'App\Http\Controllers\KepalaKeluargaController@getKepalaKeluarga');
Route::get('/showAllKepalaKeluarga', 'App\Http\Controllers\KepalaKeluargaController@showAllKepalaKeluarga');
Route::post('/addKepalaKeluarga', 'App\Http\Controllers\KepalaKeluargaController@addKepalaKeluarga');
Route::post('/tes/{id}', 'App\Http\Controllers\KepalaKeluargaController@deleteKepalaKeluarga');
Route::post('/searchKepalaKeluarga', 'App\Http\Controllers\KepalaKeluargaController@searchKepalaKeluarga');
Route::post('/editKepalaKeluarga/{id}', 'App\Http\Controllers\KepalaKeluargaController@editKepalaKeluarga');
Route::get('/getKepalaKeluargaDetails/{id}', 'App\Http\Controllers\KepalaKeluargaController@getKepalaKeluargaDetails');

//AnggotaKeluarga
Route::post('/addAnggotaKeluarga/{id}', 'App\Http\Controllers\AnggotaKeluargaController@addAnggotaKeluarga');
Route::post('/editAnggotaKeluarga/{id}', 'App\Http\Controllers\AnggotaKeluargaController@editAnggotaKeluarga');
Route::post('/deleteAnggotaKeluarga/{id}', 'App\Http\Controllers\AnggotaKeluargaController@deleteAnggotaKeluarga');
Route::get('/getAnggotaKeluarga/{id}', 'App\Http\Controllers\AnggotaKeluargaController@getAnggotaKeluarga');
Route::get('/getAnggotaKeluargaID/{id}', 'App\Http\Controllers\AnggotaKeluargaController@getAnggotaKeluargaID');

//History
Route::get('/showHistory', 'App\Http\Controllers\ActionHistoryController@showHistory');
Route::post('/editAction/{id}', 'App\Http\Controllers\ActionHistoryController@editAction');
Route::get('/getActionHistory/{id}', 'App\Http\Controllers\ActionHistoryController@getActionHistory');


