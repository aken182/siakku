<form action="{{ route($route . '.store-satu') }}" method="post">
    @csrf
    <div class="card-body">
        <div class="card shadow-none bg-transparent border border-info mb-3">
            <div class="card-body">
                <div class="row mb-3">
                    <h5 class="card-title mb-0">Step - 1</h5><small class="text-info"> Pilih jenis penyusutan dan seleksi
                        inventaris yang akan disusutkan.</small>
                </div>
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="row mb-3">
                        <label class="form-label text-info"><b>Jenis Penyusutan</b></label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check mt-3">
                                    <label class="form-check-label" for="penyusutanBaru">
                                        Transaksi Baru
                                    </label>
                                    <input class="form-check-input @error('cek_penyusutan') is-invalid @enderror"
                                        name="cek_penyusutan" type="radio" value="baru" id="penyusutanBaru" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-check mt-3">
                                    <label class="form-check-label" for="penyusutanPenyesuaian">
                                        Penyesuaian
                                    </label>
                                    <input class="form-check-input @error('cek_penyusutan') is-invalid @enderror"
                                        name="cek_penyusutan" type="radio" value="penyesuaian"
                                        id="penyusutanPenyesuaian" />
                                    @error('cek_penyusutan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 detail-penyesuaian-penyusutan">
                        <label class="form-label text-info"><b>Penyusutan yang Disesuaikan</b></label>
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input type="hidden" id="route-penyesuaian" data-route="{{ route($routepny) }}" />
                                    <select name="id_penyusutan_penyesuaian" id="invoicePenyesuaianPenyusutan"
                                        class="form-select choices invoicePenyesuaianPenyusutan @error('id_penyusutan_penyesuaian') is-invalid @enderror">
                                        <option value="">Pilih Nomor Transaksi..</option>
                                        @foreach ($pnypenyusutan as $p)
                                            <option value="{{ $p->id_transaksi }}">{{ $p->kode }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_penyusutan_penyesuaian')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-outline-info me-1" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseDetailPenyesuaianPenyusutan" aria-expanded="false"
                                        aria-controls="collapseDetailPenyesuaianPenyusutan"><i class='bx bx-show'></i>
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="collapse" id="collapseDetailPenyesuaianPenyusutan">
                                <div class="d-flex p-3 border">
                                    <span>
                                        <div class="detailPenyusutan"></div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="form-label text-info"><b>Seleksi Inventaris</b></label>
                            <select id="select2Multiple" name="inventaris[]"
                                class="select2 form-select @error('inventaris') is-invalid @enderror" multiple
                                data-placeholder="Pilih Inventaris..." data-style="btn-outline-secondary"
                                data-allow-clear="true">
                                @foreach ($unit as $u)
                                    <optgroup label="{{ $u->unit->nama }}">
                                        @foreach ($barang as $item)
                                            @if ($u->id_unit == $item->id_unit)
                                                <option value="{{ $item->id_barang }}">{{ $item->nama_barang }}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('inventaris')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route($route) }}" type="button" class="btn btn-outline-secondary">Keluar</a>
                <button type="submit" class="btn btn-primary">Selanjutnya</button>
            </div>
        </div>
    </div>
</form>
