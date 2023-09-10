<?php

namespace App\Services;

use App\Models\Coa;
use App\Models\Transaksi;
use App\Services\SaldoAwalService;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SaldoAwalCoaService
{
      private $saldoAwalService;
      private $importService;
      private $transaksiService;

      public function __construct()
      {
            $this->saldoAwalService = new SaldoAwalService;
            $this->importService = new ImportExportService;
            $this->transaksiService = new TransaksiService;
      }

      /**
       * Dokumentasi getTanggalImport
       *
       * Mengkonversi tanggal dari excel ke php dan mengambil tanggal 
       * 1 hari sebelumnya.
       *
       * @param mixed $tanggal
       * @return $tgl_transaksi
       **/
      public function getTanggalImport($tanggal)
      {

            $tanggal = (int)$tanggal;
            $tgl_rekap = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal);
            $newdate = date_sub($tgl_rekap, date_interval_create_from_date_string("1 days"));
            $tgl_transaksi = date_format($newdate, "Y-m-d");
            return $tgl_transaksi;
      }

      /**
       * Dokumentasi getIdTransaksiImport
       *
       * Mencari dan mengambil id_transaksi saldo awal coa 
       * dari tabel transaksi berdasarkan parameter 
       * tanggal transaksi dan unit.
       *
       * @param mixed $tanggal
       * @param mixed $unit
       * @return mixed $id
       **/
      public function getIdTransaksiImport($tanggal, $unit)
      {
            $id = Transaksi::where('tgl_transaksi', $tanggal)
                  ->where('tgl_transaksi', $tanggal)
                  ->where('jenis_transaksi', 'Saldo Awal COA')
                  ->where('detail_tabel', 'detail_saldo_awal')
                  ->where('unit', $unit)
                  ->value('id_transaksi');
            return $id;
      }

      /**
       * Dokumentasi getSaldoPosisi
       *
       * Mengambil saldo dan posisi akun yang
       * menggunakan kondisi untuk menentukan dengan 
       * nilai debet dan kredit sebagai parameter.
       *
       * @param mixed $debet
       * @param mixed $kredit
       * @return array $data
       * @throws conditon
       **/
      public function getSaldoPosisi($debet, $kredit)
      {
            $data = [];
            if ($kredit <= 0 && $debet > 0) {
                  $data['posisi'] = 'debet';
                  $data['saldo'] = $debet;
            } elseif ($kredit > 0 && $debet <= 0) {
                  $data['posisi'] = 'kredit';
                  $data['saldo'] = $kredit;
            }
            return $data;
      }

      /**
       * Dokumentasi getTotalDebetKredit
       *
       * Menjumlahkan total nilai debet dan kredit
       * saldo awal coa.
       *
       * @param mixed $rows
       * @return array
       **/
      public function getTotalDebetKredit($rows)
      {
            $total_debet = 0;
            $total_kredit = 0;
            foreach ($rows as $row) {
                  $total_debet += $row['debet'];
                  $total_kredit += $row['kredit'];
            }
            return [
                  'debet' => $total_debet,
                  'kredit' => $total_kredit,
            ];
      }

      /**
       * Dokumentasi importTransaksiFromSaldoAwal
       *
       * Mengimport data transaksi dari file excel
       * saldo awal coa ke dalam tabel transaksi
       * dalam database.
       *
       * @param mixed $transaksi
       * @param mixed $unit
       * @param mixed $total_debet
       * @param mixed $total_kredit
       * @return void
       **/
      public function importTransaksiFromSaldoAwal($transaksi, $unit, $total_debet, $total_kredit)
      {

            foreach ($transaksi as $row) {
                  $tgl_transaksi = $this->importService->getTanggalImport($row['tanggal_mulai']);
                  $id_transaksi = $this->getIdTransaksiImport($tgl_transaksi, $unit);
                  if ($id_transaksi) {
                        $this->saldoAwalService->updateTransaksiCoa($id_transaksi, $total_debet, $total_kredit);
                  } else {
                        $total = $total_debet + $total_kredit;
                        $kode = kode(new Transaksi, 'SLDOC-', 'kode');
                        $this->saldoAwalService->createTransaksiSaldoAwalCoa($total, $tgl_transaksi, $kode, $unit);
                  }
            }
      }

      /**
       * Dokumentasi ImportDetailJurnalFromExcel
       *
       * Mengimport data detail transaksi dan data jurnal dari file excel
       * saldo awal coa ke dalam tabel detail_saldo_awal 
       * tabel jurnal dalam database.
       *
       * @param mixed $rows
       * @param mixed $unit
       * @return void
       **/
      public function ImportDetailJurnalFromExcel($rows, $unit)
      {
            $transaksi = $this->transaksiService->getTransaksiSaldoAwal($unit);
            $id_transaksi = $transaksi->id_transaksi;
            foreach ($rows as $row) {
                  $id_coa = Coa::where('kode', $row['kode'])->value('id_coa');
                  $saldoPosisi = $this->getSaldoPosisi($row['debet'], $row['kredit']);
                  $id_detail = $this->saldoAwalService->getIdDetailCoa($id_transaksi, $id_coa);
                  if ($id_detail) {
                        $this->saldoAwalService->updateDetailCoa($id_detail, $saldoPosisi);
                  } else {
                        if ($saldoPosisi['saldo'] > 0) {
                              $this->saldoAwalService->createDetailCoa($id_transaksi, $id_coa, $saldoPosisi);
                        }
                  }
                  $id_jurnal = $this->saldoAwalService->getIdJurnalCoa($id_transaksi, $id_coa);
                  if ($id_jurnal) {
                        $this->saldoAwalService->updateJurnalCoa($id_jurnal, $saldoPosisi);
                  } else {
                        if ($saldoPosisi['saldo'] > 0) {
                              $this->saldoAwalService->createJurnalCoa($id_transaksi, $id_coa, $saldoPosisi);
                        }
                  }
            }
      }
}
