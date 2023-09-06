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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->char('nomor', 50);
            $table->integer('customer_id');
            $table->integer('sales_man_id');
            $table->integer('customer_service_id');
            $table->date('tanggal_pesanan');
            $table->string('tipe_pesanan', 100)->nullable();
            $table->string('kategori_pesanan', 100)->nullable();
            $table->string('jenis_pesanan', 100)->nullable();
            $table->string('jalur_pesanan', 100)->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->integer('status_pesanan_id')->default(0);
            $table->char('status_kode', 10)->nullable();
            $table->integer('ppn')->nullable()->default(0);
            $table->float('diskon')->nullable()->default(0);
            $table->integer('dp')->nullable()->default(0);
            $table->integer('total')->nullable()->default(0);
            $table->string('ttd')->nullable();
            $table->string('no_invoice')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->string('created_by_host', 200);
            $table->string('created_by_device', 200);
            $table->integer('updated_by')->default(0);
            $table->string('updated_by_host', 200)->nullable();
            $table->string('updated_by_device', 200)->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->integer('approved_by')->default(0);
            $table->string('approved_by_host', 200)->nullable();
            $table->string('approved_by_device', 200)->nullable();
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
        Schema::dropIfExists('pesanan');
    }
};
