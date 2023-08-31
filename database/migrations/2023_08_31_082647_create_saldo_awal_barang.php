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
        Schema::create('saldo_awal_barang', function (Blueprint $table) {
            $table->id('id_saldo');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->enum('posisi', ['persediaan', 'inventaris']);
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')
                ->on('barang')->onDelete('cascade');
            $table->float('qty', 11, 2);
            $table->double('harga', 11, 2);
            $table->double('nilai_buku', 11, 2)->nullable();
            $table->double('subtotal', 11, 2);
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
        Schema::dropIfExists('saldo_awal_barang');
    }
};
