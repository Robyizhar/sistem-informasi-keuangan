<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPemasukanBosIdToGolonganMRkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_golongan_rkas', function (Blueprint $table) {
            $table->integer('pemasukan_bos_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_golongan_rkas', function (Blueprint $table) {
            $table->dropColumn('pemasukan_bos_id');
        });
    }
}
