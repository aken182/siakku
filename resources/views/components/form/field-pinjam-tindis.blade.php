<div class="row mb-3">
    <div class="col-12 col-md-6">
        <label class="form-label text-primary">Pinjaman Sebelumnya</label>
        <select name="id_pinjaman" id="id-pinjaman"
            class="form-select choices select-pinjaman @error('id_pinjaman') is-invalid @enderror">
            <option value="" selected>Pilih Nomor Transaksi - Nama Anggota - Total Pinjaman
            </option>
            @foreach ($pinjaman as $p)
                <option value="{{ $p->id_pinjaman }}">
                    {{ $p->transaksi->kode . ' - ' . $p->anggota->nama . ' - ' . buatrp($p->total_pinjaman) }}
                </option>
            @endforeach
        </select>
        @error('id_pinjaman')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-3">
    <div class="col-12 col-md-6 detail-pinjaman">
        <input type="hidden" id="route-pinjaman" data-route="{{ route($route) }}" />
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-primary">
                <tr>
                    <td>Nomor Transaksi</td>
                    <td>
                        <div id="kode-pinjaman" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Nama Anggota</td>
                    <td>
                        <div id="nama-anggota" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Peminjaman</td>
                    <td>
                        <div id="tanggal-pinjam" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Saldo Pokok Pinjaman</td>
                    <td>
                        <div id="saldo-pokok" style="text-align: right"></div>
                    </td>
                </tr>
                <tr>
                    <td>Saldo Bunga Pinjaman</td>
                    <td>
                        <div id="saldo-bunga" style="text-align: right"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="row mb-3">
            <div class="col">
                <label for="" class="text-primary">Pinjam Tindis</label>
                <input type="text" name="total_transaksi" placeholder="Masukkan tambahan pinjaman!"
                    class="form-control format-rupiah @error('total_transaksi') is-invalid @enderror"
                    id="total-transaksi">
                @error('total_transaksi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row mb-3 field-saldo-pokok">
            <div class="col">
                <label for="" class="text-primary">Saldo Pokok Pinjaman Sekarang</label>
                <input type="text" name="saldo_pokok"
                    class="form-control format-rupiah @error('saldo_pokok') is-invalid @enderror"
                    id="saldo-pokok-sekarang" readonly>
                @error('saldo_pokok')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row mb-3 field-saldo-bunga">
            <div class="col">
                <label for="" class="text-primary">Saldo Bunga Pinjaman Sekarang</label>
                <input type="text" name="saldo_bunga"
                    class="form-control format-rupiah @error('saldo_bunga') is-invalid @enderror"
                    id="saldo-bunga-sekarang" readonly>
                @error('saldo_bunga')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
