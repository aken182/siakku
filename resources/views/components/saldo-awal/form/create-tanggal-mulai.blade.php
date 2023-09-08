<form action="{{ route($store) }}" method="post">
    @csrf
    <div class="col mb-3">
        <div class="row">
            <p class="content-text">
                Masukkan tanggal Anda memulai memproses transaksi menggunakan Siak
                KPRI Usaha Jaya Larantuka.
            </p>
        </div>
    </div>
    <div class="col mb-3">
        <div class="row">
            <div class="col-md-5 col-sm-6 col-lg-5">
                <select id="tanggal_konversi" class="form-select  choices @error('tanggal_konversi') is-invalid @enderror"
                    name="tanggal_konversi" onchange="getTanggalTerakhir()">
                    <option value="" selected>Pilih Tanggal</option>
                    @for ($i = date('Y'); $i >= 2007; $i--)
                        @for ($j = 1; $j <= 12; $j++)
                            <option value="{{ date('Y-m-d', mktime(0, 0, 0, $j, 1, $i)) }}">
                                {{ bulan_indonesia($j) . ' ' . $i }}</option>
                        @endfor
                    @endfor
                </select>
                @error('tanggal_konversi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="col mb-3">
        <div class="row">
            <input type="hidden" class="form-control" name="tanggal_terakhir" id="tanggal_terakhir">
            <p class="content-text">
                Saldo awal akan di set per tanggal <span id="tanggal_terakhir_tampil"></span>.
            </p>
        </div>
    </div>
    <div class="col mb-3">
        <button type="submit" class="btn btn-primary">Simpan</a>
    </div>
</form>
@section('pageScript')
    <script>
        function getTanggalTerakhir() {
            var date = document.getElementById("tanggal_konversi").value;
            var lastDay = new Date(date.substring(0, 4), date.substring(5, 7) - 1, 0);
            document.getElementById("tanggal_terakhir_tampil").innerHTML = lastDay.getDate() + '/' + (lastDay.getMonth() +
                    1) +
                '/' +
                lastDay.getFullYear();
            document.getElementById("tanggal_terakhir").value = lastDay.getDate() + '/' + (lastDay.getMonth() + 1) +
                '/' +
                lastDay.getFullYear();
        }
    </script>
@endsection
