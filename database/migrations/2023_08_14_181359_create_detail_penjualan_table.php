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
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_penjualan');
            $table->foreign('id_penjualan')->references('id_penjualan')
                ->on('main_penjualan')->onDelete('cascade');
            $table->enum('jenis_barang', ['grosir', 'eceran']);
            $table->unsignedBigInteger('id_barang')->nullable();
            $table->foreign('id_barang')->references('id_barang')
                ->on('barang')->onDelete('cascade');
            $table->unsignedBigInteger('id_eceran')->nullable();
            $table->foreign('id_eceran')->references('id_eceran')
                ->on('barang_eceran')->onDelete('cascade');
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id_satuan')
                ->on('satuan')->onDelete('cascade');
            $table->float('qty', 11, 2);
            $table->unsignedBigInteger('harga');
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
        Schema::dropIfExists('detail_penjualan');
    }
};
