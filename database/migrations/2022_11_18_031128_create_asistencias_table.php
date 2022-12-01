<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->boolean('Sem1')->nullable();
            $table->boolean('Sem2')->nullable();
            $table->boolean('Sem3')->nullable();
            $table->boolean('Sem4')->nullable();
            $table->boolean('Sem5')->nullable();
            $table->boolean('Sem6')->nullable();
            $table->boolean('Sem7')->nullable();
            $table->boolean('Sem8')->nullable();
            $table->boolean('Sem9')->nullable();
            $table->boolean('Sem10')->nullable();
            $table->boolean('Sem11')->nullable();
            $table->boolean('Sem12')->nullable();
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
        Schema::dropIfExists('asistencias');
    }
}
