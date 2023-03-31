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
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->string('espacio', config('variables.horarios.espacio'));
            $table->tinyInteger('aula')->nullable();
            $table->tinyInteger('dia');
            $table->timestamp('hora');
            $table->string('campo', 4);
            $table->foreign('periodo_id')->references('id')->on('periodos')->onUpdate('cascade')->onDelete('cascade');
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
