<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inquiry_h;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Crypt;
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
//     return view('welcome');
// });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',[Inquiry_h::class,'index']);
Route::post('add_inquiry',[Inquiry_h::class,'add_inquiry']);
Route::post('search_inquiry',[Inquiry_h::class,'search_inquiry'])->name('search_inquiry');
Route::get('search_inquiry_id/{id}',[Inquiry_h::class,'search_inquiry_id'])->name('search_inquiry_id');
Route::post('add_customer_reply',[Inquiry_h::class,'add_customer_reply'])->name('add_customer_reply');

Route::get('search_customer',[HomeController::class,'search_name']);
Route::get('ticket-details/{id}',[HomeController::class,'ticket_details']);
Route::post('add_reply',[HomeController::class,'add_reply'])->name('add_reply');
