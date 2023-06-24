<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SeekingController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ConnectionController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//プロフィールページ (スラッグがeditと競合してる)
Route::get('/profile/show/{user_name}', [ProfileController::class, 'show'])->name('profile.show');


//プロフィールページ認証後
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//募集
Route::get('/', [SeekingController::class, 'index'])->name('seeking.index');
Route::get('/seeking/create', [SeekingController::class, 'create'])->name('seeking.create');
Route::post('/seeking/store', [SeekingController::class, 'store'])->name('seeking.store');
Route::get('/seeking/show/{id}', [SeekingController::class, 'show'])->name('seeking.show');
Route::get('/seeking/{id}/edit', [SeekingController::class, 'edit'])->name('seeking.edit');
Route::put('seeking/{id}/update', [SeekingController::class, 'update'])->name('seeking.update');


//いいねを付ける
Route::post('/like',[LikeController::class, 'like'])->name('like');

//マッチ処理
Route::get('/connection/create/{seeking_id}/{liked_user_id}', [ConnectionController::class, 'create'])
    ->name('connection.create')
    ->middleware('auth');


//コミュニケーションページ
Route::get('/communication', [CommunicationController::class, 'index'])->name('communication.index');

require __DIR__.'/auth.php';
