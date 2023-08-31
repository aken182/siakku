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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('kode', 20)->unique();
            $table->string('no_induk', 20)->nullable();
            $table->string('nama', 100);
            $table->string('tempat_lahir', 250)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('pekerjaan', 150)->nullable();
            $table->string('tempat_tugas', 150)->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->enum('level', ['Anggota', 'Karyawan'])->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_berhenti')->nullable();
            $table->text('alasan_berhenti')->nullable();
            $table->string('pas_foto', 250)->nullable();
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
        Schema::dropIfExists('anggota');
    }
};
