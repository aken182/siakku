<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('kode', 30)->unique();
            $table->string('kode_pny', 30)->nullable();
            $table->string('no_bukti', 30)->nullable();
            $table->enum('tipe', ['baru', 'penyesuaian', 'kadaluwarsa'])->nullable();
            $table->date('tgl_transaksi');
            $table->string('jenis_transaksi', 200);
            $table->string('detail_tabel', 200);
            $table->enum('metode_transaksi', ['Kas', 'Bank', 'Saldo Awal', 'Piutang', 'Hutang', 'Depresiasi']);
            $table->string('nota_transaksi', 250)->nullable();
            $table->unsignedBigInteger('total')->nullable()->default(0);
            $table->text('keterangan')->nullable();
            $table->enum('tpk', ['Larantuka', 'Pasar Baru', 'Waiwerang'])->default('Larantuka');
            $table->enum('unit', ['Pertokoan', 'Simpan Pinjam', 'Gabungan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
