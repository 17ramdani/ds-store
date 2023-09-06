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
        Schema::create('voucher_points', function (Blueprint $table) {
            $table->id();
            $table->integer('merchant_id');
            $table->string('voucher_name');
            $table->integer('amount');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('voucher_points');
    }
};
