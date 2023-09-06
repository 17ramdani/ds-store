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
        Schema::table('tipe_kain', function (Blueprint $table) {
            $table->integer('harga_roll')->nullable()->default(0)->after('harga_final');
            $table->integer('harga_ecer')->nullable()->default(0)->after('harga_roll');
        });

        Schema::table('jenis_kain', function (Blueprint $table) {
            $table->string('katalog')->nullable()->default(null)->after('keterangan');
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
