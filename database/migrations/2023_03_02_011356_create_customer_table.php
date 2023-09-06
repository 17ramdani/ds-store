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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_category_id')->nullable();
            $table->string('nama', 100);
            $table->integer('wilayah_id')->default(0);

            $table->string('pob', 255)->nullable();
            $table->date('dob')->nullable();
            $table->string('no_ktp', 255)->nullable();
            $table->string('lama_berusaha', 255)->nullable();
            $table->integer('omset')->nullable();
            $table->string('nama_perusahaan', 255)->nullable();
            $table->string('alamat_perusahaan', 255)->nullable();
            $table->string('tlp_perusahaan', 255)->nullable();
            $table->string('jenis_usaha', 255)->nullable();
            $table->integer('omset_perusahaan')->nullable();
            $table->integer('kebutuhan_nominal')->nullable();
            $table->string('referensi', 255)->nullable();

            $table->string('alamat', 255)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('notlp', 100)->nullable();
            $table->string('nohp', 100)->nullable();
            $table->string('email', 100);
            $table->string('npwp', 100)->nullable();
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
};
