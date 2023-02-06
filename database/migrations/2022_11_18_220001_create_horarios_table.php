<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('materia_id');
            // $table->foreign('materia_id')->references('id')->on('materias')->onUpdate('cascade')->onDelete('cascade');
            $table->char('espacio', config('variables.horarios.espacio'));
            $table->tinyInteger('edificio')->nullable();
            $table->tinyInteger('dia');
            $table->timestamp('hora');
            $table->softDeletes();
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
        Schema::dropIfExists('horarios');
    }
}
