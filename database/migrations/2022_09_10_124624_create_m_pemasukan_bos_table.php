<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPemasukanBosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pemasukan_bos', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->string('type');
            $table->enum('step', ['1', '2', '3']);
            $table->decimal('received_funds', 20, 2);
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
        Schema::dropIfExists('m_pemasukan_bos');
    }
}
