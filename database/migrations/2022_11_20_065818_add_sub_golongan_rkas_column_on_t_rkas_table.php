<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubGolonganRkasColumnOnTRkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_rkas', function (Blueprint $table) {
            $table->string('sub_golongan_rkas_name');
            $table->integer('sub_golongan_rkas_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_rkas', function (Blueprint $table) {
            $table->dropColumn('sub_golongan_rkas_name');
            $table->dropColumn('sub_golongan_rkas_id');
        });
    }
}
