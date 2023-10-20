<?php

use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

function formatAccounting($angka)
{
      return number_format($angka, 0, ',', '.');
}

function formatIdr($angka, $non = null)
{
      if ($angka > 0) {
            if ($angka >= 1000000000) {
                  $hasil = number_format($angka / 1000000000, 1, '.', '') . 'M';
            } else if ($angka >= 1000000) {
                  $hasil = number_format($angka / 1000000, 1, '.', '') . 'Jt';
            } else if ($angka >= 1000) {
                  $hasil = number_format($angka / 1000, 1, '.', '') . 'RB';
            }
      } else if ($angka < 0) {
            if ($angka <= -1000000000) {
                  $hasil = number_format($angka / 1000000000, 1, '.', '') . 'M';
            } else if ($angka <= -1000000) {
                  $hasil = number_format($angka / 1000000, 1, '.', '') . 'Jt';
            } else if ($angka <= -1000) {
                  $hasil = number_format($angka / 1000, 1, '.', '') . 'RB';
            }
      } else {
            $hasil = number_format($angka, 0, '.', '');
      }
      if ($non == 'Y') {
            return $hasil;
      } else {
            return 'Rp ' . $hasil;
      }
}

function buatrpDecimal($angka)
{
      if ($angka < 0) {
            $angkas = $angka * -1;
            $jadi = "(Rp " . number_format($angkas, 2, ',', '.') . ")";
      } else {
            $jadi = "Rp " . number_format($angka, 2, ',', '.');
      }

      return $jadi;
}

function buatrp($angka)
{
      if ($angka < 0) {
            $angkas = $angka * -1;
            $jadi = "(Rp " . number_format($angkas, 0, ',', '.') . ")";
      } else {
            $jadi = "Rp " . number_format($angka, 0, ',', '.');
      }

      return $jadi;
}

function cek_uang($angka)
{
      if ($angka == null || $angka <= 0) {
            if ($angka < 0) {
                  $uang = buatrp($angka);
            } else {
                  $uang = '-';
            }
            return $uang;
      } else {
            $uang = buatrp($angka);
            return $uang;
      }
}

function cekUangDecimal($angka)
{
      if ($angka == null || $angka <= 0) {
            if ($angka < 0) {
                  $uang = buatrpDecimal($angka);
            } else {
                  $uang = '-';
            }
            return $uang;
      } else {
            $uang = buatrpDecimal($angka);
            return $uang;
      }
}

function terbilang($angka)
{
      $angka = abs($angka);
      $baca  = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
      $terbilang = '';

      if ($angka < 12) { // 0 - 11
            $terbilang = ' ' . $baca[$angka];
      } elseif ($angka < 20) { // 12 - 19
            $terbilang = terbilang($angka - 10) . ' belas';
      } elseif ($angka < 100) { // 20 - 99
            $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
      } elseif ($angka < 200) { // 100 - 199
            $terbilang = ' seratus' . terbilang($angka - 100);
      } elseif ($angka < 1000) { // 200 - 999
            $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
      } elseif ($angka < 2000) { // 1.000 - 1.999
            $terbilang = ' seribu' . terbilang($angka - 1000);
      } elseif ($angka < 1000000) { // 2.000 - 999.999
            $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000);
      } elseif ($angka < 1000000000) { // 1000000 - 999.999.990
            $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
      }

      return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
      $nama_hari  = array(
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumad', 'Sabtu'
      );
      $nama_bulan = array(
            1 =>
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      );

      $tahun   = substr($tgl, 0, 4);
      $bulan   = $nama_bulan[(int) substr($tgl, 5, 2)];
      $tanggal = substr($tgl, 8, 2);
      $text    = '';

      if ($tampil_hari) {
            $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
            $hari        = $nama_hari[$urutan_hari];
            $text       .= "$hari, $tanggal $bulan $tahun";
      } else {
            $text       .= "$tanggal $bulan $tahun";
      }

      return $text;
}

function getTglHari($bulan, $tahun)
{
      $jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
      return $jumlahHari;
}

function bulan_indonesia($no_bulan)
{
      if ($no_bulan) {
            $nama_bulan = array(
                  1 =>
                  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );
            $bulan   = $nama_bulan[(int) $no_bulan];
            return $bulan;
      } else {
            return null;
      }
}

function tambah_nol_didepan($value, $threshold = null)
{
      return sprintf("%0" . $threshold . "s", $value);
}

function generateNewKode($kode, $prefix)
{
      $number = (int) substr($kode, strlen($prefix));
      $number++;
      return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
}

function getHeaders($table, $without_name)
{
      $columns_names =  Schema::getColumnListing($table);
      $columns_names = collect($columns_names)->diff($without_name);
      $columns_names = array_map(function ($names) {
            return str_replace("_", " ", $names);
      }, $columns_names->toArray());
      return $columns_names;
}

/**
 * Konvert rupiah ke bilangan bulat
 *
 **/
function convertToNumber($nominal)
{
      if ($nominal == null) {
            $nom = 0;
      } else {
            $nom = preg_replace('/[^0-9]/', '', $nominal);
      }
      return $nom;
}


/**
 * Konvert rupiah ke bilangan desimal
 *
 **/
function convertToDecimal($nominal)
{
      if ($nominal == null) {
            $nom = 0;
      } else {
            $nominal = str_replace('Rp ', '', $nominal); // Hapus "Rp "
            $nominal = str_replace('.', '', $nominal); // Hapus tanda titik sebagai pemisah ribuan
            $nominal = str_replace(',', '.', $nominal); // Ganti tanda koma dengan titik sebagai pemisah desimal
            $nom = (float)$nominal;
      }
      return $nom;
}

function jurnal($jurnal, $id_coa, $id_transaksi, $posisi_dr_cr, $nominal)
{
      if ($nominal > 0 && $nominal != null) {
            $result = $jurnal::create([
                  'id_coa' => $id_coa,
                  'id_transaksi' => $id_transaksi,
                  'posisi_dr_cr' => $posisi_dr_cr,
                  'nominal' => $nominal,
            ]);
            return $result;
      } else {
            return null;
      }
}

function createDetailProspektus($detail, $id_kontribusi, $id_prospektus,  $nominal)
{
      if ($nominal > 0 && $nominal != null) {
            $result = $detail::create([
                  'id_kontribusi' => $id_kontribusi,
                  'id_prospektus' => $id_prospektus,
                  'jumlah' => $nominal
            ]);
            return $result;
      } else {
            return null;
      }
}

function kode($model, $prefix, $column)
{
      $latestRow = $model::latest($column)->first();
      $latestKode = $latestRow ? $latestRow->{$column} : $prefix . '000000';
      $code = generateNewKode($latestKode, $prefix);
      while ($model::where($column, $code)->exists()) {
            $code = generateNewKode($code, $prefix);
      }

      return $code;
}

function getHariNow($bulan, $tahun)
{
      if ($bulan == date('m') && $tahun == date('Y')) {
            $hari = date('d');
      } else {
            $hari = getTglHari($bulan, $tahun);
      }
      return $hari;
}

/*accounting fungsi rekapitulasi*/
function getTotalFungsiRekap($header, $tahun, $bulan, $hari, $unit, $totalSaldoType, $fullYear = true)
{
      $totalSaldo = ($totalSaldoType === "kredit")
            ? DB::raw('(SUM(IF(posisi_dr_cr = "kredit", nominal, 0)) - SUM(IF(posisi_dr_cr = "debet", nominal, 0))) as total_saldo')
            : DB::raw('(SUM(IF(posisi_dr_cr = "debet", nominal, 0)) - SUM(IF(posisi_dr_cr = "kredit", nominal, 0))) as total_saldo');

      $fungsiA = function ($query) use ($tahun, $bulan, $hari, $unit, $header, $fullYear) {
            $query->where('unit', $unit);

            if ($fullYear) {
                  if ($header != 1 && $header != 2) {
                        $query->whereDate('tgl_transaksi', '>=', "$tahun-01-01");
                        $query->whereDate('tgl_transaksi', '<=', "$tahun-$bulan-$hari");
                  } else {
                        $query->where(function ($query) use ($tahun, $bulan, $hari) {
                              $query->whereDate('tgl_transaksi', '<=', "$tahun-$bulan-$hari");
                        });
                  }
            } else {
                  $query->whereDate('tgl_transaksi', '>=', "$tahun-$bulan-01");
                  $query->whereDate('tgl_transaksi', '<=', "$tahun-$bulan-$hari");
            }
      };

      $data = [
            'totalSaldo' => $totalSaldo,
            'fungsiA' => $fungsiA,
      ];

      return $data;
}

function getFungsiRekap($kolom, $isiKolom, $header, $kolom2, $isiKolom2)
{
      $fungsi = function ($query) use ($header, $kolom, $isiKolom, $kolom2, $isiKolom2) {
            $query->where('header', $header);

            if ($kolom !== null && $isiKolom !== null) {
                  $query->where($kolom, 'LIKE', $isiKolom);
            }

            if ($kolom2 !== null && $isiKolom2 !== null) {
                  $query->where($kolom2, 'LIKE', $isiKolom2);
            }
      };

      return $fungsi;
}

/*ending accounting fungsi rekapitulasi*/

/*penyusutan aset*/
function getNilai($status, $qty, $harga, $qtyE = null, $hargaE = null)
{
      if ($status == 'S') {
            $total = ($qty * $harga) + ($qtyE * $hargaE);
      } else {
            $total = $qty * $harga;
      }
      return $total;
}

function cekPenyusutan($tgl_beli, $umur, $harga_beli, $nilai_saat_ini)
{
      if ($tgl_beli == null or $umur == null or $umur <= 0 or $harga_beli == null  or $harga_beli <= 0 or $nilai_saat_ini == null or $nilai_saat_ini <= 0) {
            $ket = 'Inventaris tidak dapat disusutkan!';
      } else {
            $ket = 'Inventaris dapat disusutkan.';
      }
      return $ket;
}
/*end penyusutan aset*/

/*jurnal pembalik*/
function jurnalPembalik($jurnal, $id_transaksi, $id_transaksi_penyesuaian)
{
      $jurnalPembalik = $jurnal::with(['transaksi', 'coa'])->where('id_transaksi', $id_transaksi_penyesuaian)
            ->orderBy('id_jurnal', 'desc')->get();
      if ($jurnalPembalik) {
            foreach ($jurnalPembalik as $d) {
                  if ($d->posisi_dr_cr == 'kredit') {
                        jurnal($jurnal, $d->id_coa, $id_transaksi, 'debet', $d->nominal);
                  } else {
                        jurnal($jurnal, $d->id_coa, $id_transaksi, 'kredit', $d->nominal);
                  }
            }
            $data = [
                  'tipe' => 'kadaluwarsa',
            ];
            Transaksi::where('id_transaksi', $id_transaksi_penyesuaian)->update($data);
      }
}
/*end jurnal pembalik*/

function paginate($items, $perPage = 15, $page = null, $options = [])
{
      $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
      $items = $items instanceof Collection ? $items : Collection::make($items);
      return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
}
