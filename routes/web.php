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

Route::get('/', 'Dashboard@index')->middleware('auth')->name('Dashboard');

Route::resource('promotion','Promotion')->middleware('auth');
Route::get('promotion/searchitem/{req}','Promotion@itemresponse')->middleware('auth')->name('Promotion.searchitem');
Route::get('promotion/getitemdetail/{com}/{req}','Promotion@itemdetailresponse')->middleware('auth')->name('Promotion.getitemdetail');
Route::get('promotion/getcustomer/{req}','Promotion@customergroupresponse')->middleware('auth')->name('Promotion.getcustomer');
Route::get('promotion/getcustomersub/{req}','Promotion@customersubresponse')->middleware('auth')->name('Promotion.getcustomersub');
Route::resource('approve','Approve_Act');

Route::group(['prefix'=>'setting','middleware'=>['auth']],function(){
  Route::resource('authorize','Setting\Authorize');
  Route::resource('promotionmt','Setting\Promotion');
  Route::resource('expense','Setting\Expense');
  Route::resource('approvelmt','Setting\Approveal');
});

Auth::routes();
