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
        Schema::create('coa', function (Blueprint $table) {
            $table->id('id_coa');
            $table->string('kode', 20)->unique();
            $table->string('nama', 150);
            $table->enum('kategori', ['Aktiva Lancar', 'Aktiva Tetap', 'Passiva Lancar', 'Modal Sendiri', 'Pendapatan', 'Biaya']);
            $table->string('subkategori')->nullable();
            $table->enum('header', [1, 2, 3, 4, 5]);
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
        Schema::dropIfExists('coa');
    }
};
