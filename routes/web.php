<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\AdminDashboard;
use App\Http\Controllers\laporan\JurnalController;
use App\Http\Controllers\master_data\CoaController;
use App\Http\Controllers\laporan\LabaRugiController;
use App\Http\Controllers\master_data\UnitController;
use App\Http\Controllers\transaksi\HutangController;
use App\Http\Controllers\laporan\BukuBesarController;
use App\Http\Controllers\master_data\PesanController;
use App\Http\Controllers\transaksi\BelanjaController;
use App\Http\Controllers\transaksi\PiutangController;
use App\Http\Controllers\master_data\BarangController;
use App\Http\Controllers\master_data\BeritaController;
use App\Http\Controllers\master_data\SatuanController;
use App\Http\Controllers\transaksi\SimpananController;
use App\Http\Controllers\laporan\NeracaSaldoController;
use App\Http\Controllers\master_data\AnggotaController;
use App\Http\Controllers\master_data\JabatanController;
use App\Http\Controllers\transaksi\PenarikanController;
use App\Http\Controllers\transaksi\PenjualanController;
use App\Http\Controllers\transaksi\SaldoAwalController;
use App\Http\Controllers\master_data\PenyediaController;
use App\Http\Controllers\transaksi\PendapatanController;
use App\Http\Controllers\transaksi\PenyusutanController;
use App\Http\Controllers\laporan\LaporanGudangController;
use App\Http\Controllers\master_data\MasterShuController;
use App\Http\Controllers\laporan\LaporanSimpananController;
use App\Http\Controllers\transaksi\BelanjaBarangController;
use App\Http\Controllers\transaksi\TransferSaldoController;
use App\Http\Controllers\laporan\LaporanPenjualanController;
use App\Http\Controllers\laporan\LaporanPinjamanController;
use App\Http\Controllers\laporan\LaporanTransaksiController;
use App\Http\Controllers\master_data\BarangEceranController;
use App\Http\Controllers\master_data\MasterSimpananController;
use App\Http\Controllers\master_data\PengajuanPinjamanController;
use App\Http\Controllers\master_data\ProfilKpriController;
use App\Http\Controllers\transaksi\PelunasanController;
use App\Http\Controllers\transaksi\PinjamanController;

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

Route::get('/login', function () {
      return view('auth.login');
});
// Route::post('/login/validate', 'App\Http\Controllers\auth\LoginController@login')->name('login');

Route::get('/', [AdminDashboard::class, 'index'])->name('main-dashboard');
Route::get('/profil/koperasi', [ProfilKpriController::class, 'index'])->name('profil-koperasi');
//Content:
//1.master data umum
Route::get('/anggota', [AnggotaController::class, 'index'])->name('mdu-anggota');
Route::get('/jabatan', [JabatanController::class, 'index'])->name('mdu-jabatan');
Route::get('/unit', [UnitController::class, 'index'])->name('mdu-unit');
Route::get('/satuan', [SatuanController::class, 'index'])->name('mdu-satuan');
Route::get('/berita', [BeritaController::class, 'index'])->name('mdu-berita');
Route::get('/pesan', [PesanController::class, 'index'])->name('pesan');

//2.master data unit pertokoan
Route::get('/persediaan/unit-pertokoan', [BarangController::class, 'index'])->name('mdt-persediaan');
Route::get('/inventaris/unit-pertokoan', [BarangController::class, 'index'])->name('mdt-inventaris');
Route::get('/persediaan-eceran/unit-pertokoan', [BarangEceranController::class, 'index'])->name('mdt-persediaan-eceran');
Route::get('/inventaris-eceran/unit-pertokoan', [BarangEceranController::class, 'index'])->name('mdt-inventaris-eceran');
Route::get('/vendor', [PenyediaController::class, 'index'])->name('mdt-vendor');

//3.master data unit simpan pinjam
Route::get('/inventaris/unit-sp', [BarangController::class, 'index'])->name('mds-inventaris');
Route::get('/inventaris-eceran/unit-sp', [BarangEceranController::class, 'index'])->name('mds-inventaris-eceran');
Route::get('/master-simpanan', [MasterSimpananController::class, 'index'])->name('mds-simpanan');

//4.coa
Route::get('/coa', [CoaController::class, 'index'])->name('coa-master');
Route::get('/saldo-awal', [SaldoAwalController::class, 'index'])->name('coa-saldo-awal');
Route::get('/kas-bank', [TransferSaldoController::class, 'index'])->name('coa-kas-bank');

//5.transaksi unit pertokoan
Route::get('/penjualan/unit-pertokoan', [PenjualanController::class, 'index'])->name('ptk-penjualan');
Route::get('/pendapatan/unit-pertokoan', [PendapatanController::class, 'index'])->name('ptk-pendapatan');
Route::get('/piutang-barang/unit-pertokoan', [PiutangController::class, 'index'])->name('ptk-piutang');
Route::get('/belanja-barang/unit-pertokoan', [BelanjaBarangController::class, 'index'])->name('btk-belanja-barang');
Route::get('/belanja-lain/unit-pertokoan', [BelanjaController::class, 'index'])->name('btk-belanja-lain');
Route::get('/hutang/unit-pertokoan', [HutangController::class, 'index'])->name('btk-hutang');
Route::get('/simpanan/unit-pertokoan/setor-history', [SimpananController::class, 'index'])->name('stk-simpanan');
Route::get('/simpanan/unit-pertokoan/tarik-history', [PenarikanController::class, 'index'])->name('stk-penarikan');
Route::get('/penyusutan/unit-pertokoan', [PenyusutanController::class, 'index'])->name('penyusutan-unit-pertokoan');
Route::get('/shu/unit-pertokoan', [MasterShuController::class, 'index'])->name('shu-unit-pertokoan');

//6.transaksi unit simpan pinjam
Route::get('/simpanan/unit-sp/setor-history', [SimpananController::class, 'index'])->name('sp-simpanan');
Route::get('/simpanan/unit-sp/tarik-history', [PenarikanController::class, 'index'])->name('sp-penarikan');
Route::get('/pinjaman/unit-sp/pengajuan-history', [PengajuanPinjamanController::class, 'index'])->name('pp-pengajuan');
Route::get('/pinjaman/unit-sp/pinjaman-history', [PinjamanController::class, 'index'])->name('pp-pinjaman');
Route::get('/pinjaman/unit-sp/angsuran-history', [PelunasanController::class, 'index'])->name('pp-angsuran');
Route::get('/belanja-barang/unit-sp', [BelanjaBarangController::class, 'index'])->name('bsp-belanja-barang');
Route::get('/belanja-lain/unit-sp', [BelanjaController::class, 'index'])->name('bsp-belanja-lain');
Route::get('/hutang/unit-sp', [HutangController::class, 'index'])->name('bsp-hutang');
Route::get('/pendapatan/unit-sp', [PendapatanController::class, 'index'])->name('pendapatan-unit-sp');
Route::get('/penyusutan/unit-sp', [PenyusutanController::class, 'index'])->name('penyusutan-unit-sp');
Route::get('/shu/unit-sp', [MasterShuController::class, 'index'])->name('shu-unit-sp');

//7.laporan unit pertokoan
Route::get('/laporan-gudang/unit-pertokoan', [LaporanGudangController::class, 'index'])->name('lut-gudang');
Route::get('/laporan-penjualan/unit-pertokoan', [LaporanPenjualanController::class, 'index'])->name('lut-penjualan');
Route::get('/laporan-transaksi/unit-pertokoan', [LaporanTransaksiController::class, 'index'])->name('lut-transaksi');
Route::get('/kartu-toko', [LaporanSimpananController::class, 'index'])->name('lut-kartu-toko');
Route::get('/jurnal/unit-pertokoan', [JurnalController::class, 'index'])->name('lut-jurnal');
Route::get('/buku-besar/unit-pertokoan', [BukuBesarController::class, 'index'])->name('lut-buku-besar');
Route::get('/laba-rugi/unit-pertokoan', [LabaRugiController::class, 'index'])->name('lut-laba-rugi');
Route::get('/neraca-saldo/unit-pertokoan', [NeracaSaldoController::class, 'index'])->name('lut-neraca');

//8.laporan unit simpan pinjam
Route::get('/laporan-transaksi/unit-sp', [LaporanTransaksiController::class, 'index'])->name('lus-transaksi');
Route::get('/laporan-simpanan/unit-sp', [LaporanSimpananController::class, 'index'])->name('lus-simpanan');
Route::get('/laporan-simpanan-sukarela-berbunga/unit-sp', [LaporanSimpananController::class, 'index'])->name('lus-simpanan-sb');
Route::get('/laporan-pinjaman/unit-sp', [LaporanPinjamanController::class, 'index'])->name('lus-pinjaman');
Route::get('/jurnal/unit-sp', [JurnalController::class, 'index'])->name('lus-jurnal');
Route::get('/buku-besar/unit-sp', [BukuBesarController::class, 'index'])->name('lus-buku-besar');
Route::get('/laba-rugi/unit-sp', [LabaRugiController::class, 'index'])->name('lus-laba-rugi');
Route::get('/neraca-saldo/unit-sp', [NeracaSaldoController::class, 'index'])->name('lus-neraca');

//9.user
Route::get('/profil/pengguna', [AdminDashboard::class, 'index'])->name('profil-pengguna');
Route::get('/pengaturan-user', [AdminDashboard::class, 'index'])->name('pengaturan-user');
Route::get('/otoritas', [AdminDashboard::class, 'index'])->name('pengaturan-otoritas');
Route::get('/otorisasi', [AdminDashboard::class, 'index'])->name('pengaturan-otorisasi');
