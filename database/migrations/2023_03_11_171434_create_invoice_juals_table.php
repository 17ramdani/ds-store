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
        Schema::create('invoice_juals', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice');
            $table->integer('penjualan_id');
            $table->integer('total');
            $table->integer('total_ppn');
            $table->integer('dp');
            $table->integer('diskon');
            $table->integer('grand_total');
            $table->timestamps();
            $table->integer('created_by')->default('0');
            $table->integer('updated_by')->default('0');
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
        Schema::dropIfExists('invoice_juals');
    }
};
