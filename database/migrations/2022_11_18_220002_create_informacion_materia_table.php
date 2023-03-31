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
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('profesor_id')->nullable();
            $table->unsignedBigInteger('horario_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')->onUpdate('cascade')->onDelete('cascade');
            $table->string('metodologia', config('variables.informacion_materia.metodologia'));
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
        Schema::dropIfExists('informacion_materia');
    }
}
