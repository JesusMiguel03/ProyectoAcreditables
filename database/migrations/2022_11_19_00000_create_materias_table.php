<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nom_materia', 25);
            $table->integer('cupos');
            $table->integer('cupos_disponibles');
            $table->string('desc_materia', 255);
            $table->string('estado_materia', 20);
            $table->string('imagen_materia', 80)->nullable();
            $table->unsignedBigInteger('informacion_id')->nullable();
            $table->foreign('informacion_id')->references('id')->on('informacion_materia')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materias');
    }
}
