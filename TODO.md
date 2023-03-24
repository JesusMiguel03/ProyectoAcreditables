## **Actualización**
[24/03/2023] *Macro Validations*

## **Trabajando en**
-   Tests.
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