<div class="row">
    <div class="col mb-3">
        <label for="id_penjualan" class="text-primary">Tagihan</label>
        <select class="form-select choices @error('id_penjualan') is-invalid @enderror" name="id_penjualan"
            id="id_penjualan">
            <option value="" selected>Pilih Tagihan</option>
            @foreach ($tagihan as $t)
                <option value="{{ $t['id_penjualan'] }}">{{ $t['kode'] }}
                    - {{ $t['pembeli'] }}
                </option>
            @endforeach
        </select>
        @error('id_penjualan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-12 mb-3 table-info">
        <table class="table table-condensed text-primary" style="font-width:bold">
            <tbody>
                <tr>
                    <td><small>Nomor Tagihan</small></td>
                    <td><small>: </small><small id="invoiceTagihan"></small></td>
                </tr>
                <tr>
                    <td><small>Tanggal Beli</small></td>
                    <td><small>: </small><small id="tanggal_beli"></small></td>
                </tr>
                <tr>
                    <td><small>Nama Pembeli</small></td>
                    <td><small>: </small><small id="nama_pembeli"></small></td>
                </tr>
                <tr>
                    <td><small>Status Pembeli</small></td>
                    <td><small>: </small><small id="status_pembeli" class="text-capitalize"></small></td>
                </tr>
                <tr>
                    <td><small>Jumlah Pembelian</small></td>
                    <td><small>: </small><small id="jumlah_beli"></small></td>
                </tr>
                <tr>
                    <td><small>Total Tagihan</small></td>
                    <td><small>: </small><small id="total_tagihan"></small></td>
                </tr>
                <tr>
                    <td><small>Status</small></td>
                    <td><small>: </small><small id="status" class="text-capitalize"></small></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
