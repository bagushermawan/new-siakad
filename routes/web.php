<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LoginAsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\UserAjaxController;
use App\Http\Controllers\ErrorTestController;
use App\Http\Controllers\KelasAjaxController;
use App\Http\Controllers\NilaiAjaxController;
use App\Http\Controllers\EkskulAjaxController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\User\RaportController;
use App\Http\Controllers\PrestasiAjaxController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WaliSantriAjaxController;
use App\Http\Controllers\TahunAjaranAjaxController;
use App\Http\Controllers\MataPelajaranAjaxController;
use App\Http\Controllers\ProfilePondokAjaxController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\JadwalMataPelajaranController;
use App\Http\Controllers\JadwalMataPelajaranAjaxController;

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

Route::get('/welcome', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth:web,wali')->group(function () {
    // Route::get('/user-role-count', [UserAjaxController::class, 'getUserRoleCountChartjs']);
    Route::get('/userd-role-count', [UserDashboardController::class, 'getUserRoleCountChartjs']);
    Route::get('/', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::resource('/a', UserDashboardController::class);
    Route::get('/dataNilaiForWali', [UserDashboardController::class, 'dataNilaiForWali']);
    Route::get('/dataNilaiForSantri', [UserDashboardController::class, 'dataNilaiForSantri']);
    Route::get('/jadwalmatapelajaranUser', [UserDashboardController::class, 'dataJadwalPelajaranUser']);
    Route::get('/get_tahunajaranAktif_options', [UserDashboardController::class, 'getTahunAjaranAktifOptions']);
    Route::get('/get_alltahunajaran_options', [UserDashboardController::class, 'getTahunAjaranOptions']);
    Route::get('/get_kelas_optionss', [UserDashboardController::class, 'getKelasOptions']);
    Route::post('/search-santri', [UserDashboardController::class, 'searchSantri'])->name('search-santri');
    Route::post('/hubungkan-santri/{santriId}', [UserDashboardController::class, 'hubungkanSantri'])->name('hubungkan-santri');
    Route::get('/user/profile', [UserDashboardController::class, 'edit'])->name('user.edit');
    Route::put('/user/profile/{id}', [UserDashboardController::class, 'update'])->name('user.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/generate-raport', [RaportController::class, 'generateRaport']);
    Route::get('/storage/{pdf_path}', [RaportController::class, 'showPdf'])->name('show.pdf');

});

Route::middleware('auth')->group(function () {
    Route::get('/user/{id}/login', [LoginAsController::class, 'loginAsUser']);
    Route::get('/wali/{id}/login', [LoginAsController::class, 'loginAsWaliSantri']);

    Route::get('/qwe/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/user-role-count', [UserAjaxController::class, 'getUserRoleCountChartjs']);

    Route::resource('/qwe/guru', GuruController::class);
    Route::resource('/qwe/siswa', SiswaController::class);
    Route::get('/qwe/guruAjax', [UserAjaxController::class, 'indexGuru'])->name('admin.user.guru.ajax');
    Route::get('/qwe/siswaAjax', [UserAjaxController::class, 'indexSiswa'])->name('admin.user.siswa.ajax');
    Route::post('/qwe/import-alluser', [UserAjaxController::class, 'importAlluser'])->name('import.alluser');
    Route::post('/qwe/import-guru', [UserAjaxController::class, 'importGuru'])->name('import.guru');
    Route::post('/qwe/import-siswa', [UserAjaxController::class, 'importSiswa'])->name('import.siswa');
    Route::get('/get_santri_options', [UserAjaxController::class, 'getSantriOptions']);
    Route::get('/getSantriInfo/{id}', [UserAjaxController::class, 'getSantriInfo']);
    Route::delete('/delete-all-user', [UserAjaxController::class, 'deleteAllUser'])->name('delete.all.user');
    Route::delete('/delete-all-guru', [UserAjaxController::class, 'deleteAllGuru'])->name('delete.all.guru');

    Route::resource('/qwe/wali', WaliSantriAjaxController::class);
    Route::get('/qwe/waliAjax', [WaliSantriAjaxController::class, 'indexWali']);
    Route::delete('/delete-all-walisantri', [WaliSantriAjaxController::class, 'deleteAllWaliSantri'])->name('delete.all.walisantri');

    Route::resource('/qwe/ekskul', EkskulAjaxController::class);
    Route::get('/qwe/ekskulAjax', [EkskulAjaxController::class, 'indexEkskul']);
    Route::post('/qwe/import-ekskul', [EkskulAjaxController::class, 'importEkskul'])->name('import.ekskul');
    Route::delete('/delete-all-ekskul', [EkskulAjaxController::class, 'deleteAll'])->name('delete.all.ekskul');

    Route::resource('/qwe/prestasiAjax', PrestasiAjaxController::class);
    Route::resource('/qwe/prestasi', PrestasiController::class);
    Route::post('/qwe/import-prestasi', [PrestasiAjaxController::class, 'importPrestasi'])->name('import.prestasi');
    Route::delete('/delete-all-prestasi', [PrestasiAjaxController::class, 'deleteAll'])->name('delete.all.prestasi');

    Route::resource('/qwe/kelas', KelasAjaxController::class);
    Route::get('/qwe/kelasAjax', [KelasAjaxController::class, 'indexKelas']);
    Route::post('/qwe/import-kelas', [KelasAjaxController::class, 'importKelas'])->name('import.kelas');
    Route::delete('/delete-all-kelas', [KelasAjaxController::class, 'deleteAll'])->name('delete.all.kelas');

    Route::resource('/qwe/matapelajaran', MataPelajaranAjaxController::class);
    Route::get('/qwe/matapelajaranAjax', [MataPelajaranAjaxController::class, 'indexMatapelajaran']);
    Route::delete('/delete-all-matpel', [MataPelajaranAjaxController::class, 'deleteAll'])->name('delete.all.matpel');

    Route::resource('/qwe/jadwalmatapelajaran', JadwalMataPelajaranAjaxController::class);
    Route::get('/qwe/jadwalmatapelajaranAjax', [JadwalMataPelajaranAjaxController::class, 'indexJadwalMataPelajaran']);
    Route::delete('/delete-all-jadwal', [JadwalMataPelajaranAjaxController::class, 'deleteAll']);
    Route::get('/get_kelas_options', [JadwalMataPelajaranAjaxController::class, 'getKelasOptions']);
    Route::get('/get_tahunajaran_options', [JadwalMataPelajaranAjaxController::class, 'getTahunAjaranOptions']);

    Route::resource('/qwe/nilai', NilaiAjaxController::class);
    Route::get('/qwe/nilaiAjax', [NilaiAjaxController::class, 'indexNilai']);
    Route::delete('/delete-all-nilai', [NilaiAjaxController::class, 'deleteAll'])->name('delete.all.nilai');
    Route::get('/get_matpel_options', [NilaiAjaxController::class, 'getMatpelOptions']);

    Route::resource('/qwe/tahunajaranAjax', TahunAjaranAjaxController::class);
    Route::resource('/qwe/tahunajaran', TahunAjaranController::class);
    Route::delete('/delete-all-tahunajaran', [TahunAjaranAjaxController::class, 'deleteAll'])->name('delete.all.tahunajaran');

    Route::resource('/qwe/userAjax', UserAjaxController::class);
    Route::resource('/qwe/role', RoleController::class)->middleware('role:admin');
    Route::get('/role/{id}', [RoleController::class, 'destroy'])->name('role.destroyy');
    Route::resource('/qwe/permission', PermissionController::class)->middleware('role:admin');

    Route::get('/qwe/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/data', [UserController::class, 'getDataForDataTables'])->name('admin.user.ajax');
    Route::get('/qwe/user/edit/{id}', [UserController::class, 'edit'])
        ->name('admin.user.edit')
        ->middleware('role:admin');
    Route::put('/qwe/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::get('/qwe/user/destroy/{id}', [UserController::class, 'destroy'])
        ->name('admin.user.destroy')
        ->middleware('role:admin');

    Route::get('/qwe/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'editt'])->name('profile.editt');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/qwe/profilepondok', ProfilePondokAjaxController::class);
});

Route::get('cekguard', function () {
    // dd(auth()->user()->name);
    // dd(session()->all());
    // ...

    // Tampilkan sesi menggunakan var_dump
    // echo '<pre>';
    // var_dump(session()->all());
    // var_dump(Auth::getDefaultDriver());
    // echo '</pre>';

    return '
        <h1>Hello <h5 class="font-bold">' .
        'Name:  ' .
        ucfirst(auth()->user()->name) .
        '<br>' .
        'Role:  ' .
         ucfirst(implode(', ', Auth::user()->getRoleNames()->all())) .
        '</h5><br></h1>

        <!-- Tombol Logout -->
        <form action="' .
        route('logout') .
        '" method="POST">
            ' .
        csrf_field() .
        '
            <button type="submit">Logout</button>
        </form>
    ';
})->middleware(['auth:web,wali', 'role:admin|user|wali santri']);

Route::get('penulis', function () {
    return '<h1>Hello penulis</h1>';
})->middleware(['auth', 'verified', 'role:user']);

Route::get('kelas', function () {
    return view('kelas');
})->middleware(['auth', 'verified', 'role_or_permission:lihat-kelas|admin']);

Route::get('coba', function () {
    return view('auth.forgotpw');
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


Route::get('/error404', [ErrorTestController::class, 'show404']);
Route::get('/error419', [ErrorTestController::class, 'show419']);
Route::get('/error500', [ErrorTestController::class, 'show500']);
Route::get('/error403', [ErrorTestController::class, 'show403']);
Route::get('/test', [ErrorTestController::class, 'test']);

require __DIR__ . '/auth.php';
