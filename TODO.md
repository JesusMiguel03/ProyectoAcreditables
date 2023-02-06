## **Pendiente**

-   _[HorarioController]_ no tiene control de duplicados.
-   Cambiar la vista de horario por un drag n' drop table.
-   Crear controlador y rutas para gráficos y estadísticas.
-   Componetizar los alerts.
-   Íconos de cantidad.
-   Actualizar descripción fisica.
-   Documentación.
-   Paginación.
    -   https://makitweb.com/datatables-ajax-pagination-with-search-and-sort-laravel/
    -   https://packagist.org/packages/singlequote/laravel-datatables
-   QR.
-   _MostrarMensajeAyuda_ Re-hacer.

## **Commit**


## **Nota**

-   __(/profesores)__ Si se hace clic 2 veces al registrar un profesor da error.
-   __(/profesores)__ Al ir hacia atras despues del error no muestra "Seleccione un usuario...".
-   _(/materias)_ Si la materia tiene un estado diferente a activo o inactivo no se cargara.

## **Sugerencias**

-   Mostrar noticia (show).
-   Los trayectos no deberían poder editarse/eliminarse para evitar problemas.

## **Ideas**

-   Sistema de puntuación (likes y dislikes) para [Preguntas, noticias].
-   Opción de ver noticia.
-   Reemplazar acciones en cada fila por una barra de opciones general.

## **Notas**

-   Si se cambia el numero de acreditable, teniendo estudiantes, se deben sacar si su trayecto !== numero.
-   Los trayectos del 1-4_(5)_ no deberían poder editarse/eliminarse para evitar problemas.
-   Si se edita un trayecto y coloca un número previamente registrado pero borrado, dará error de registro (unique field).

## **Estadísticas**

-   Materias
    -   Cantidad.
    -   Popularidad.
    -   Cantidad de estudiantes.
    -   Flujo de estudiantes (estudiantes por semana).
-   Estudiantes
    -   Cantidad.
    -   PNF.
    -   Trayecto.
-   Profesores
    -   Cantidad.
    -   Materias impartidas.
-   Horarios
    -   Espacios.
    -   Horas.
