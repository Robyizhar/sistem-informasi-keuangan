<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaranSppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_spps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('siswa_id');
            $table->integer('kelas_id');
            $table->string('semester');
            $table->string('bulan');
            $table->string('total_payment');
            $table->timestamps();

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
        Schema::dropIfExists('pembayaran_spps');
    }
}
