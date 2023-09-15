<div class="row mb-3">
    <label class="form-label text-primary">Pilih Pembeli</label>
    <div class="row">
        <div class="col-md-4">
            <div class="form-check mt-3">
                <label class="form-check-label" for="pegawai">
                    Anggota
                </label>
                <input class="form-check-input @error('pembeli') is-invalid @enderror" name="pembeli" type="radio"
                    value="pegawai" />
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-check mt-3">
                <label class="form-check-label" for="non_pegawai">
                    Non Anggota
                </label>
                <input class="form-check-input @error('pembeli') is-invalid @enderror" name="pembeli" type="radio"
                    value="non-pegawai" />
                @error('pembeli')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
</div>
<div class="row mb-3 hide-pegawai">
    <div class="col">
        <label class="text-primary form-label" for="pegawai_id">Anggota</label>
        <select class="form-select choices @error('pegawai_id') is-invalid @enderror" name="pegawai_id">
            <option value="">Pilih nama pembeli</option>
            @forelse ($pegawai as $pg)
                <option value="{{ $pg->id_anggota }}">{{ $pg->nama }}</option>
            @empty
                <option class="text-warning" value="">Anggota tidak ditemukan</option>
            @endforelse
        </select>
        @error('pegawai_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
<div class="row mb-3 hide-nonpegawai">
    <div class="col">
        <label class="text-primary form-label" for="nama_bukan_pegawai">Non
            Anggota</label>
        <input type="text" name="nama_bukan_pegawai"
            class="form-control @error('nama_bukan_pegawai') is-invalid @enderror" placeholder="Masukkan nama pembeli.">
        @error('nama_bukan_pegawai')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
