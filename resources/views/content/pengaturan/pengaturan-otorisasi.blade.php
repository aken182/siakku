@extends('layouts.contentSidebarLayout')

@section('title', "Pengaturan - $title")

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <form class="row" style="text-transform: capitalize"
                        action="{{ route('pengaturan-otorisasi.assignPermission') }}" method="POST">
                        @csrf

                        <div class="col-lg-4">
                            <div class="mb-2">
                                <label class="form-label" for="role-data-list">Pilih Role</label>

                                <select class="form-select dselect-select-box @error('role_name') is-invalid @enderror"
                                    id="role-data-list" name="role_name">
                                    <option>Pilih Role</option>
                                    @forelse ($roleData as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @error('role_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4" id="rumah">
                            <h6 class="text-light fw-semibold">Rumah</h6>
                            <div class="demo-inline-spacing mt-2">
                                <div class="list-group">
                                    <label class="list-group-item list-group-item-action">
                                        <input class="form-check-input me-1" id="cb-all" type="checkbox"
                                            value="">Pilih
                                        Semua
                                    </label>
                                    @foreach ($permissionData as $permission)
                                        @if ($permission->authority == 'rumah')
                                            <label class="list-group-item list-group-item-action">
                                                <input class="form-check-input me-1"
                                                    name="permission_name{{ $permission->id }}" type="checkbox"
                                                    value="{{ $permission->name }}">
                                                {{ $permission->name }}
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="sekolah">
                            <h6 class="text-light fw-semibold">Sekolah</h6>
                            <div class="demo-inline-spacing mt-2">
                                <div class="list-group">
                                    <label class="list-group-item list-group-item-action">
                                        <input class="form-check-input me-1" id="cb-all2" type="checkbox"
                                            value="">Pilih
                                        Semua
                                    </label>
                                    @foreach ($permissionData as $permission)
                                        @if ($permission->authority == 'sekolah')
                                            <label class="list-group-item list-group-item-action">
                                                <input class="form-check-input me-1"
                                                    name="permission_name{{ $permission->id }}" type="checkbox"
                                                    value="{{ $permission->name }}">
                                                {{ $permission->name }}
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="mt-4">
                                <button class="btn btn-primary me-2" type="submit">Simpan</button>
                                <button class="btn btn-outline-secondary" type="reset">Keluar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById("cb-all").addEventListener("click", function() {
            var checkboxes = document.querySelectorAll("#rumah input[type='checkbox']");
            for (var i = 0; i < checkboxes.length; i++) {
                // var obj = {};
                checkboxes[i].checked = this.checked;
                // document.getElementById(i).value = obj["permission" + i];
            }
        });
        document.getElementById("cb-all2").addEventListener("click", function() {
            var checkboxes = document.querySelectorAll("#sekolah input[type='checkbox']");
            for (var i = 0; i < checkboxes.length; i++) {
                // var obj = {};
                checkboxes[i].checked = this.checked;
                // document.getElementById(i).value = obj["permission" + i];
            }
        });
    </script>
@endsection
