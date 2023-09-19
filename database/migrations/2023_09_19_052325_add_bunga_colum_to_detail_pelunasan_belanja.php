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
        Schema::table('detail_pelunasan_belanja', function (Blueprint $table) {
            $table->unsignedBigInteger('bunga')->nullable()->after('jumlah_pelunasan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pelunasan_belanja', function (Blueprint $table) {
            //
        });
    }
};
