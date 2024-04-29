<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;


Route::get('/messages/create', function () {
    return view('messages.create');
});

Route::get('/messages/read', function () {
    return view('messages.read');
});

Route::post('/messages', [MessageController::class, 'store']);
Route::post('/messages/read', [MessageController::class, 'read']);

Route::get('/messages/retrieve', function () {
    return view('messages.retrieve');
})->name('messages.retrieve_form');

Route::post('/messages/retrieve', [MessageController::class, 'retrieve'])->name('messages.retrieve');
