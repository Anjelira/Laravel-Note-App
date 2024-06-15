<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// login
Route::post('/login', [AuthController::class, 'login']);

// register
Route::post('/register', [AuthController::class, 'register']);

// logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// notes
Route::apiResource('/notes',NoteController::class)->middleware('auth:sanctum');