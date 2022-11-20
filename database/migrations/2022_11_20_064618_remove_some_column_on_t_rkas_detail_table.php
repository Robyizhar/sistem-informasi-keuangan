<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSomeColumnOnTRkasDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_rkas_detail', function (Blueprint $table) {
            $table->dropColumn('volume');
            $table->dropColumn('unit');
            $table->dropColumn('unit_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_rkas_detail', function (Blueprint $table) {
            $table->string('volume');
            $table->integer('unit');
            $table->decimal('unit_price', 20, 2);
        });
    }
}
