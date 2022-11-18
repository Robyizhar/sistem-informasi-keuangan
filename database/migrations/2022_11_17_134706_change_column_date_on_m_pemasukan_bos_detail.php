<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnDateOnMPemasukanBosDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_pemasukan_bos_detail', function (Blueprint $table) {
            $table->date('start_date')->nullable(true)->change();
            $table->date('end_date')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_pemasukan_bos_detail', function (Blueprint $table) {
            $table->timestamp('start_date')->nullable(true)->change();
            $table->timestamp('end_date')->nullable(true)->change();
        });
    }
}
