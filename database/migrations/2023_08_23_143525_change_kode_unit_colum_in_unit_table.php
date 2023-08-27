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
        Schema::table('unit', function (Blueprint $table) {
            $table->dropUnique('unit_kode_unit_unique'); // Menghapus indeks unik sebelumnya
            $table->string('kode_unit', 10)->change(); // Mengubah panjang string menjadi 5
            $table->unique('kode_unit', 'new_unit_kode_unit_unique'); // Menambahkan indeks unik baru
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
