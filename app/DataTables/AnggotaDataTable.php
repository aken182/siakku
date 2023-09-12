<?php

namespace App\DataTables;

use App\Models\Anggota;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class AnggotaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {

        return (new EloquentDataTable($query))
            ->addColumn('aksi', function (Anggota $anggota) {
                return '<a type="button" class="btn btn-sm btn-outline-primary" href="' . route('mdu-anggota.edit', ['id' => $anggota->id_anggota]) . '">Edit</a> 
                <a type="button" class="btn btn-sm btn-outline-danger" href="' . route('mdu-anggota.destroy', ['id' => $anggota->id_anggota]) . '" data-confirm-delete="true">Hapus</a>';
            })
            ->rawColumns(['aksi'])
            ->setRowId('id_anggota');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Anggota $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Anggota $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('anggota-table')
            ->columns($this->getColumns())
            ->minifiedAjax();
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('kode'),
            Column::make('nama'),
            Column::make('tempat_tugas'),
            Column::make('pekerjaan'),
            Column::make('status'),
            Column::make('aksi')
        ];
    }

    // protected function filename()
    // {
    //     return 'Anggota_' . date('YmdHis');
    // }
}
