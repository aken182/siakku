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
        Schema::create('main_penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->enum('status_pembeli', ['pegawai', 'bukan pegawai']);
            $table->unsignedBigInteger('id_anggota')->nullable();
            $table->foreign('id_anggota')->references('id_anggota')
                ->on('anggota')->onDelete('cascade');
            $table->string('nama_bukan_anggota')->nullable();
            $table->enum('jenis_penjualan', ['kredit', 'debet']);
            $table->enum('status_penjualan', ['belum terbayar', 'belum lunas', 'lunas']);
            $table->unsignedBigInteger('jumlah_penjualan');
            $table->unsignedBigInteger('saldo_piutang')->nullable();
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
        Schema::dropIfExists('main_penjualan');
    }
};
