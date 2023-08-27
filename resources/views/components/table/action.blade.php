<div class="buttons">
    @if (isset($routeshow))
        <a type="button" class="btn btn-sm btn-info" href="{{ $routeshow }}">Detail</a>
    @endif
    @if (isset($routeedit))
        <a type="button" class="btn btn-sm btn-primary" href="{{ $routeedit }}">Edit</a>
    @endif
    @if (isset($routedelete))
        <a type="button" class="btn btn-sm btn-danger" href="{{ $routedelete }}" data-confirm-delete="true">Hapus</a>
    @endif
</div>
