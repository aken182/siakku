@extends('layouts/contentSidebarLayout')
@section('title', $title)
@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / {{ $title }}</span></h4>

    {{-- <div class="col-md-12"> --}}
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCenter" type="button">
                Tambah {{ $title }}
            </button>
        </li>
    </ul>

    <!-- Modal Form input create hak akses-->
    {{-- <form class="modal-content" action="{{ route('set-permission.setPermission') }}" method="post">
        @csrf
        <div class="modal fade" id="modalCenter" aria-hidden="true" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah {{ $title }}</h5>
                        <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input
                                    class="form-control
                                     @error('name') is-invalid @enderror"
                                    id="name" name="name" type="text" value="{{ old('name') }}"
                                    placeholder="ex: Admin-Rumah">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label" for="description">Keterangan</label>
                                <input class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" type="text" value="{{ old('description') }}"
                                    placeholder="ex: Admin Rumah Sesado">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form> --}}

    <!-- Basic Layout -->
    <div class="row">
        <div class="card">

            {{-- <h5 class="card-header">Table Basic</h5> --}}
            {{-- <div class="col-xl-9"> --}}

            <h5 class="card-header text-muted">{{ $title }}</h5>
            <div class="nav-align-top mb-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="navs-pills-justified-home" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>

                                        @foreach ($tableHeader as $data => $field)
                                            <th>{{ $field }}</th>
                                        @endforeach

                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($permissionData as $field)
                                        <tr data-href="{{ route('set-permission', $field->id) }}">
                                            <td>{{ $field->id }}</td>
                                            <td>{{ $field->name }}</td>
                                            <td>{{ $field->description }}</td>
                                            <td>{{ $field->guard_name }}</td>
                                            <td>{{ $field->created_at }}</td>
                                            <td>{{ $field->updated_at }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown" type="button"><i
                                                            class="bx bx-dots-vertical-rounded"></i></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="bx bx-edit-alt me-1"></i>
                                                            Ubah</a>
                                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                                class="bx bx-trash me-1"></i>
                                                            Hapus</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                        <form action="" method="POST">
                            @csrf
                            <input class="form-control" name="file" type="file">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>

    {{-- </div> --}}
@endsection
