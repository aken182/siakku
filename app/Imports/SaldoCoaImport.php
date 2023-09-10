<?php

namespace App\Imports;

use App\Services\CoaService;
use App\Services\ImportExportService;
use App\Services\SaldoAwalCoaService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SaldoCoaImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
      use Importable, SkipsFailures;

      private $coaService;
      private $importService;
      private $saldoAwalCoaService;
      private $unit;
      protected $customValidationMessages = [
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi!',
            'kode.required' => 'Kode akun wajib diisi!',
            'nama.required' => 'Nama akun wajib diisi!',
            'kategori.required' => 'Kategori akun wajib diisi!',
            'header.required' => 'Header akun wajib diisi!',
            'header.in' => 'Header akun harus salah satu dari 1,2,3,4,5 atau 8!',
            'debet.required' => 'Saldo debet wajib diisi!',
            'kredit.required' => 'Saldo kredit wajib diisi!',
      ];

      public function __construct($unit)
      {
            $this->coaService = new CoaService;
            $this->importService = new ImportExportService;
            $this->saldoAwalCoaService = new SaldoAwalCoaService;
            $this->unit = $unit;
      }

      public function collection(Collection $rows)
      {
            $this->coaService->importCoaFromSaldoAwal($rows);
            $totalDebetKredit = $this->saldoAwalCoaService->getTotalDebetKredit($rows);
            $total_debet = $totalDebetKredit['debet'];
            $total_kredit = $totalDebetKredit['kredit'];
            $transaksi = $this->importService->getDataUnique($rows, 'tanggal_mulai');
            $this->saldoAwalCoaService->importTransaksiFromSaldoAwal($transaksi, $this->unit, $total_debet, $total_kredit);
            $this->saldoAwalCoaService->ImportDetailJurnalFromExcel($rows, $this->unit);
      }

      public function rules(): array
      {
            return [
                  'tanggal_mulai' => 'required',
                  'kode' => 'required',
                  'nama' => 'required',
                  'kategori' => 'required',
                  'header' => 'required',
                  'debet' => 'required',
                  'kredit' => 'required',
            ];
      }
      public function customValidationMessages()
      {
            return $this->customValidationMessages;
      }
}
