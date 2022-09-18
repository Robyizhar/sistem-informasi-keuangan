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
        Schema::create('t_pemasukan_spp_dsp', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pembayaran_dsp_id')->nullable(true);
            $table->bigInteger('siswa_id')->nullable(true);
            $table->string('income_source');
            $table->decimal('income_total', 20, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->smallInteger('created_by')->nullable(true);
            $table->smallInteger('updated_by')->nullable(true);
            $table->smallInteger('deleted_by')->nullable(true);

            // $table->foreign('pembayaran_dsp_id')->references('id')->on('t_pembayaran_dsp');
            // $table->foreign('siswa_id')->references('id')->on('m_siswa');
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
