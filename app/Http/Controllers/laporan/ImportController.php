<?php

namespace App\Http\Controllers\laporan;

use Illuminate\Http\Request;
use App\Exports\TemplatesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Services\ImportExportService;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    protected $importService;

    public function __construct()
    {
        $this->importService = new ImportExportService;
    }

    public function index(Request $request)
    {
        $index = $this->importService->getDataIndex();
        $data = [
            'title' => $index['title'],
            'routeStore' => $index['routeStore'],
            'routeMain' => $index['routeMain'],
            'routeTemplate' => $index['routeTemplate'],
        ];
        return view('content.import.form-import', $data);
    }

    public function import(ImportRequest $request)
    {
        $index = $this->importService->getDataIndex();
        $route = $index['routeNow'];
        $dataimport = $this->importService->importData();

        $import = $dataimport[$route];
        $import->import($request->file('file'));

        $failures = $import->failures();
        if ($failures->isNotEmpty()) {
            return back()
                ->withFailures($failures)
                ->withCustomValidationMessages($import->customValidationMessages());
        }

        alert()->success('Sukses', 'File excel berhasil diimport!');
        return redirect()->route($index['routeMain']);
    }

    public function template(Request $request)
    {
        return Excel::download(new TemplatesExport($request), 'template.xlsx');
    }
}
