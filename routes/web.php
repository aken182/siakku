<?php

use App\Http\Controllers\auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\UserSettingController;
use App\Http\Controllers\dashboard\AdminDashboard;
use App\Http\Controllers\transaksi\HutangController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\PiutangController;
use App\Http\Controllers\transaksi\PinjamanController;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\transaksi\PelunasanController;
use App\Http\Controllers\transaksi\PenarikanController;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\PendapatanController;
use App\Http\Controllers\transaksi\PenyusutanController;
use App\Http\Controllers\master_data\ProfilKpriController;
use App\Http\Controllers\transaksi\BelanjaBarangController;
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
      Route::get('/penjualan/unit-pertokoan', [PenjualanController::class, 'index'])->name('ptk-penjualan');
      Route::get('/pendapatan/unit-pertokoan', [PendapatanController::class, 'index'])->name('ptk-pendapatan');
      Route::get('/piutang-barang/unit-pertokoan', [PiutangController::class, 'index'])->name('ptk-piutang');
      Route::get('/belanja-barang/unit-pertokoan', [BelanjaBarangController::class, 'index'])->name('btk-belanja-barang');
      Route::get('/belanja-lain/unit-pertokoan', [BelanjaController::class, 'index'])->name('btk-belanja-lain');
      Route::get('/hutang/unit-pertokoan', [HutangController::class, 'index'])->name('btk-hutang');
      Route::get('/simpanan/unit-pertokoan/setor-history', [SimpananController::class, 'index'])->name('stk-simpanan');
      Route::get('/simpanan/unit-pertokoan/tarik-history', [PenarikanController::class, 'index'])->name('stk-penarikan');
      Route::get('/penyusutan/unit-pertokoan', [PenyusutanController::class, 'index'])->name('penyusutan-unit-pertokoan');

      //7.transaksi unit simpan pinjam
      Route::get('/simpanan/unit-sp/setor-history', [SimpananController::class, 'index'])->name('sp-simpanan');
      Route::get('/simpanan/unit-sp/tarik-history', [PenarikanController::class, 'index'])->name('sp-penarikan');
      Route::get('/pinjaman/unit-sp/pinjaman-history', [PinjamanController::class, 'index'])->name('pp-pinjaman');
      Route::get('/pinjaman/unit-sp/angsuran-history', [PelunasanController::class, 'index'])->name('pp-angsuran');
      Route::get('/belanja-barang/unit-sp', [BelanjaBarangController::class, 'index'])->name('bsp-belanja-barang');
      Route::get('/belanja-lain/unit-sp', [BelanjaController::class, 'index'])->name('bsp-belanja-lain');
      Route::get('/hutang/unit-sp', [HutangController::class, 'index'])->name('bsp-hutang');
      Route::get('/pendapatan/unit-sp', [PendapatanController::class, 'index'])->name('pendapatan-unit-sp');
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
