<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/qwe/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/qwe/user', [UserController::class, 'index'])->name('admin.user');
    Route::get('/qwe/user/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('/qwe/user/{id}', [UserController::class, 'update'])->name('admin.user.update');

    Route::get('/qwe/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'editt'])->name('profile.editt');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('admin', function () {
    return '<h1>Hello Admin</h1>';
})->middleware(['auth', 'verified', 'role:admin']);

Route::get('penulis', function () {
    return '<h1>Hello penulis</h1>';
})->middleware(['auth', 'verified', 'role:penulis|admin']);

Route::get('kelas', function () {
    return view('kelas');
})->middleware(['auth', 'verified', 'role_or_permission:lihat-kelas|admin']);

Route::get('coba', function () {
    return view('coba');
});



require __DIR__ . '/auth.php';
