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
        Schema::create('main_pinjaman', function (Blueprint $table) {
            $table->id('id_pinjaman');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->unsignedBigInteger('id_anggota');
            $table->foreign('id_anggota')->references('id_anggota')
                ->on('anggota')->onDelete('cascade');
            $table->unsignedBigInteger('id_pengajuan')->nullable();
            $table->foreign('id_pengajuan')->references('id_pengajuan')
                ->on('pengajuan_pinjaman')->onDelete('cascade');
            $table->float('total_pinjaman', 11, 2);
            $table->float('kapitalisasi', 11, 2)->nullable();
            $table->float('angsuran_pokok', 11, 2)->nullable();
            $table->float('angsuran_bunga', 11, 2)->nullable();
            $table->float('saldo_pokok', 11, 2);
            $table->float('saldo_bunga', 11, 2);
            $table->float('sisa', 11, 2)->nullable();
            $table->enum('status', ['lunas', 'belum lunas']);
            $table->enum('jenis', ['baru', 'masa lalu']);
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
        Schema::dropIfExists('main_pinjaman');
    }
};
