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

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
//Route::get('ee', function () {
//    return \Carbon\Carbon::createFromTimestamp(1542966338753.5/1000);
//});
//Route::get('ee1', function () {
//     $time    = microtime(true);
//     return $time*1000;
//});
