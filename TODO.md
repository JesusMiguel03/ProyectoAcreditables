## **Pendiente**
-   Documentación.

## **Commit**


## **Notas**

-   Los trayectos no deberían poder editarse/eliminarse para evitar problemas.
-   Los trayectos del _(1-4 o 5)_ no deberían poder editarse/eliminarse para evitar problemas.
-   Si se intenta registrar un modelo que tenga la opcion de borrar con un _unique field_ dara error de registro (ya existente).


## **profesor_conocimiento_backup**
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesorConocimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesor_conocimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conocimiento_id');
            $table->unsignedBigInteger('profesor_id');
            $table->foreign('conocimiento_id')->references('id')->on('conocimientos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('profesor_id')->references('id')->on('profesores')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('profesor_conocimiento');
    }
}
