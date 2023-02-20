## **Pendiente**

-   El comprobante usa el ID del estudiante en vez de estudiante_materia.
    
-   _(/materias)_ Si la materia tiene un estado diferente a activo o inactivo no se cargara.

-   Cada estudiante puede tener varios registros.

-   Actualizar descripción fisica.
-   Documentación.

## **Posible**

-   Paginación.
    -   https://dev.to/dalelantowork/laravel-8-datatables-server-side-rendering-5-easy-steps-5464
-   _MostrarMensajeAyuda_ Re-hacer.

## **Commit**


## **Notas**

-   Los trayectos no deberían poder editarse/eliminarse para evitar problemas.
-   Si se cambia el numero de acreditable, teniendo estudiantes, se deben sacar si su trayecto !== numero.
-   Los trayectos del _(1-4 o 5)_ no deberían poder editarse/eliminarse para evitar problemas.
-   Si se intenta registrar un modelo que tenga la opcion de borrar con un _unique field_ dara error de registro (ya existente).
