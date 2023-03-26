## **Actualización**
[25/03/2023] *Validations*

## **Pendiente**

## **Validaciones del componente**
-   Login:
    ✔  Usuario no registrado.
        ✔  Error de ingreso.
    ✔  Usuario registrado.
    ✔  Correo válido.

-   Register:
    ✔  Nombre válido.
    ✔  Nombre no acepta espacios sin letras después.
    ✔  Apellido válido.
    ✔  Apellido no acepta espacios sin letras después.
    ✔  Correo válido.
    ✔  Correo único.
    ✔  Cédula única.

-   Materias:
    ✔  Perfil académico incompleto.
    ✔  Redirección si no tiene perfil académico.
    ✔  Solo carga la materia inscrita.
    ✔  Comprobante carga.
    ✔  Si se busca un número mayor a la lista de inscripciones devuelve null.
    ✔  Si se cambia de acreditable:
        -   El comprobante se actualiza.
        -   La información del perfil se actualiza.
        -   La acreditable a mostrar se actualiza.
    ✔  Listado de estudiantes pdf carga.
    ✔  Solo muestra información de la materia al profesor si la dicta. 

-   Perfil:
    -   Actualizar información:
        ✔  Nombre validado.
        ✔  Apellido validado.
        ✔  Nacionalidad validada.
        ✔  Cédula validada.
        ✔  Correo validado.

    -   Actualizar seguridad:
        ✔  Contraseña actual validada.
        ✔  Nueva contraseña validada.
        ✔  Confirmar contraseña validada.

-   Principal:
    -   Periodo:
        ✔  Fase validada.
        ✔  Fecha inicio validada.
        ✔  Fecha fin validada.

    -   Registrar/:
        -   Áreas de conocimiento:
            ✔  Nombre validado.
            ✔  Descripción validada.
            ✔  Editar validado.
            ✔  Borrar validado.

        -   Profesores:
            ✔  Registrar usuario validado.
            ✔  Registrar profesor validado.
            ✔  Actualizar profesor validado.
            ✔  Ver perfil profesor validado.
        
        -   Estudiantes:
            ✔  Registrar usuario validado.
            ✔  Actualizar usuario validado.
            ✔  Comprobantes validado.

-   Acreditables:
    -   Gestionar/:
        -   Categorías:
            ✔  Nombre validado.
            ✔  Unico validado.
            ✔  Editar validado.
            ✔  Borrar validado
            ✔  Borrado validado.

        -   Materias:
            ✔  Nombre validado.
            ✔  Cupos validado.
            ✔  Trayecto validado.
            ✔  Descripción validada.
            ✔  Inscribir validado.
            ✔  Ver validado.
            ✔  Listado validado.
            ✔  Notas pdf validado.
            ✔  Borrar validado.
            ✔  Comprobante estudiante validado.
            ✔  Invalidar / validar validado.
            ✔  Asistencia validada.
            ✔  Asignar nota validado.
            ✔  Aprobación validada.
            ✔  Editar validado.

        -   Horarios:
            ✔  Espacio validado.
            ✔  Aula validada.
            ✔  Materia validada.
            ✔  Editar validado.
            ✔  Borrar validado.
            ✔  Horario validado.
            ✔  Vaciar validado.
            ✔  Alert vaciado validado.

        -   Asistencias:
            ✔  Periodo añadido.
            ✔  Guardar asistencia validad.

    -   Gráficos y estadísticas:
        ✔  Gráficos por periodo validado.
        ✔  Estadísticas por periodo y materia validado.

-   Datos académicos:
    -   PNF:
        ✔  Nombre validado.   
        ✔  Código validado.   
        ✔  Trayectos validado.   
        ✔  Editar validado.   
        ✔  Borrar validado.
        ✔  Duplicado validado.
        ✔  Borrado validado.

    -   Trayecto:
        ✔  Número validado.
        ✔  Duplicado validado.
        ✔  Borrado validado.
        ✔  Editar validado.
        ✔  Borrar validado.

-   Información
    -   Noticias:
        ✔  Titulo validado.
        ✔  Descripción validado.
        ✔  Estado validado.
        ✔  Editar validado.
        ✔  Duplicado validado.

    -   Preguntas frecuentes:
        ✔  Pregunta validado.
        ✔  Respuesta validado.
        ✔  Duplicado validado.
        ✔  Borrar validado.

-   Mantenimiento:
    -   Recuperar datos:
        ✔  Recuperar contraseña validado.
        ✔  Cambiar cedula validado.

    -   Base de datos:
        ✔  Respaldo validado.
        ✔  Alert del respaldo validado.
        ✔  Descarga validada.
        ✔  Alert de la descarga validada.
    

## **Pendiente**

## **Changes**


## **Prueba de caja blanca**
# (*Proceso*: Inscripción de Estudiante)
1. El estudiante se registra.
    1.  Registro exitoso.
        1.  Se dirige a /materias
            1.  No tiene perfil academico
                1.  No puede inscribirse.
            2.  Tiene perfil academico
                1.  Busca una acreditable
                    1.  La acreditable no tiene cupos disponibles.
                        1.  No puede inscribirse.
                            1.  Busca otra acreditable
                    2.  La acreditable tiene cupos disponibles.
                        1.  Se inscribe en ella.
                            1.  Va a su perfil o hace clic en el enlace del alert.
                                1.  Descarga su comprobante.
                                    1.  Lleva el comprobante al coordinador
                                        1.  La acreditable no tiene profesor.
                                            1.  El comprobante queda incompleto.
                                        2.  La acreditable tiene profesor.
                                            1.  El comprobante es aprobado.
                                                1.  El coordinador valida al estudiante.
                                                    1.  El estudiante ya puede cursar la acreditable sin problemas.
            3.  No hay materias registradas.
                1.  No puede inscribirse.
    2.  No pudo registrarse.
        1.  Intenta registrarse de nuevo.
            1.  Se registra exitosamente.
                1.  Se dirige a /materias
                    1.  No tiene perfil academico
                        1.  No puede inscribirse.
                    2.  Tiene perfil academico
                        1.  Busca una acreditable
                            1.  La acreditable no tiene cupos disponibles.
                                1.  No puede inscribirse.
                                    1.  Busca otra acreditable
                            2.  La acreditable tiene cupos disponibles.
                                1.  Se inscribe en ella.
                                    1.  Va a su perfil o hace clic en el enlace del alert.
                                        1.  Descarga su comprobante.
                                            1.  Lleva el comprobante al coordinador
                                                1.  La acreditable no tiene profesor.
                                                    1.  El comprobante queda incompleto.
                                                2.  La acreditable tiene profesor.
                                                    1.  El comprobante es aprobado.
                                                        1.  El coordinador valida al estudiante.
                                                            1.  El estudiante ya puede cursar la acreditable sin problemas.
                    3.  No hay materias registradas.
                        1.  No puede inscribirse.
2. El estudiante es registrado por el coordinador
    1.  Asigna el perfil academico.
        1.  Selecciona una materia.
            1.  La materia tiene cupos disponibles.
                1.  Inscribe al estudiante.
            2.  No tiene cupos disponibles.
                1.  No inscribe al estudiante.
                    1.  Busca otra materia para inscribirlo.
    2.  No puede asignar el perfil académico.
        1.  Intenta nuevamente.
        2.  Si no hay pnf.
            1.  Registra un pnf.
                1.  Asigna el perfil académico.
                    1.  No hay materias disponibles.
                        1.  Registra una acreditable.
                            1.  Inscribe al estudiante.
                    2.  Selecciona una materia.
                        1.  No puede inscribir.
                        1.  No tiene cupos disponibles.
                            1.  Busca otra acreditable.
                                1.  Inscribe al estudiante.
                        2.  Tiene cupos disponibles.
                            1.  Inscribe al estudiante.
        3.  Si no hay trayectos.
            1.  Registra un trayecto.
                1.  Asigna el perfil académico.
                        1.  No hay materias disponibles.
                            1.  Registra una acreditable.
                                1.  Inscribe al estudiante.
                        2.  Selecciona una materia.
                            1.  No puede inscribir.
                            1.  No tiene cupos disponibles.
                                1.  Busca otra acreditable.
                                    1.  Inscribe al estudiante.
                            2.  Tiene cupos disponibles.
                                1.  Inscribe al estudiante.

## **Pendiente**
-   Documentación.