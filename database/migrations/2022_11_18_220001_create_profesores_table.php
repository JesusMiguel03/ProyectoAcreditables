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
            $table->char('telefono', config('variables.profesores.telefono'))->unique();
            $table->char('casa', config('variables.profesores.casa'));
            $table->char('calle', config('variables.profesores.calle'));
            $table->char('urb', config('variables.profesores.urb'));
            $table->char('ciudad', config('variables.profesores.ciudad'));
            $table->char('estado', config('variables.profesores.estado'));
            $table->date('fecha_de_nacimiento');
            $table->date('fecha_ingreso_institucion');
            $table->boolean('estado_profesor');
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
