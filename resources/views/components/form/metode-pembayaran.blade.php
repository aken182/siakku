<div class="k-select-hide">
    <div class="row k-select-hide-main">
        <div class="col mb-3">
            <label class="form-label text-primary pt-3" for="metode_transaksi">Metode Pembayaran</label>
            <select class="form-select @error('metode_transaksi') is-invalid @enderror" id="metode_transaksi"
                name="metode_transaksi">
                <option value="">Pilih Metode</option>
                <option id="kas-trigger" value="Kas">Kas</option>
                <option id="bank-trigger" value="Bank">Bank</option>
                <option id="piutang-trigger" value="Piutang">Piutang</option>
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
            <label class="form-label text-primary" for="id_piutang">Rekening Piutang</label>
            <select class="form-select @error('id_piutang') is-invalid @enderror" id="id_piutang" name="id_piutang">
                <option value="">Pilih Kode - Nama Akun</option>
                @foreach ($akunPiutang as $key => $val)
                    <option value="{{ $val['id_coa'] }}">
                        {{ $val['kode'] . ' - ' . $val['nama'] }}
                    </option>
                @endforeach
            </select>
            @error('id_piutang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>
