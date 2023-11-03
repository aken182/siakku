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
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <label class="form-label text-primary" for="role-data-list"><b>Role</b></label>

                                    <select class="form-select choices @error('role_name') is-invalid @enderror"
                                        id="role-data-list" name="role_name">
                                        <option>Pilih Role</option>
                                        @forelse ($roleData as $role)
                                            <option value="{{ $role->name }}">{{ str_replace('-', ' ', $role->name) }}
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
                        </div>
                        <div class="row mb-3">
                            <div class="divider divider-primary">
                                <div class="divider-text">
                                    <h4 class="text-center text-primary">Daftar Hak Akses Pengguna</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4" id="pertokoan">
                                <label class="fw-semibold  text-primary"><b>Unit Pertokoan</b></label>
                                <div class="demo-inline-spacing mt-2">
                                    <div class="list-group">
                                        <label class="list-group-item list-group-item-action">
                                            <input class="form-check-input me-1" id="cb-all" type="checkbox"
                                                value="">Pilih
                                            Semua
                                        </label>
                                        @foreach ($permissionData as $permission)
                                            @if ($permission->authority === 'pertokoan')
                                                <label class="list-group-item list-group-item-action">
                                                    <input class="form-check-input me-1"
                                                        name="permission_name{{ $permission->id }}" type="checkbox"
                                                        value="{{ $permission->name }}">
                                                    {{ str_replace('-', ' ', $permission->name) }}
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" id="simpan-pinjam">
                                <label class="fw-semibold text-primary"><b>Unit Simpan Pinjam</b></label>
                                <div class="demo-inline-spacing mt-2">
                                    <div class="list-group">
                                        <label class="list-group-item list-group-item-action">
                                            <input class="form-check-input me-1" id="cb-all2" type="checkbox"
                                                value="">Pilih
                                            Semua
                                        </label>
                                        @foreach ($permissionData as $permission)
                                            @if ($permission->authority === 'simpan-pinjam')
                                                <label class="list-group-item list-group-item-action">
                                                    <input class="form-check-input me-1"
                                                        name="permission_name{{ $permission->id }}" type="checkbox"
                                                        value="{{ $permission->name }}">
                                                    {{ str_replace('-', ' ', $permission->name) }}
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" id="super-admin">
                                <label class="fw-semibold text-primary"><b>Super Admin</b></label>
                                <div class="demo-inline-spacing mt-2">
                                    <div class="list-group">
                                        <label class="list-group-item list-group-item-action">
                                            <input class="form-check-input me-1" id="cb-all3" type="checkbox"
                                                value="">Pilih
                                            Semua
                                        </label>
                                        @foreach ($permissionData as $permission)
                                            @if ($permission->authority === 'super-admin')
                                                <label class="list-group-item list-group-item-action">
                                                    <input class="form-check-input me-1"
                                                        name="permission_name{{ $permission->id }}" type="checkbox"
                                                        value="{{ $permission->name }}">
                                                    {{ str_replace('-', ' ', $permission->name) }}
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
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

@endsection
@section('pageScript')
    <script>
        document.getElementById("cb-all").addEventListener("click", function() {
            var checkboxes = document.querySelectorAll("#pertokoan input[type='checkbox']");
            for (var i = 0; i < checkboxes.length; i++) {
                // var obj = {};
                checkboxes[i].checked = this.checked;
                // document.getElementById(i).value = obj["permission" + i];
            }
        });
        document.getElementById("cb-all2").addEventListener("click", function() {
            var checkboxes = document.querySelectorAll("#simpan-pinjam input[type='checkbox']");
            for (var i = 0; i < checkboxes.length; i++) {
                // var obj = {};
                checkboxes[i].checked = this.checked;
                // document.getElementById(i).value = obj["permission" + i];
            }
        });
        document.getElementById("cb-all3").addEventListener("click", function() {
            var checkboxes = document.querySelectorAll("#super-admin input[type='checkbox']");
            for (var i = 0; i < checkboxes.length; i++) {
                // var obj = {};
                checkboxes[i].checked = this.checked;
                // document.getElementById(i).value = obj["permission" + i];
            }
        });
    </script>
@endsection
