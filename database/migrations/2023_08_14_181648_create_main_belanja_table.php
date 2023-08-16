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
        Schema::create('main_belanja', function (Blueprint $table) {
            $table->id('id_belanja');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->unsignedBigInteger('id_penyedia')->nullable();
            $table->foreign('id_penyedia')->references('id_penyedia')
                ->on('penyedia')->onDelete('cascade');
            $table->enum('jenis_belanja', ['kredit', 'debet']);
            $table->enum('status_belanja', ['belum terbayar', 'belum lunas', 'lunas']);
            $table->unsignedBigInteger('jumlah_belanja');
            $table->unsignedBigInteger('saldo_hutang')->nullable();
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
        Schema::dropIfExists('main_belanja');
    }
};
