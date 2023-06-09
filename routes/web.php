<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    // user profile and change password
    Route::prefix('profile')->group(function () {

        Route::get('/view', [ProfileController::class, 'profileView'])->name('profile.view');
        Route::get('/edit', [ProfileController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'profileStore'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'passwordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('password.update');
    });
});

Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// User Management All Routes
Route::prefix('users')->group(function () {

    Route::get('/view', [UserController::class, 'userView'])->name('user.view');

    Route::get('/add', [UserController::class, 'userAdd'])->name('user.add');

    Route::post('/store', [UserController::class, 'userStore'])->name('user.store');

    Route::get('/edit/{id}', [UserController::class, 'userEdit'])->name('user.edit');

    Route::post('/update/{id}', [UserController::class, 'userUpdate'])->name('user.update');

    Route::get('/delete/{id}', [UserController::class, 'userDelete'])->name('user.delete');
});
