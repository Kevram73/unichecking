<?php

use App\Http\Controllers\LogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\CallbackController;
use App\Http\Controllers\ExecController;


Route::post('/', [ExecController::class, 'heartbeat'])->name('heartbeat');
Route::post('/log/check_enseignant/{id}', [CallbackController::class, 'check_enseignant']);
Route::get('/log/check_enseignant/{id}', [CallbackController::class, 'check_enseignant']);

Route::post('/log/register', [CallbackController::class, 'register']);
Route::post('/log/identity', [CallbackController::class, 'identity']);
Route::get('/log/identity', [CallbackController::class, 'identity']);
Route::post('/log/heartbeat', [CallbackController::class, 'heartbeat']);
Route::post('/log/getback', [CallbackController::class, 'getback']);

Route::post('/scan', [CallbackController::class, 'testSaveScan']);

Route::get('/endpoint', [LogController::class, 'index']);
Route::post('/endpoint', [LogController::class, 'store']);
Route::put('/endpoint', [LogController::class, 'update']);
Route::delete('/endpoint', [LogController::class, 'destroy']);
