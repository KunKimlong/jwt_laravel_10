<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
// Route::get('/user',[UserController::class,'index']);
// Route::middleware('auth:sanctum')->group(function(){
//     Route::get('/room',[UserController::class,'index']);
// });
// Route::get('/room',[UserController::class,'index']);
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user',[UserController::class,'index']);
    Route::get('/',function(){
        return "Hello bro";
    });
    Route::post('/logout',[UserController::class,'logout']);
});