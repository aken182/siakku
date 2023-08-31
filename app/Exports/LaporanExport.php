<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Services\ImportExportService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{

    private $importService;
    private $request;

    public function __construct(Request $request)
    {
        $this->importService = new ImportExportService;
        $this->request = $request;
    }

    public function view(): View
    {
        $route = $this->request->route()->getName();
        $data = $this->importService->getDataExport($route);
        return view('content.export.laporan.main', [
            'tabel' => $data['dataTabel'],
            'jenisTabel' => $data['jenisTabel']
        ]);
    }
}
