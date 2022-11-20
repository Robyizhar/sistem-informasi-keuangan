<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPemasukanBosDetailIdToTRkasDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_rkas_detail', function (Blueprint $table) {
            $table->integer('pemasukan_bos_detail_id');
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
            $table->dropColumn('pemasukan_bos_detail_id');
        });
    }
}
