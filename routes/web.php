<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\GameplayController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\QuestionController;

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

    Route::resource('quizzes', QuizController::class);
    Route::resource('quizzes.questions', QuestionController::class)
        ->shallow()
        ->except(['show']);
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

Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::post('/', [RoomController::class, 'store'])->name('store');
    Route::get('/{code}/lobby', [RoomController::class, 'lobby'])->name('lobby');
    Route::post('/{code}/start', [RoomController::class, 'start'])->name('start');
    Route::post('/{code}/finish', [RoomController::class, 'finish'])->name('finish');

    Route::post('/join', [ParticipantController::class, 'join'])->name('join');
    Route::get('/{code}/participants', [ParticipantController::class, 'indexByRoom'])->name('participants');

    Route::get('/{code}/questions', [GameplayController::class, 'questions'])->name('questions');
    Route::post('/{code}/answers', [GameplayController::class, 'submitAnswer'])->name('answers.submit');
});

Route::prefix('rooms')->name('rooms.')->group(function () {
    Route::post('/', [RoomController::class, 'store'])->name('store');
    Route::get('/{code}/lobby', [RoomController::class, 'lobby'])->name('lobby');
    Route::post('/{code}/start', [RoomController::class, 'start'])->name('start');
    Route::post('/{code}/finish', [RoomController::class, 'finish'])->name('finish');

    Route::post('/join', [ParticipantController::class, 'join'])->name('join');
    Route::get('/{code}/participants', [ParticipantController::class, 'indexByRoom'])->name('participants');

    Route::get('/{code}/questions', [GameplayController::class, 'questions'])->name('questions');
    Route::post('/{code}/answers', [GameplayController::class, 'submitAnswer'])->name('answers.submit');

    Route::get('/{code}/leaderboard', [LeaderboardController::class, 'roomLeaderboard'])->name('leaderboard');
});

Route::get('/history/{userId?}', [LeaderboardController::class, 'userHistory'])->name('history.index');