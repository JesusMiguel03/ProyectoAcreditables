<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesorConocimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesor_conocimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conocimiento_id');
            $table->unsignedBigInteger('profesor_id');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onUpdate('cascade')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesor_conocimiento');
    }
}
