<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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

Route::get('/', [ListingController::class, 'index']);


   //show create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');
 
 //store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

 // show edit form
 Route::get('/listings/{listing}/edit', [ListingController::class, 'edit']);

 //  update listing
 

 Route::put('/listings/{listing}', [ListingController::class, 'update']);

 //DELETE Listing
 Route::delete('/listings/{listing}', [ListingController::class, 'destroy']);

 Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');
 

//single listing

 Route::get('/listings/{listing}', [ListingController::class, 'show']);

 Route::get('/register', [UserController::class, 'create']);

 Route::POST('/users', [UserController::class, 'store']);

 Route::POST('/logout', [UserController::class, 'logout']);

 Route::get('/login', [UserController::class, 'login'])->name('login');

 Route::POST('/users/authenticate', [UserController::class, 'authenticate']);

