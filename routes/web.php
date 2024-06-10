<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('registration/{event}', [RegistrationController::class, 'landing'])->name('landing');
Route::post('registration', [RegistrationController::class, 'registration'])->name('registration');

Route::get('/members/template/download', [MemberController::class, 'downloadTemplate'])->name(
    'members.downloadUserTemplate'
);


Route::middleware('auth')->group(function () {

    Route::resource('users', UserController::class);
    Route::resource('members', MemberController::class);
    Route::resource('events', EventController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
