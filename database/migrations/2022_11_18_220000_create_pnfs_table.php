<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePnfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pnfs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_pnf', config('variables.pnfs.nombre'))->unique();
            $table->string('cod_pnf', config('variables.pnfs.codigo'))->unique()->nullable();
            $table->integer('trayectos');
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
        Schema::dropIfExists('pnfs');
    }
}
