<?php
use Illuminate\Support\Facades\Route;

Route::get('/chat', function () {
    return "Chat Service is working!";
})->name('chat.index');
