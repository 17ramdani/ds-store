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
        Schema::create('customer_users', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->default(0);
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('old_password');
            $table->string('remember_token');
            $table->timestamp('email_verified_at')->nullable();
            $table->char('status', 50)->nullable()->default('active');
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
        Schema::dropIfExists('costumer_users');
    }
};
