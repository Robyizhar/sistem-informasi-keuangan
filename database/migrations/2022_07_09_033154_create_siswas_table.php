<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_siswa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('nipd')->nullable(true);
            $table->string('nisn')->nullable(true);
            $table->text('address')->nullable(true);
            $table->string('gender');
            $table->string('phone')->nullable(true);
            $table->integer('angkatan_id');
            $table->integer('jurusan_id');
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
        Schema::dropIfExists('siswas');
    }
}
