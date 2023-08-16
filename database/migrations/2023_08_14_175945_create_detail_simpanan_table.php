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
        Schema::create('detail_simpanan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_main');
            $table->foreign('id_main')->references('id_main')
                ->on('main_simpanan')->onDelete('cascade');
            $table->unsignedBigInteger('id_simpanan')->nullable();
            $table->foreign('id_simpanan')->references('id_simpanan')
                ->on('simpanan')->onDelete('cascade');
            $table->float('jumlah', 11, 2);
            $table->float('bunga', 11, 2)->nullable();
            $table->float('ppn', 11, 2)->nullable();
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
        Schema::dropIfExists('detail_simpanan');
    }
};
