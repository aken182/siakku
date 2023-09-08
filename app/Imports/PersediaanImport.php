<?php

namespace App\Imports;

use App\Models\Barang;
use App\Services\UnitService;
use App\Services\BarangService;
use App\Services\SatuanService;
use Illuminate\Support\Collection;
use App\Services\ImportExportService;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PersediaanImport implements ToCollection, WithValidation, WithHeadingRow, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private $importService;
    private $satuanService;
    private $unitService;
    private $barangService;

    protected $customValidationMessages = [
        'kode_unit.required' => 'Kode unit harus diisi!',
        'nama_barang.required' => 'Nama barang harus diisi!',
        'jenis_barang.required' => 'unit harus Pertokoan atau Simpan Pinjam!',
        'nama_unit.required' => 'Nama unit harus diisi!',
        'unit.required' => 'Unit harus diisi!',
        'satuan.required' => 'satuan harus diisi!',
        // 'harga_barang.required' => 'Harga barang harus diisi!',
    ];

    public function __construct()
    {
        $this->importService = new ImportExportService;
        $this->satuanService = new SatuanService;
        $this->unitService = new UnitService;
        $this->barangService = new BarangService;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $posisi = 'persediaan';
        $data_satuan = $this->importService->getDataUnique($rows, 'satuan');
        $data_unit = $this->importService->getDataUnique($rows, 'kode_unit');
        $this->satuanService->createSatuanToImport($data_satuan);
        $this->unitService->createUnitToImport($data_unit);

        foreach ($rows as $row) {
            $satuan = $this->satuanService->getSatuanToImport($row['satuan']);
            $unit = $this->unitService->getUnitToImport($row['nama_unit'], $row['unit']);

            if ($unit) {
                $kode = kode(new Barang, $unit->kode_unit, 'kode_barang');
                $this->barangService->createToImport($satuan->id_satuan, $unit->id_unit, $kode, $posisi, $row);
            } else {
                continue;
            }
        }
    }

    public function rules(): array
    {
        return [
            'kode_unit' => 'required',
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'nama_unit' => 'required',
            'unit' => 'required',
            'satuan' => 'required',
            // 'harga_barang' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return $this->customValidationMessages;
    }
}
