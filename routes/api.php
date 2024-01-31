<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Responses\ApiResponse;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/task',[TaskController::class,'index']);
    Route::get('/task/{id}',[TaskController::class,'show']);
    Route::put('/task/{id}',[TaskController::class,'update']);
    Route::put('/task/filled/{id}',[TaskController::class,'complete']);
    Route::post('/task',[TaskController::class,'store']);
    Route::delete('/task/{id}',[TaskController::class,'destroy']);
});

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('logout',[AuthController::class,'logout']);
    Route::post('/sheck',[AuthController::class,'sheck']);
});



