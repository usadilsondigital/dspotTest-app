<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProfileController::class)->group(function () {
    
    Route::get('/profiles', 'index'); 
    Route::get('/profiles/create', 'create');  
    Route::post('/profiles', 'store');  
    Route::get('/profiles/{profile}', 'show'); 
    Route::put('/profiles/{profile}', 'push');  
    Route::delete('/profiles/{profile}', 'delete');  
    
}); 