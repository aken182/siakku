<div class="collapse" id="collapseExample">
    <h6 class="text-center text-dark mb-2">Panduan Menginput Transaksi</h6>
    <h4 class="text-info mt-2 text-center"><b>{{ $title }}</b></h4>
    <div class="d-grid p-3 border">
        <ol class="text-dark">
            <li>Pilih jenis penjualan pada field "<b>Jenis Penjualan</b>". Terdapat
                2 (<i>dua</i>) jenis pilihan pada field tersebut. Pilih salah satu dari
                kedua jenis tersebut. Jika anda ingin melakukan transaksi baru maka pilih
                "<b>Penjualan Baru</b>". Bila anda ingin merubah transaksi yang sudah ada
                dan yang didalamnya terdapat kesalahan input atau kesalahan lainnya maka pilih
                "<b>Penyesuaian</b>".
            </li>
            <li>Jika anda memilih <i>"Penyesuaian"</i> maka akan muncul field "<b>Penjualan
                    yang Disesuaiakan</b>". Field tersebut tidak akan muncul jika anda memilih
                <i>"Penjualan Baru"</i>. Anda dapat memilih Nomor Transaksi dari penjualan
                yang ingin anda sesuaikan pada field tersebut. Anda juga dapat mencari Nomor
                Transaksi penjualan yang ingin disesuaikan dengan mengetiknya pada field
                "<b><i>Search</i></b>" dalam field tersebut.
            </li>
            <li>Disebelah kanan field <i>"Penjualan yang Disesuaiakan"</i> terdapat tombol
                "<b>Lihat Detail</b>" untuk melihat detail dari Nomor Transaksi Penyesuaian
                yang telah dipilih.
            </li>
            <li>Pilih tanggal transaksi penjualan pada field "<b>Tanggal Transaksi</b>".
            </li>
            <li>Nomor transaksi akan digenerate secara otomatis. Anda juga dapat merubahnya
                pada field "<b>Nomor</b>", dengan format <i>"Kode Unik - Nomor Transaksi"</i>.
                Disarankan biarkan "<i>default</i>" jika tidak dibutuhkan perubahan.
            </li>
            <li>Pilih penerimaan penjualan pada field "<b>Dibayar Ke</b>". Terdapat
                2 (<i>dua</i>) jenis pilihan pada field tersebut. Pilih salah satu dari
                kedua jenis tersebut.
            </li>
            <li>Jika anda memilih "<i>Kas</i>" maka akan muncul field "<b>Rekening Kas</b>".
                Dalam field tersebut terdapat beberapa rekening Kas. Pilih salah satu
                rekening kas yang menjadi "<i>Post</i>" dari penerimaan Penjualan yang anda
                lakukan.
            </li>
            <li>Jika anda memilih "<i>Bank</i>" maka akan muncul field "<b>Rekening Bank</b>".
                Dalam field tersebut terdapat beberapa rekening Bank. Pilih salah satu rekening
                Bank yang menjadi "<i>Post</i>" dari penerimaan Penjualan yang anda lakukan.
            </li>
            <li>Pilih sumber pendapatan {{ $title }} pada field "<b>Sumber
                    Pendapatan</b>". Terdapat beberapa pilihan akun pada field tersebut.
                Pilih salah satu akun yang sesuai dengan sumber pendapatan {{ $title }}.
            </li>
            <li>Masukkan File nota penjualan pada field "<b>Nota Transaksi</b>" dengan cara
                mengklik pada field tersebut kemudian pilih file yang mau anda <i>upload</i>
                pada direktori anda. Jenis file nota transaksi harus <b>jpeg/png/jpg/gif/svg</b>
                dengan ukuran file nota transaksi tidak boleh lebih besar dari <b>1048 kb</b>.
            </li>
            <li>Masukkan keterangan transaksi pada field "<b>Keterangan</b>". Keterangan
                yang dimasukan harus "<b>Jelas</b>".</li>
            <li>Setelah selesai mengisi keterangan langkah selanjutnya adalah mengisi
                "<b>Detail Transaksi</b>". Terdapat beberapa field dari Detail Transaksi yaitu
                <b>Nama</b>, <b>Jenis</b>, <b>QTY (<i>Kuantitas</i>)</b>, <b>Satuan</b>,
                <b>Harga Satuan</b>, <b>Total</b>, <b>Aksi</b> yang berisi tombol <b>Hapus
                    Baris</b>, dan tombol <b>Tambah Baris</b>.
            </li>
            <li>Masukkan keterangan detail penjualan pada field "<i>Nama</i>".</li>
            <li>Setelah itu pilih jenis penjualan pada field "<i>Jenis</i>". Terdapat
                2 (<i>dua</i>) jenis pilihan pada field tersebut yaitu "<i>Hasil</i>" dan
                "<i>Jasa</i>". Pilih salah satu dari kedua jenis tersebut sesuai dengan nama
                penjualannya.
            </li>
            <li>Setelah memilih jenis, masukkan jumlah atau kuantitas penjualan pada
                field "<i>QTY</i>".</li>
            <li>Pilih satuan per kuantitas pada field "<i>Satuan</i>".</li>
            <li>Masukkan harga satuan penjualan pada field "<i>Harga Satuan</i>".</li>
            <li>Setelah memasukkan harga satuan, total transaksi akan muncul secara otomatis
                pada field "<i>Total</i>". Begitupun juga <b>Total Penjualan</b> akan muncul
                secara otomatis.</li>
            <li>Jika anda ingin menghapus baris dari detail transaksi anda dapat menekan
                tombol "<i>Hapus Baris</i>" yang terdapat pada field "<i>Aksi</i>".Jika inputan
                detail transaksi anda lebih dari satu baris, anda dapat menekan tombol
                "<i>Tambah Baris</i>" yang terletak dibawah baris Detail Transaksi. Anda
                dapat mengisi baris detail transaksi yang baru ditambahkan sesuai dengan cara
                pengisian detail transaksi yang sudah dijelaskan sebelumnya.</li>
            <li>Setelah selesai mengisi klik tombol "<b>Simpan</b>" untuk menyimpan Transaksi
                {{ $title }} pada sistem. Apabila muncul pesan error berarti anda
                belum mengisi form dengan benar. Anda perlu mengisi ulang form sesuai dengan
                panduan yang diberikan. Apabila muncul pesan sukses berarti data telah berhasil
                disimpan ke dalam sistem.</li>
        </ol>
        <small class="text-dark mt-2">Terimakasih telah membaca panduan <b>SIAK
                KPRI USAHA JAYA</b>.🙏🙏</small>
    </div>
</div>
