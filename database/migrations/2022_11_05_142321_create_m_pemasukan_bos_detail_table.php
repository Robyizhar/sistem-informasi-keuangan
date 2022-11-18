<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMPemasukanBosDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_pemasukan_bos_detail', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('received_funds', 20, 2);
            $table->timestamp('start_date', $precision = 0)->nullable(true);
            $table->timestamp('end_date', $precision = 0)->nullable(true);
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
        Schema::dropIfExists('m_pemasukan_bos_detail');
    }
}
