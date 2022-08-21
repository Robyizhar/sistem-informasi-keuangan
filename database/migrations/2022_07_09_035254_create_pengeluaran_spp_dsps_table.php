<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengeluaranSppDspsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeluaran_spp_dsps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('unit_price', 20, 2);
            $table->decimal('unit_quantity', 20, 2);
            $table->decimal('unit_total_price', 20, 2);
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
        Schema::dropIfExists('pengeluaran_spp_dsps');
    }
}
