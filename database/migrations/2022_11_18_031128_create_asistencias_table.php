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
            $table->boolean('sem1')->nullable();
            $table->boolean('sem2')->nullable();
            $table->boolean('sem3')->nullable();
            $table->boolean('sem4')->nullable();
            $table->boolean('sem5')->nullable();
            $table->boolean('sem6')->nullable();
            $table->boolean('sem7')->nullable();
            $table->boolean('sem8')->nullable();
            $table->boolean('sem9')->nullable();
            $table->boolean('sem10')->nullable();
            $table->boolean('sem11')->nullable();
            $table->boolean('sem12')->nullable();
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
