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
        Schema::create('profil_kpri', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('badan_hukum', 100)->nullable();
            $table->date('tgl_badan_hukum')->nullable();
            $table->string('nmr_pad', 100)->nullable();
            $table->date('tgl_pad')->nullable();
            $table->date('tgl_rat')->nullable();
            $table->text('alamat')->nullable();
            $table->string('keluran', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('kabupaten', 50)->nullable();
            $table->string('provinsi', 50)->nullable();
            $table->string('bentuk_koperasi', 100)->nullable();
            $table->string('jenis', 100)->nullable();
            $table->string('kelompok_koperasi', 100)->nullable();
            $table->string('sektor', 100)->nullable();
            $table->string('nik', 100)->nullable();
            $table->string('status_nik', 100)->nullable();
            $table->string('status_grade', 100)->nullable();
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
        Schema::dropIfExists('profil_kpri');
    }
};
