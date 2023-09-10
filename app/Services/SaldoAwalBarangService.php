<?php

namespace App\Services;

use App\Models\Unit;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Services\UnitService;
use App\Services\BarangService;
use App\Services\SatuanService;
use App\Models\Saldo_awal_barang;
use App\Services\TransaksiService;
use App\Services\AccountingService;
use App\Services\ImportExportService;


class SaldoAwalBarangService
{
      private $transaksiService;
      private $accountingService;
      private $barangService;
      private $importService;
      private $satuanService;
      private $unitService;

      public function __construct()
      {
            $this->transaksiService = new TransaksiService;
            $this->accountingService = new AccountingService;
            $this->barangService = new BarangService;
            $this->importService = new ImportExportService;
            $this->satuanService = new SatuanService;
            $this->unitService = new UnitService;
      }

      /**
       * Dokumentasi getKode Transaksi Saldo Awal Barang
       *
       * Mengambil kode transaksi dengan mencari kode 
       * yang belum digunakan untuk dijadikan 
       * parameter dalam membuat transaksi saldo awal barang
       *
       * @param mixed $model
       * @param mixed $jenis
       * @return $kode
       **/
      public function getKode($model, $jenis)
      {
            $prefix = $jenis === 'inventaris' ? 'SLDOI-' : 'SLDOP-';
            $kode = kode($model, $prefix, 'kode');
            return $kode;
      }

      /**
       * Dokumentasi create transaksi saldo awal barang
       *
       * Merangkum fungsi-fungsi untuk menyimpan 
       * transaksi saldo awal barang
       *
       * @param Request $request
       * @param mixed $kode
       * @param mixed $unit
       * @param mixed $jenis
       * @return void
       **/
      public function create($request, $kode, $unit, $jenis)
      {
            $data = json_decode($request->input('data_barang'), true);
            $tanggal = $request->input('tgl_transaksi');
            $total = convertToNumber($request->input('total_transaksi'));
            self::createTransaksi($tanggal, $kode, $unit, $jenis, $total);
            $id_transaksi = $this->transaksiService->getIdTransaksiCreate($kode);
            foreach ($data as $d) {
                  self::createDetail($d, $id_transaksi, $jenis);
            }
            $this->accountingService->jurnalSaldoAwalBarang($data, $id_transaksi, $jenis);
      }

      /**
       * Input transaksi saldo awal barang
       *
       * Menyimpan data transaksi kedalam
       * tabel transaksi
       *
       * @param Request $request
       * @param mixed $tanggal
       * @param mixed $kode
       * @param mixed $unit
       * @param mixed $jenis
       * @param mixed $total
       * @return void
       **/
      public function createTransaksi($tanggal, $kode, $unit, $jenis, $total)
      {
            Transaksi::create([
                  'tgl_transaksi' => $tanggal,
                  'kode' => $kode,
                  'jenis_transaksi' => 'Saldo Awal ' . $jenis,
                  'detail_tabel' => 'saldo_awal_barang',
                  'metode_transaksi' => 'Saldo Awal',
                  'unit' => $unit,
                  'keterangan' => 'Input Saldo Awal ' . $jenis . ' Unit ' . $unit,
                  'total' => $total,
            ]);
      }

      /**
       *Input detail transaksi saldo awal barang
       *
       * Menyimpan data detail ke dalam 
       * tabel saldo_awal_barang & kedalam tabel barang
       *
       * @param mixed $data
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @return void
       **/
      public function createDetail($data, $id_transaksi, $jenis)
      {
            $model = new Barang;
            if ($data['jenis'] === "barang baru") {
                  $prefix = Unit::where('id_unit', $data['id_unit'])->value('kode_unit');
                  $kode = kode($model, $prefix, 'kode_barang');
                  $this->barangService->createPengadaanBarang($model, $data, $kode, $jenis);
                  $id_barang = $model::where('kode_barang', $kode)->value('id_barang');
            } else {
                  $this->barangService->updatePengadaanBarang($model, $data);
                  $id_barang = $data['id_barang'];
            }
            $nilaiBuku = $jenis === "inventaris" ? $data['nilai_buku'] : null;
            self::createSaldoAwalBarang($id_transaksi, $jenis, $id_barang, $nilaiBuku, $data);
      }

      /**
       * Input detail saldo awal barang
       *
       * Menyimpan detail saldo awal barang ke dalam
       * tabel saldo_awal_barang
       *
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @param mixed $id_barang
       * @param mixed $nilaiBuku
       * @param Array $data
       * @param mixed $subtotal
       * @return void
       **/
      public function createSaldoAwalBarang($id_transaksi, $jenis, $id_barang, $nilaiBuku, $data, $subtotal = null)
      {
            Saldo_awal_barang::create([
                  'id_transaksi' => $id_transaksi,
                  'posisi' => $jenis,
                  'id_barang' => $id_barang,
                  'qty' => $data['qty'] ?? $data['stok'],
                  'harga' => $data['harga'] ?? $data['harga_barang'],
                  'nilai_buku' => $nilaiBuku,
                  'subtotal' => $data['subtotal'] ?? $subtotal,
            ]);
      }

      /**
       * Input detail saldo awal barang
       *
       * Mengubah detail saldo awal barang berdasarkan id_transaksi
       * pada tabel saldo_awal_barang
       *
       * @param mixed $id_saldo
       * @param mixed $id_transaksi
       * @param mixed $jenis
       * @param Array $data
       * @param mixed $subtotal
       * @param mixed $nilai_buku
       * @return void
       **/
      public function updateSaldoAwalBarang($id_saldo, $id_transaksi, $jenis, $data, $subtotal = null, $nilai_buku = null)
      {
            Saldo_awal_barang::where('id_saldo', $id_saldo)
                  ->update([
                        'id_transaksi' => $id_transaksi,
                        'posisi' => $jenis,
                        'qty' => $data['qty'] ?? $data['stok'],
                        'harga' => $data['harga'] ?? $data['harga_barang'],
                        'nilai_buku' => $data['nilai_buku'] ?? $nilai_buku,
                        'subtotal' => $data['subtotal'] ?? $subtotal
                  ]);
      }

      /**
       * Dokumentasi update transaksi saldo awal barang
       *
       * Merangkum fungsi-fungsi untuk mengupdate
       * transaksi saldo awal barang
       *
       * @param mixed $request
       * @param int $id
       * @param mixed $jenis
       * @param mixed $unit
       * @return void
       **/
      public function update($request, $id, $jenis, $unit)
      {
            $data = json_decode($request->input('data_barang'), true);
            self::updateTransaksi($id, $request->input('total_transaksi'));
            self::updateDetail($data, $id, $jenis, $unit);
            $this->accountingService->updateJurnalSaldoAwalBarang($data, $id, $jenis);
      }

      /**
       * Dokumentasi updateTransaksi
       *
       * Mengupdate total transaksi saldo awal barang
       * dan waktu updatenya berdasarkan id transaksi 
       * kedalam tabel transaksi 
       *
       * @param int $id
       * @param mixed $total
       * @return void
       **/
      function updateTransaksi($id, $total)
      {
            $update_transaksi = [
                  'total' => convertToNumber($total),
                  'updated_at' => now()
            ];
            Transaksi::where('id_transaksi', $id)->update($update_transaksi);
      }

      /**
       *Update detail transaksi saldo awal barang
       *
       * Mengupdate data detail ke dalam 
       * tabel saldo_awal_barang & kedalam tabel barang
       *
       * @param mixed $data
       * @param int $id
       * @param mixed $jenis
       * @param mixed $unit
       * @return void
       **/
      public function updateDetail($data, $id, $jenis, $unit)
      {
            $model = new Barang;
            $modelSaldo = new Saldo_awal_barang;
            $transaksi = $this->transaksiService->saldoAwalBarang($unit, $jenis);
            foreach ($transaksi as $t) {
                  self::updateStokBarangSementara($model, $modelSaldo, $t->id_saldo, $t->id_barang);
            }
            foreach ($data as $d) {
                  $id_saldo = self::getIdSaldo($id, $d['id_barang']);
                  if ($id_saldo) {
                        $this->barangService->updatePengadaanBarang($model, $d);
                        $this->updateSaldoAwalBarang($id_saldo, $id, $jenis, $d);
                  } else {
                        self::createDetail($d, $id, $jenis);
                  }
            }
      }

      /**
       * Update stok barang sementara berdasarkan 
       * data saldo awal barang
       *
       * @param mixed $model
       * @param mixed $modelSaldo
       * @param mixed $id_saldo
       * @param mixed $id_barang
       * @return void
       **/
      public function updateStokBarangSementara($model, $modelSaldo, $id_saldo, $id_barang)
      {
            $stokSaldo = $modelSaldo::where('id_saldo', $id_saldo)->value('qty');
            $stokBarang = $model::where('id_barang', $id_barang)->value('stok');
            $stok = $stokBarang - $stokSaldo;
            $model::where('id_barang', $id_barang)->update([
                  'stok' => $stok,
                  'harga_barang' => 0,
                  'nilai_saat_ini' => 0,
            ]);
            $modelSaldo::where('id_saldo', $id_saldo)->update([
                  'qty' => 0,
                  'harga' => 0,
                  'nilai_buku' => 0,
                  'subtotal' => 0,
            ]);
      }

      /**
       *Dokumentasi getIdSaldo
       *
       * Mengambil id_saldo dari tabel saldo_awal_barang 
       * yang dijadikan parameter untuk mengupdate 
       * saldo awal barang
       *
       * @param mixed $id
       * @param mixed $id_barang
       * @return mixed
       **/
      public function getIdSaldo($id, $id_barang)
      {
            return Saldo_awal_barang::where('id_transaksi', $id)->where('id_barang', $id_barang)->value('id_saldo');
      }

      /**
       * Dokumentasi getTotalTransaksi
       *
       * Menghitung total transaksi saldo awal
       * barang menggunakan perulangan dari file
       * import excel saldo awal barang
       *
       * @param mixed $rows
       * @return mixed $total
       **/
      public function getTotalTransaksi($rows)
      {
            $total = 0;
            foreach ($rows as $row) {
                  $subtotal = $row['stok'] * $row['harga_barang'];
                  $total += $subtotal;
            }
            return $total;
      }

      /**
       * Dokumentasi getIdTransaksiImport
       *
       * Mencari dan mengambil id_transaksi saldo awal barang 
       * dari tabel transaksi berdasarkan parameter 
       * tanggal transaksi, unit, dan posisi.
       *
       * @param mixed $tanggal
       * @param mixed $unit
       * @param mixed $posisi
       * @return mixed $id
       **/
      public function getIdTransaksiImport($tanggal, $unit, $posisi)
      {
            $id = Transaksi::where('tgl_transaksi', $tanggal)
                  ->where('tgl_transaksi', $tanggal)
                  ->where('jenis_transaksi', 'Saldo Awal ' . $posisi)
                  ->where('detail_tabel', 'saldo_awal_barang')
                  ->where('unit', $unit)
                  ->value('id_transaksi');
            return $id;
      }

      /**
       * Dokumentasi importMainBarang
       *
       * Memuat semua fungsi untuk mengimport
       * file excel menyangkut data satuan, data unit,
       * dan data barang
       *
       * @param mixed $rows
       * @param mixed $model
       * @param mixed $unit
       * @param mixed $posisi
       * @return void
       **/
      public function importToMainBarang($rows, $model, $unit, $posisi)
      {
            $data_satuan = $this->importService->getDataUnique($rows, 'satuan');
            $data_unit = $this->importService->getDataUnique($rows, 'kode_unit');
            $this->satuanService->createSatuanToImport($data_satuan);
            $this->unitService->createUnitToImport($data_unit, $unit);
            foreach ($rows as $row) {
                  $row['unit'] = $row['unit'] ?? $unit;
                  $satuan = $this->satuanService->getSatuanToImport($row['satuan']);
                  $dataUnit = $this->unitService->getUnitToImport($row['nama_unit'], $row['unit']);
                  if ($dataUnit) {
                        $id_barang = $this->barangService->getIdBarangImport($row, $unit, $posisi);
                        if ($id_barang) {
                              continue;
                        } else {
                              $kode = kode($model, $dataUnit->kode_unit, 'kode_barang');
                              $this->barangService->createToImport($satuan->id_satuan, $dataUnit->id_unit, $kode, $posisi, $row);
                        }
                  } else {
                        continue;
                  }
            }
      }

      /**
       * Dokumentasi importToTransaksi
       *
       * Memuat semua fungsi untuk mengimport data excel
       * kedalam tabel transaksi dalam database.
       *
       * @param mixed $rows
       * @param mixed $unit
       * @return mixed $posisi
       * @return void
       **/
      public function importToTransaksi($rows, $unit, $posisi)
      {
            $total = self::getTotalTransaksi($rows);
            $transaksi = $this->importService->getDataUnique($rows, 'tanggal_mulai');
            foreach ($transaksi as $t) {
                  $tanggal = $this->importService->getTanggalImport($t['tanggal_mulai']);
                  $id_transaksi = self::getIdTransaksiImport($tanggal, $unit, $posisi);
                  if ($id_transaksi) {
                        self::updateTransaksi($id_transaksi, $tanggal);
                  } else {
                        $kode = self::getKode(new Transaksi, $posisi);
                        self::createTransaksi($tanggal, $kode, $unit, $posisi, $total);
                  }
            }
      }

      /**
       * Dokumentasi updateStokImportSementara
       *
       * Mengecek apakah terdapat transaksi saldo
       * awal barang dan jika transaksinya ada maka
       * stok barang dari file excel akan diupdate 
       * untuk sementara sebelum mengimport data detail dan 
       * jurnalnya.
       *
       * @param mixed $model
       * @param mixed $unit
       * @param mixed $posisi
       * @return void
       **/
      public function updateStokImportSementara($model, $unit, $posisi)
      {
            $modelSaldo = new Saldo_awal_barang;
            $transaksiBarang = $this->transaksiService->saldoAwalBarang($unit, $posisi);
            if ($transaksiBarang) {
                  foreach ($transaksiBarang as $t) {
                        self::updateStokBarangSementara($model, $modelSaldo, $t->id_saldo, $t->id_barang);
                  }
            }
      }

      /**
       * Dokumentasi importToTransaksi
       *
       * Memuat semua fungsi untuk mengimport data excel
       * kedalam tabel saldo_awal_barang dan tabel 
       * jurnal dalam database.
       *
       * @param mixed $data
       * @param mixed $model
       * @param mixed $unit
       * @param mixed $posisi
       * @param mixed $id
       * @return void
       **/
      public function importToDetailJurnal($data, $model, $unit, $posisi, $id)
      {
            foreach ($data as $d) {
                  $id_barang = $this->barangService->getIdBarangImport($d, $unit, $posisi);
                  $id_saldo = self::getIdSaldo($id, $id_barang);
                  $subtotal = self::getSubtotalImport($d, $posisi);
                  $nilai_buku = $d['nilai_saat_ini'] ?? null;
                  if ($id_saldo) {
                        $this->barangService->updatePengadaanBarang($model, $d, $id_barang);
                        self::updateSaldoAwalBarang($id_saldo, $id, $posisi, $d, $subtotal, $nilai_buku);
                  } else {
                        $this->barangService->updatePengadaanBarang($model, $d, $id_barang);
                        self::createSaldoAwalBarang($id, $posisi, $id_barang, $nilai_buku, $d, $subtotal);
                  }
            }
            $this->accountingService->updateJurnalSaldoAwalBarang($data, $id, $posisi);
      }

      /**
       *Dokumentasi getIdSubtotal
       *
       * Mengambil subtotal barang dari data file excel 
       * sesuai dengan jenisnya.
       * 
       * @param mixed $data
       * @param mixed $posisi
       * @return mixed
       **/
      public function getSubtotalImport($data, $posisi)
      {
            if ($posisi === 'persediaan') {
                  $subtotal = $data['stok'] * $data['harga_barang'];
            } else {
                  $subtotal = $data['stok'] * $data['nilai_saat_ini'];
            }
            return $subtotal;
      }
}
