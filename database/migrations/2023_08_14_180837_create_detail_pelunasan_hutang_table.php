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
        Schema::create('detail_pelunasan_hutang', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_hutang');
            $table->foreign('id_hutang')->references('id_hutang')
                ->on('detail_hutang')->onDelete('cascade');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->float('jumlah_pelunasan', 11, 2);
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
        Schema::dropIfExists('detail_pelunasan_hutang');
    }
};
