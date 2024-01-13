<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeekingController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\PrivacyPolicyController;

//プロフィールページ (スラッグがeditと競合してる)
Route::get('/profile/show/{user_name}', [ProfileController::class, 'show'])->name('profile.show');

//プロフィールページ認証後
Route::middleware('verified')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//募集ホーム以外メール認証必須
Route::get('/', [SeekingController::class, 'index'])->name('seeking.index');
Route::get('/seeking/show/{id}', [SeekingController::class, 'show'])->name('seeking.show');

Route::middleware('verified')->group(function () {
  Route::get('/seeking/create', [SeekingController::class, 'create'])->name('seeking.create');
  Route::post('/seeking/store', [SeekingController::class, 'store'])->name('seeking.store');
  Route::get('/seeking/edit/{id}', [SeekingController::class, 'edit'])->name('seeking.edit');
  Route::put('seeking/update/{id}', [SeekingController::class, 'update'])->name('seeking.update');
  Route::delete('/seeking/delete/{id}', [SeekingController::class, 'destroy'])->name('seeking.destroy');
});


//利用規約・プライバシーポリシー
Route::get('/policy', [PolicyController::class, 'index'])->name('policy.index');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');

//気になるを付け外し
Route::post('/like',[LikeController::class, 'like'])->name('like');
Route::post('/match{like_id}',[LikeController::class, 'match'])
    ->name('match')
    ->middleware('auth', 'verified');

//コミュニケーションページ
Route::middleware('verified')->group(function () {
  Route::get('/communication', [CommunicationController::class, 'index'])->name('communication.index');
});

require __DIR__.'/auth.php';
