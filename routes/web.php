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
    Route::get('/profiles/{profile}/edit', 'edit'); 
    Route::put('/profiles/{profile}', 'update')->name("profiles.update");  
    Route::patch('/profiles/{profile}', 'update');  
    
    Route::delete('/profiles/{profile}', 'delete');    
    Route::get('/profiles/{profile}/delete', 'destroy'); 

    Route::get('/profiles/{profile}/createfriend', 'createFriend'); 
    Route::post('/profiles/{profile}/newfriend', 'newFriend'); 
    Route::get('/profiles/{id}/friends', 'allFriends'); 

    Route::get('/short', 'short'); 
    Route::get('/profiles/{id1}/{id2}/shortestpath', 'shortestPath'); 
    
}); 