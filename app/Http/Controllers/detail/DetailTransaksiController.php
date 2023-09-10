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
            case 'detail_transfer_saldo':
                if ($unit == 'Pertokoan') {
                    $route = 'transfer-toko.show';
                } else {
                    $route = 'transfer-sp.show';
                }
                return redirect()->route($route, Crypt::encrypt($id));
            default:
                break;
        }
    }
}
