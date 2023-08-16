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
        Schema::create('detail_penyusutan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')
                ->on('barang')->onDelete('cascade');
            $table->unsignedBigInteger('id_eceran')->nullable();
            $table->foreign('id_eceran')->references('id_eceran')
                ->on('barang_eceran')->onDelete('cascade');
            $table->unsignedBigInteger('id_satuan')->nullable();
            $table->foreign('id_satuan')->references('id_satuan')
                ->on('satuan')->onDelete('cascade');
            $table->float('qty', 11, 2);
            $table->unsignedBigInteger('harga_brg_sekarang');
            $table->unsignedBigInteger('harga_penyusutan');
            $table->unsignedBigInteger('subtotal');
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
        Schema::dropIfExists('detail_penyusutan');
    }
};
