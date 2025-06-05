<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/book/{id}', App\Filament\Pages\BookDetail::class)->name('book.detail')->middleware(['auth']);

