<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SeekingController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//募集
Route::get('/', [SeekingController::class, 'index'])->name('seeking.index');
Route::get('/seeking/create', [SeekingController::class, 'create'])->name('seeking.create');
Route::post('/seeking/store', [SeekingController::class, 'store'])->name('seeking.store');
Route::get('/seeking/my-seekings', [SeekingController::class, 'getMySeekings'])->name('seeking.my_seekings');

require __DIR__.'/auth.php';
