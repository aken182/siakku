<form class="form" action="{{ route($store) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-1">
        <div class="col-md-6 col-12">
            <span class="text-success">Petunjuk : Format file excel harus sesuai dengan
                template dibawah ini!</span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6 col-12">
            <a type="button" class="btn btn-outline-success icon dripicons dripicons-cloud-download"
                href="{{ route($template) }}" target="_blank">&nbsp;Unduh
                Template !</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label class="text-primary">File Excel</label>
                <input type="file" class="form-control @error('file') is-invalid @enderror" name="file">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <span class="text-danger">{{ $error }}</span><br>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @if (session()->has('failures'))
        <div class="row">
            <div class="col-md-12 col-12">
                <small>
                    <table class="table table-danger dataTable">
                        <thead>
                            <tr>
                                <td>Baris</td>
                                <td>Nama Kolom</td>
                                <td>Pesan Error</td>
                                <td>Isi Kolom</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (session()->get('failures') as $v)
                                <tr>
                                    <td>{{ $v->row() }}</td>
                                    <td>{{ $v->attribute() }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($v->errors() as $e)
                                                <li>
                                                    @if (session()->has('customValidationMessages') &&
                                                            isset(session('customValidationMessages')[$v->attribute() . '.' . $e]))
                                                        {{ session('customValidationMessages')[$v->attribute() . '.' . $e][0] }}
                                                    @else
                                                        {{ $e }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $v->values()[$v->attribute()] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </small>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
            <a type="button" href="{{ route($main) }}" class="btn btn-light-secondary me-1 mb-1">Keluar</a>
        </div>
    </div>
</form>
