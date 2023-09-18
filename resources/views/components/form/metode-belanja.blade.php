<div class="k-select-hide">
    <div class="row k-select-hide-main">
        <div class="col mb-3">
            <label class="form-label text-primary pt-3" for="metode_transaksi">Metode Belanja</label>
            <select class="form-select @error('metode_transaksi') is-invalid @enderror" id="metode_transaksi"
                name="metode_transaksi">
                <option value="">Pilih Metode Belanja</option>
                <option id="kas-trigger" value="Kas">Kas</option>
                <option id="bank-trigger" value="Bank">Bank</option>
                <option id="hutang-trigger" value="Hutang">Hutang</option>
            </select>
            @error('metode_transaksi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="k-select-hide-child">
        <div class="col mb-3">
            <label class="form-label text-primary" for="id_kas">Rekening
                Kas</label>
            <select class="form-select @error('id_kas') is-invalid @enderror" id="id_kas" name="id_kas">
                <option value="">Pilih Kode - Nama Akun</option>
                @foreach ($akunKas as $key => $val)
                    <option value="{{ $val['id_coa'] }}">
                        {{ $val['kode'] . ' - ' . $val['nama'] }}
                    </option>
                @endforeach
            </select>
            @error('id_kas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="k-select-hide-child">
        <div class="col mb-3">
            <label class="form-label text-primary" for="id_bank">Rekening
                Bank</label>
            <select class="form-select @error('id_bank') is-invalid @enderror" id="id_bank" name="id_bank">
                <option value="">Pilih Kode - Nama Akun</option>
                @foreach ($akunBank as $key => $val)
                    <option value="{{ $val['id_coa'] }}">
                        {{ $val['kode'] . ' - ' . $val['nama'] }}
                    </option>
                @endforeach
            </select>
            @error('id_bank')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="k-select-hide-child">
        <div class="col mb-3">
            <label class="form-label text-primary" for="id_hutang">Rekening Hutang</label>
            <select class="form-select @error('id_hutang') is-invalid @enderror" id="id_hutang" name="id_hutang">
                <option value="">Pilih Kode - Nama Akun</option>
                @foreach ($akunHutang as $key => $val)
                    <option value="{{ $val['id_coa'] }}">
                        {{ $val['kode'] . ' - ' . $val['nama'] }}
                    </option>
                @endforeach
            </select>
            @error('id_hutang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
