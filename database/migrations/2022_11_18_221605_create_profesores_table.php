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
            $table->string('telefono', 11);
            $table->string('titulo', 50);
            $table->string('casa', 10);
            $table->string('calle', 20);
            $table->string('urb', 20);
            $table->string('ciudad', 30);
            $table->string('estado', 16);
            $table->date('fecha_de_nacimiento');
            $table->date('fecha_ingreso_institucion');
            $table->boolean('estado_profesor');
            $table->foreign('usuario_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('profesores');
    }
}
