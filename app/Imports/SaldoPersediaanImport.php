<?php

namespace App\Imports;

use App\Models\Barang;
use Illuminate\Support\Collection;
use App\Services\SaldoAwalBarangService;
use App\Services\TransaksiService;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SaldoPersediaanImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private $transaksiService;
    private $saldoAwalService;
    private $unit;

    protected $customValidationMessages = [
        'tanggal_mulai.required' => 'Tanggal mulai menggunakan aplikasi harus diisi!',
        'kode_unit.required' => 'Kode unit harus diisi!',
        'nama_barang.required' => 'Nama barang harus diisi!',
        'jenis_barang.required' => 'unit harus Pertokoan atau Simpan Pinjam!',
        'nama_unit.required' => 'Nama unit harus diisi!',
        'satuan.required' => 'Satuan harus diisi!',
        'stok.required' => 'Stok barang harus diisi!',
        'harga_barang.required' => 'Harga barang harus diisi!',
    ];

    public function __construct($unit)
    {
        $this->transaksiService = new TransaksiService;
        $this->saldoAwalService = new SaldoAwalBarangService;
        $this->unit = $unit;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $posisi = 'persediaan';
        $model = new Barang;
        $this->saldoAwalService->importToMainBarang($rows, $model, $this->unit, $posisi);
        $this->saldoAwalService->importToTransaksi($rows, $this->unit, $posisi);
        $dataSaldoBarang = $this->transaksiService->getTransaksiSaldoAwal($this->unit, $posisi);
        $id = $dataSaldoBarang->id_transaksi;
        $this->saldoAwalService->updateStokImportSementara($model, $this->unit, $posisi);
        $this->saldoAwalService->importToDetailJurnal($rows, $model, $this->unit, $posisi, $id);
    }

    public function rules(): array
    {
        return [
            'tanggal_mulai' => 'required',
            'kode_unit' => 'required',
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'nama_unit' => 'required',
            'satuan' => 'required',
            'stok' => 'required',
            'harga_barang' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
