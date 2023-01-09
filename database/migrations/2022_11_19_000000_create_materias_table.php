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
            $table->unsignedBigInteger('informacion_id')->nullable();
            $table->foreign('informacion_id')->references('id')->on('informacion_materia')->onUpdate('cascade')->onDelete('cascade');
            $table->char('nom_materia', config('variables.materias.nombre'));
            $table->tinyInteger('cupos');
            $table->tinyInteger('cupos_disponibles');
            $table->tinyInteger('num_acreditable');
            $table->char('desc_materia', config('variables.materias.descripcion'));
            $table->char('estado_materia', config('variables.materias.estado'));
            $table->char('imagen_materia', config('variables.materias.imagen'))->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('materias');
    }
}
