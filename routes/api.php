<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ProfileController::class)->group(function () {

Route::get('/profiles', 'api_index');  
Route::get('/profiles/{profile}', 'api_show'); 
Route::post('/profiles/', 'api_store'); 
Route::get('/profile/{profile}/delete', 'api_destroy'); 

});
