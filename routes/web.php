<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasAjaxController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrestasiAjaxController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TahunAjaranAjaxController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserAjaxController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    Route::get('/user-role-count', [UserAjaxController::class, 'getUserRoleCountChartjs']);



    Route::resource('/qwe/guru', GuruController::class);
    Route::resource('/qwe/siswa', SiswaController::class);
    Route::get('/qwe/guruAjax', [UserAjaxController::class, 'indexGuru'])->name('admin.user.guru.ajax');
    Route::get('/qwe/siswaAjax', [UserAjaxController::class, 'indexSiswa'])->name('admin.user.siswa.ajax');


    Route::resource('/qwe/prestasiAjax', PrestasiAjaxController::class);
    Route::resource('/qwe/prestasi', PrestasiController::class);

    Route::resource('/qwe/kelas', KelasAjaxController::class);
    Route::get('/qwe/kelasAjax', [KelasAjaxController::class, 'indexKelas']);

    Route::resource('/qwe/tahunajaranAjax', TahunAjaranAjaxController::class);
    Route::resource('/qwe/tahunajaran', TahunAjaranController::class);

    Route::resource('/qwe/userAjax', UserAjaxController::class);
    Route::resource('/qwe/role', RoleController::class)->middleware('role:admin');
    Route::resource('/qwe/permission', PermissionController::class)->middleware('role:admin');


    Route::get('/qwe/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/data', [UserController::class, 'getDataForDataTables'])->name('admin.user.ajax');
    Route::get('/qwe/user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit')->middleware('role:admin');
    Route::put('/qwe/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('/qwe/user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy')->middleware('role:admin');

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


Route::get('user', function () {
    $user = Auth::user();
    // Mendapatkan roles dari user
    $roles = $user->getRoleNames();

    return view('admin.user.tes', ['roles' => $roles]);
})->middleware(['auth', 'verified', 'role:admin']);


Route::get('/test500', function () {
    abort(500, 'Internal Server Error');
});

require __DIR__ . '/auth.php';
