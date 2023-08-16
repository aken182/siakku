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
        Schema::create('detail_pelunasan_pinjaman', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_pinjaman');
            $table->foreign('id_pinjaman')->references('id_pinjaman')
                ->on('main_pinjaman')->onDelete('cascade');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->enum('jenis_angsuran', ['biasa', 'pinjam tindis']);
            $table->integer('angsuran_ke')->nullable();
            $table->float('besar_pinjaman', 11, 2)->nullable();
            $table->float('angsuran_bunga', 11, 2)->nullable();
            $table->float('angsuran_pokok', 11, 2)->nullable();
            $table->float('total_angsuran', 11, 2)->nullable();
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
        Schema::dropIfExists('detail_pelunasan_pinjaman');
    }
};
