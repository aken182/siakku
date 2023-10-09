<?php

namespace App\Http\Controllers\detail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class DetailTransaksiController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function index($id, $detail, $unit = null)
    {
        $id = Crypt::decrypt($id);
        switch ($detail) {
            case 'Belanja':
                $route = $unit === 'Pertokoan' ? 'btk-belanja-lain.show' : 'bsp-belanja-lain.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Pembayaran Hutang Belanja':
                $route = $unit === 'Pertokoan' ? 'btk-belanja-lain.show-pelunasan' : 'bsp-belanja-lain.show-pelunasan';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Pinjam Tindis':
            case 'Pembayaran Pinjaman Anggota':
                $route = 'pp-angsuran.show-pelunasan';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Pembayaran Piutang Penjualan':
                $route = 'ptk-penjualan.show-pelunasan';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Penarikan Simpanan':
                $route = $unit === 'Pertokoan' ? 'stk-penarikan.show' : 'sp-penarikan.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Penarikan Simpanan':
            case 'Penarikan Simpanan Sukarela Berbunga':
                $route = $unit === 'Pertokoan' ? 'stk-penarikan.show' : 'sp-penarikan.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Pendapatan':
                $route = $unit === 'Pertokoan' ? 'ptk-pendapatan.show' : 'pendapatan-unit-sp.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Pengadaan Barang':
                $route = $unit === 'Pertokoan' ? 'btk-belanja-barang.show' : 'bsp-belanja-barang.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Penjualan Barang':
            case 'Penjualan Lainnya':
                $route = 'ptk-penjualan.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Penyusutan':
                $route = $unit === 'Pertokoan' ? 'penyusutan-toko.show' : 'penyusutan-sp.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Pinjaman Anggota':
                $route = 'pp-pinjaman.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Saldo Awal COA':
                $route = $unit === 'Pertokoan' ? 'sltk-coa' : 'slsp-coa';
                return redirect()->route($route);
            case 'Saldo Awal inventaris':
                $route = $unit === 'Pertokoan' ? 'sltk-inventaris' : 'slsp-inventaris';
                return redirect()->route($route);
            case 'Saldo Awal Persediaan':
                $route = $unit === 'Pertokoan' ? 'sltk-persediaan' : '';
                return redirect()->route($route);
            case 'Simpanan':
            case 'Simpanan Sukarela Berbunga':
                $route = $unit === 'Pertokoan' ? 'stk-simpanan.show' : 'sp-simpanan.show';
                return redirect()->route($route, Crypt::encrypt($id));
            case 'Transfer Saldo Kas & Bank':
                $route = $unit === 'Pertokoan' ? 'transfer-toko.show' : 'transfer-sp.show';
                return redirect()->route($route, Crypt::encrypt($id));
            default:
                break;
        }
    }
}
