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
        Schema::create('detail_belanja_operasionallain', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_belanja');
            $table->foreign('id_belanja')->references('id_belanja')
                ->on('main_belanja')->onDelete('cascade');
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id_satuan')
                ->on('satuan')->onDelete('cascade');
            $table->string('jenis');
            $table->string('nama_belanja');
            $table->float('qty', 11, 2);
            $table->float('harga', 11, 2);
            $table->float('subtotal', 11, 2);
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
        Schema::dropIfExists('detail_belanja_operasionallain');
    }
};
