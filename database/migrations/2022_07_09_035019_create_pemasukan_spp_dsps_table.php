<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemasukanSppDspsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemasukan_spp_dsps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pembayaran_dsp_id')->nullable(true);
            $table->bigInteger('siswa_id')->nullable(true);
            $table->string('income_source');
            $table->string('income_total');
            $table->timestamps();

            $table->foreign('pembayaran_dsp_id')->references('id')->on('pembayaran_dsps');
            $table->foreign('siswa_id')->references('id')->on('siswas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemasukan_spp_dsps');
    }
}
