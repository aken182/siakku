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
        Schema::create('pengajuan_pinjaman', function (Blueprint $table) {
            $table->id('id_pengajuan');
            $table->string('kode', 20)->nullable();
            $table->unsignedBigInteger('id_anggota');
            $table->foreign('id_anggota')->references('id_anggota')
                ->on('anggota')->onDelete('cascade');
            $table->float('gaji_perbulan', 11, 2)->nullable();
            $table->float('potongan_perbulan', 11, 2)->nullable();
            $table->float('cicilan_perbulan', 11, 2)->nullable();
            $table->float('biaya_perbulan', 11, 2)->nullable();
            $table->float('sisa_penghasilan', 11, 2)->nullable();
            $table->float('perkiraan', 11, 2)->nullable();
            $table->float('kemampuan_bayar', 11, 2)->nullable();
            $table->float('jumlah_pinjaman', 11, 2)->nullable();
            $table->float('jangka_waktu', 11, 2)->nullable();
            $table->float('bunga', 11, 2)->nullable();
            $table->float('asuransi', 11, 2)->nullable();
            $table->float('kapitalisasi', 11, 2)->nullable();
            $table->float('biaya_administrasi', 11, 2)->nullable();
            $table->float('angsuran_bunga', 11, 2)->nullable();
            $table->float('angsuran_pokok', 11, 2)->nullable();
            $table->float('total_angsuran', 11, 2)->nullable();
            $table->float('total_pinjaman', 11, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['acc', 'belum acc'])->nullable();
            $table->date('tgl_acc')->nullable();
            $table->enum('status_pencairan', ['sudah cair', 'belum cair', 'konfirmasi'])->nullable();
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
        Schema::dropIfExists('pengajuan_pinjaman');
    }
};
