<div class="row">
    <div class="col">
        @if (isset($routecreate))
            <a class="btn btn-sm btn-outline-primary" type="button" href="{{ $routecreate }}">Tambah
                Data</a>
        @endif
        @if (isset($routeexcel))
            <a class="btn btn-sm btn-outline-success" target="_blank" type="button" href="{{ $routeexcel }}">Export
                Excel</a>
        @endif
        @if (isset($routepdf))
            <a class="btn btn-sm btn-outline-danger" target="_blank" type="button" href="{{ $routepdf }}">Export
                PDF</a>
        @endif
        @if (isset($routeimport))
            <a class="btn btn-sm btn-outline-success" type="button" href="{{ $routeimport }}">Import
                Excel</a>
        @endif
    </div>
</div>
