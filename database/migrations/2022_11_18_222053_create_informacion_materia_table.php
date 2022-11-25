<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionMateriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_materia', function (Blueprint $table) {
            $table->id();
            $table->string('metodologia_aprendizaje', 16);
            // $table->unsignedBigInteger('horario_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('profesor_id');
            // $table->foreign('horario_id')->references('id')->on('horario')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('informacion_materia');
    }
}
