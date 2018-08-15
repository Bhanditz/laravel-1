<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'PromoController@index');

/* Promo routes */
Route::resource('promo', 'PromoController');
Route::get('getpromodata', 'PromoController@getData');
Route::get('delpromodata', 'PromoController@destroy');

/* Prize routes */
Route::resource('prize', 'PrizeController');
Route::get('getprizedata', 'PrizeController@getData');
Route::get('delprizedata', 'PrizeController@destroy');

/* Records routes */
Route::resource('records', 'RecordsController');
Route::post('generatetickets', 'RecordsController@generateTickets');
Route::get('viewrecordsdata', 'RecordsController@viewRecordsData');
Route::post('viewrecordsmetadata', 'RecordsController@viewRecordsMetaData');
Route::get('getrecordsdata', 'RecordsController@getData');
Route::get('delrecordsdata', 'RecordsController@destroy');
Route::get('delrecordsmetadata', 'RecordsController@delRecordData');

/* Layout routes */
Route::resource('layout', 'LayoutController');
Route::get('getpromoprizedata', 'LayoutController@getPrize');