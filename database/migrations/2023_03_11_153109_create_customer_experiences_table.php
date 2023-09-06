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
        Schema::create('customer_experiences', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('pesanan_id');
            $table->smallInteger('star')->default('0');
            $table->string('message')->nullable();
            $table->timestamp('date_input');
            $table->timestamps();
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
        Schema::dropIfExists('customer_experiences');
    }
};
