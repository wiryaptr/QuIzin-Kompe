<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ParticipantController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
});

Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::post('/', [RoomController::class, 'store'])->name('store');
    Route::get('/{code}/lobby', [RoomController::class, 'lobby'])->name('lobby');
    Route::post('/{code}/start', [RoomController::class, 'start'])->name('start');
    Route::post('/{code}/finish', [RoomController::class, 'finish'])->name('finish');
});

Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::post('/', [RoomController::class, 'store'])->name('store');
    Route::get('/{code}/lobby', [RoomController::class, 'lobby'])->name('lobby');
    Route::post('/{code}/start', [RoomController::class, 'start'])->name('start');
    Route::post('/{code}/finish', [RoomController::class, 'finish'])->name('finish');

    Route::post('/join', [ParticipantController::class, 'join'])->name('join');
    Route::get('/{code}/participants', [ParticipantController::class, 'indexByRoom'])->name('participants');
});