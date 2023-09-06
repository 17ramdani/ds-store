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
        Schema::create('customer_contact', function (Blueprint $table) {
            $table->id();
            $table->char('nama', 50)->nullable();
            $table->char('jenisid', 50)->nullable();
            $table->char('noid', 50)->nullable();
            $table->char('nohp', 50)->nullable();
            $table->char('email', 50)->nullable();
            $table->integer('agama_id')->default(0);
            $table->date('tgl_lahir')->nullable();
            $table->char('bagian', 50)->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('customer_contact');
    }
};
