<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConocimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conocimientos', function (Blueprint $table) {
            $table->id();
            $table->char('nom_conocimiento', config('variables.conocimiento.nombre'))->unique();
            $table->char('desc_conocimiento', config('variables.conocimiento.descripcion'));
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
        Schema::dropIfExists('conocimientos');
    }
}
