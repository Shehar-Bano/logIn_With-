<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialliteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(SocialliteController::class)->group(function(){
    Route::get('/redirect/{provider}','googleProvider')->name('googleLogin');
    Route::get('/{provider}/LoginCallback',  'googleLoginCallback')->name('{provider}LoginCallback');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
