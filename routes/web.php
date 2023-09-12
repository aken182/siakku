<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\dashboard\AdminDashboard;
use App\Http\Controllers\user\UserSettingController;
use App\Http\Controllers\transaksi\PenyusutanController;
use App\Http\Controllers\master_data\ProfilKpriController;
use App\Http\Controllers\authentications\PermissionController;

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

Route::name('login')->get('login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

// Route::middleware(['auth', 'time-restriction'])->group((function () {
Route::middleware(['auth'])->group((function () {

      Route::post('logout', [LoginController::class, 'logout'])->name('logout');

      Route::get('/', [AdminDashboard::class, 'index'])->name('main-dashboard');
      Route::controller(ProfilKpriController::class)->group(function () {
            Route::get('/profil/koperasi', 'index')->name('profil-koperasi');
            Route::get('profil/koperasi/edit/{id}', 'edit')->name('profil-koperasi.edit');
            Route::patch('profil/koperasi/update/{id}', 'update')->name('profil-koperasi.update');
      });

      //Content:

      //1.master data umum
      require __DIR__ . '/master_umum.php';

      //2.master data unit pertokoan
      require __DIR__ . '/master_pertokoan.php';

      //3.master data unit simpan pinjam
      require __DIR__ . '/master_sp.php';

      //4.coa
      require __DIR__ . '/coa.php';

      //5.shu
      require __DIR__ . '/shu.php';

      //6. import
      require __DIR__ . '/import.php';

      //7. export
      require __DIR__ . '/export.php';

      //6.transaksi unit pertokoan
      //pendapatan
      require __DIR__ . '/pendapatan_toko.php';
      //belanja
      require __DIR__ . '/belanja_toko.php';
      //simpanan
      require __DIR__ . '/simpanan_toko.php';
      //penyusutan
      Route::get('/penyusutan/unit-pertokoan', [PenyusutanController::class, 'index'])->name('penyusutan-unit-pertokoan');

      //7.transaksi unit simpan pinjam
      //simpanan
      require __DIR__ . '/simpanan_sp.php';
      //pinjaman
      require __DIR__ . '/pinjaman_sp.php';
      //belanja
      require __DIR__ . '/belanja_sp.php';
      //pendapatan
      require __DIR__ . '/pendapatan_sp.php';
      //penyusutan
      Route::get('/penyusutan/unit-sp', [PenyusutanController::class, 'index'])->name('penyusutan-unit-sp');

      //8.laporan unit pertokoan
      require __DIR__ . '/laporan_toko.php';

      //9. laporan unit simpan pinjam
      require __DIR__ . '/laporan_sp.php';

      // 10. Setting User
      Route::get('/profil/pengguna', [AdminDashboard::class, 'index'])->name('profil-pengguna');
      Route::controller(UserSettingController::class)->group(function () {
            Route::get('/pengaturan-user', 'userManager')->name('pengaturan-user');
            Route::post('/store-user', 'storeUser')->name('pengaturan-user.storeUser');
            Route::get('/otoritas', 'roleManager')->name('pengaturan-otoritas');
            Route::post('/store-otoritas', 'storeRole')->name('pengaturan-otoritas.storeRole');
            Route::get('/otorisasi', 'permissionManager')->name('pengaturan-otorisasi');
            Route::post('/assign-permission', 'roleHasPermission')->name('pengaturan-otorisasi.assignPermission');
            Route::get('/set-permission', [PermissionController::class, 'index']);
      });
}));

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
