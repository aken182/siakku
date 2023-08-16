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
        Schema::create('detail_pendapatan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id_satuan')
                ->on('satuan')->onDelete('cascade');
            $table->string('jenis_pendapatan', 250)->nullable();
            $table->string('nama_pendapatan', 250)->nullable();
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
        Schema::dropIfExists('detail_pendapatan');
    }
};
