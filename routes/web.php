<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::resource("users", UserController::class);
Route::resource("employees", EmployeeController::class);
Route::resource('clients', ClientController::class);
Route::resource('channels', ChannelController::class);
Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
Route::patch('/channels/{channel}/toggle-status', [ChannelController::class, 'toggleStatus']);
Route::patch('/clients/{client}/toggle-status', [ClientController::class, 'toggleStatus']);
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
// Route::resource("roles", RoleController::class);
});

require __DIR__.'/settings.php';
