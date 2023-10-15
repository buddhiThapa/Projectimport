<?php

use App\Http\Controllers\boss;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     $posts = DB::table('amazon_b2c_may_2023')->get();
//     return view('welcome',[
//         'amazon_b2c_may_2023' =>$posts
//     ]);
// });

Route::get('/',[boss::class,'Chartsheet']);
Route::get('/getAmazonData',[boss::class,'getAmazonData']);
Route::get('/import',[boss::class,'importView'])->name('importfile');
Route::post('/import',[boss::class,'import']);

//credit note

Route::get('/credit_note',[boss::class,'credit_note']);
Route::get('/dedit_note',[boss::class,'dedit_note']);





