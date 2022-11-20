<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnOnTRkasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_rkas', function (Blueprint $table) {
            $table->string('volume');
            $table->integer('unit');
            $table->decimal('unit_price', 20, 2);
            $table->decimal('amount_total', 20, 2);
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
            $table->dropColumn('volume');
            $table->dropColumn('unit');
            $table->dropColumn('unit_price');
            $table->dropColumn('amount_total');
        });
    }
}
