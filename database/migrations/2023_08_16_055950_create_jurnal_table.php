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
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id('id_jurnal');
            $table->unsignedBigInteger('id_coa');
            $table->foreign('id_coa')->references('id_coa')
                ->on('coa')->onDelete('cascade');
            $table->unsignedBigInteger('id_transaksi');
            $table->foreign('id_transaksi')->references('id_transaksi')
                ->on('transaksi')->onDelete('cascade');
            $table->enum('posisi_dr_cr', ['debet', 'kredit']);
            $table->unsignedBigInteger('nominal')->nullable()->default(0);
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
        Schema::dropIfExists('jurnal');
    }
};
