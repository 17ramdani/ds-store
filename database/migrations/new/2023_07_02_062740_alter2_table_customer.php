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
        Schema::table('customer', function (Blueprint $table) {
            $table->string('gambar_2', 255)->nullable();
            $table->string('gambar_3', 233)->nullable();
            $table->string('file_ktp', 233)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->dropColumn('gambar_2');
            $table->dropColumn('gambar_3');
            $table->dropColumn('file_ktp');
        });
    }
};