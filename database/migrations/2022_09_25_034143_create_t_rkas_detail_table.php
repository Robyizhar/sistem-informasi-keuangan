<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRkasDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_rkas_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('rkas_id');
            $table->string('sub_golongan_rkas_name');
            $table->integer('sub_golongan_rkas_id');
            $table->string('description');
            $table->string('volume');
            $table->integer('unit');
            $table->decimal('unit_price', 20, 2);
            $table->decimal('amount_total', 20, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->smallInteger('created_by')->nullable(true);
            $table->smallInteger('updated_by')->nullable(true);
            $table->smallInteger('deleted_by')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_rkas_detail');
    }
}
