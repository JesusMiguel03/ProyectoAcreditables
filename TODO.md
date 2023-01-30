## **Pendiente**

-   [PeriodoController, PreguntaFrecuenteController, NoticiaController, HorarioController] no tiene control de duplicados.
-   Arreglar vista de listado de estudiantes (PDF).
-   Falta validar que el codigo de pnf sea unico.
-   Validar automaticamente si inscribe el coordinador.
-   Cambiar la vista de horario por un drag n' drop table.
-   Crear controlador y rutas para gráficos y estadísticas.
-   Validar exactamente los cupos disponibles.
-   Seleccionar periodo actual.
-   Crear un componente para los alerts
-   Usar trayecto en vez de numeros en registro de materias.
-   Añadir relaciones en trayecto y pnf.

## **Nota**

-   __(/profesores)__ Si se hace clic 2 veces al registrar un profesor da error.
-   __(/profesores)__ Al ir hacia atras despues del error no muestra "Seleccione un usuario...".

## **Corregir**

-   _(ModalRegistrarUsuario)_ Acepta números en nombre y apellido.
-   _(/profesores)_ Campo de contraseña y confirmar. Cambiar la condicion de text-success (se coloca si es > 8 caracteres en vez de hacerlo si es = 8)_.
-   _(/profesores)_ (Registrar profesor). El numero de telefono no muestra el mensaje correctamente, actua como si fuera un campo number (mostrando si el valor supera el maxlength).
-   _(/profesores)_ Los campos de direccion aceptan números.
-   _(/profesores)_ Area de conocimiento no carga en editar.
-   _(/materias)_ Debe mostrar la tabla solo cuando el carrusel tenga +10 materias (estudiante).
-   _(/materias)_ El botón de inscribir está activo a pesar de no haber estudiantes.
-   _(mensajeMostrarLimite.js)_ Campo numero se pone en rojo indiferente de la condición.
-   _(/periodoso)_ Si hay 2 periodos con las mismas fechas pero diferentes fases no selecciona la mayor.
-   _[/conocimientos, /noticias, /pnf]_ Acepta solo números para ambos campos.

## **Sugerencias**

-   _(/materias)_ Añadir ... a la descripción en la tabla si el texto es muy largo (Coord).

## **Ideas**

-   Sistema de puntuación (likes y dislikes) para [Preguntas, noticias].
-   Ver noticias.
-   Reemplazar acciones en cada fila por una barra de opciones general.
-   Agrupar campos en el PDF de listado.
    1.  Nombre y apellido = Nombre.
    2.  PNF y trayecto = Académico.

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
