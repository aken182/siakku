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
        Schema::create('shu', function (Blueprint $table) {
            $table->id('id_shu');
            $table->string('nama', 100);
            $table->float('persen', 11, 2);
            $table->float('nilai_bagi', 11, 2);
            $table->enum('unit', ['Pertokoan', 'Simpan Pinjam']);
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
        Schema::dropIfExists('shu');
    }
};
