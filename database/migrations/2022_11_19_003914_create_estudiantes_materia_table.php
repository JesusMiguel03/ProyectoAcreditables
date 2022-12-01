<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudiantesMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes_materias', function (Blueprint $table) {
            $table->id();
            $table->integer('calificacion');
            $table->string('codigo', 20);
            $table->boolean('validacion_estudiante');
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('asistencia_id');
            $table->foreign('materia_id')->references('id')->on('materias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('asistencia_id')->references('id')->on('asistencias')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('estudiantes_materias');
    }
}
