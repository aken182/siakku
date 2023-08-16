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
        Schema::create('satuan', function (Blueprint $table) {
            $table->id('id_satuan');
            $table->string('nama_satuan', 100);
            $table->timestamps();
        });

        Schema::create('unit', function (Blueprint $table) {
            $table->id('id_unit');
            $table->string('kode_unit', 5)->unique();
            $table->string('nama', 50);
            $table->enum('unit', ['Pertokoan', 'Simpan Pinjam']);
            $table->timestamps();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id_satuan')
                ->on('satuan')->onDelete('cascade');
            $table->unsignedBigInteger('id_unit');
            $table->foreign('id_unit')->references('id_unit')
                ->on('unit')->onDelete('cascade');
            $table->string('kode_barang')->unique();
            $table->string('jenis_barang', 50);
            $table->string('nama_barang', 150);
            $table->enum('posisi_pi', ['persediaan', 'inventaris'])->nullable();
            $table->date('tgl_beli')->nullable();
            $table->float('harga_barang', 11, 2)->nullable();
            $table->integer('umur_ekonomis')->nullable();
            $table->float('nilai_saat_ini', 11, 2)->nullable();
            $table->float('harga_jual', 11, 2)->nullable();
            $table->float('stok', 11, 2)->nullable();
            $table->enum('status_konversi', ['Y', 'T', 'S'])->default('T');
            $table->timestamps();
        });

        Schema::create('barang_eceran', function (Blueprint $table) {
            $table->id('id_eceran');
            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')->references('id_barang')
                ->on('barang')->onDelete('cascade');
            $table->unsignedBigInteger('id_satuan');
            $table->foreign('id_satuan')->references('id_satuan')
                ->on('satuan')->onDelete('cascade');
            $table->float('standar_nilai', 11, 2);
            $table->float('jumlah_konversi', 11, 2);
            $table->float('stok', 11, 2);
            $table->float('harga_barang', 11, 2)->nullable();
            $table->float('nilai_saat_ini', 11, 2)->nullable();
            $table->float('harga_jual', 11, 2)->nullable();
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
        Schema::dropIfExists('barang_eceran');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('unit');
        Schema::dropIfExists('satuan');
    }
};
