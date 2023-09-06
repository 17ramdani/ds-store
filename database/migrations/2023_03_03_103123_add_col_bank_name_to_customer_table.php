<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer', function (Blueprint $table) {
            $table->string('bank_name_1', 255)->nullable();
            $table->string('bank_account_1', 255)->nullable();
            $table->string('bank_account_owner_1', 255)->nullable();
            $table->string('bank_name_2', 255)->nullable();
            $table->string('bank_account_2', 255)->nullable();
            $table->string('bank_account_owner_2', 255)->nullable();
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
            //
        });
    }
};
