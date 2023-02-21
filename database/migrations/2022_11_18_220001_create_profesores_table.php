<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('conocimiento_id');
            $table->unsignedBigInteger('departamento_id');
            $table->foreign('departamento_id')->references('id')->on('pnfs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos')->onUpdate('cascade')->onDelete('cascade');
            $table->string('telefono', config('variables.profesores.telefono'))->unique();
            $table->string('casa', config('variables.profesores.casa'));
            $table->string('calle', config('variables.profesores.calle'));
            $table->string('urb', config('variables.profesores.urb'));
            $table->string('ciudad', config('variables.profesores.ciudad'));
            $table->string('estado', config('variables.profesores.estado'));
            $table->date('fecha_de_nacimiento');
            $table->date('fecha_ingreso_institucion');
            $table->boolean('activo');
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
        Schema::dropIfExists('profesores');
    }
}
