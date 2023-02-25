<h1 align="center">Proyecto de Acreditables</h1>

<p align="center">
    <img src="./public/vendor/img/logo.png" width="120" height="150">
</p>

## 🖥Código
Clone el repositorio en la ubicación que desee.
```
git clone https://github.com/JesusMiguel03/ProyectoAcreditables.git
```
Requiere tener instalado [composer](https://getcomposer.org/download/)
```
composer install
```
En el editor de su preferencia, abra la carpeta clonada y use los siguientes comandos:
```
cp .env.example .env
```
```
php artisan key:generate
```
```
php artisan migrate --seed
```
Para que las imágenes sean accesibles una vez guardadas:
```
php artisan storage:link
```
```
php artisan serve
```
<strong>Para recibir las actualizaciones:</strong>
Dentro de la carpeta donde se encuentra el proyecto
```
git pull
```
```
composer update
```
```
php artisan migrate:fresh --seed
```

## Sobre el proyecto

Componente web diseñado para la gestión administrativa de procesos dentro de la Coordinación de Acreditables. Dispone de las siguientes funciones:

- Inscripción de estudiantes y profesores.
- Gestión de cursos/materias.
- Personalización de perfil, cambio de contraseña y nombre.
- Gráficos, estadísticas y reportes.
- Listados de estudiantes y comprobantes de inscripción en formato PDF.

**Template**
- [Laravel-AdminLTE](https://github.com/jeroennoten/Laravel-AdminLTE).

**Lenguajes**
- HTML5.
- CSS3.
- JavaScript.
- Php.

**Plugins**
- [jQuery](https://jquery.com/download/) ~ Javascript shorthands and optimizations.
- [SweetAlert2](https://sweetalert2.github.io) ~ Custom alerts.
- [DataTables](https://datatables.net) ~ Custom tables.
- [Slick](http://kenwheeler.github.io/slick/) ~ Carousel.
- [Spatie](https://spatie.be/docs/laravel-permission/v5/introduction) ~ Roles and permissions.
- [Laravel-Backup](https://spatie.be/docs/laravel-backup/v6/introduction) ~ Backup option.
- [Tempus Dominus](https://getdatepicker.com/5-4/) ~ Date inputs (Requires Moment JS).
- [Moment](https://momentjs.com/) ~ Time format.
- [Select2](https://select2.org/) ~ Select multiple.
- [ChartJS](https://www.chartjs.org/) ~ Graphics and statistics.
- [icheck-bootstrap](https://bantikyan.github.io/icheck-bootstrap/) ~ Custom checkbox.
- [DOMPDF](https://github.com/barryvdh/laravel-dompdf) ~ Export to PDF option.

**Frameworks**
- [Bootstrap (Frontend)](https://getbootstrap.com/docs/4.6/getting-started/introduction/).
- [Laravel (Backend)](https://laravel.com/docs/8.x/installation).


## Flujo del componente:
Para ingresar como coordinador (super usuario) use las siguientes credenciales
```
u6@email.com
```
```
password
```
Una vez dentro, diríjase a su perfil (ícono de engrenaje al lado de su imagen de perfil) y cambie su contraseña, nombre y/o correo para mayor seguridad una vez se encuentre operativo.
Ya modificado el perfil por temas de seguridad, siga estos pasos para registrar el contenido necesario para iniciar las inscripciones:
1. Primeramente register el periodo en PRINCIPAL / Periodo, pues muchas acciones u operaciones dependen de este y muy importante manternerlo actualizado. Cuando se registre un nuevo periodo el componente seleccionará el último registrado siempre que sea mayor al anterior (fase, año de incio y año de fin).
2. Comience con registrar algunas áreas de conocimiento, ubicado en el menú lateral PRINCIPAL / Registrar / Áreas de Conocimiento, pues estas son necesarias para registrar un perfil de profesor, ya que, representan el curriculum de este.
3. Registre a uno o más profesores en el apartado PRINCIPAL / Registrar / Profesores, registre un usuario primero (este tendrá el rol de profesor una vez creado) y posteriormente el perfil académico o de profesor.
4. En ACREDITABLES / Gestionar / Categorías, registre algunas, además del nombre de la acreditable o materia la categoría ayuda al estudiante a saber de que tratará el curso.
5. Para registrar una materia vaya al menú lateral ACREDITABLES / Gestionar / Materias y registre una, posteriormente edite esta materia para asignarle un profesor u otros aspectos que mas adelante registrará.
6. El apartado DATOS ACADEMICOS contiene los PNF's y Trayectos registrados en la Universidad, en caso de algún cambio modifique el correspondiente para mantenerlo actualizado.
7. En INFORMACION / Noticias, puede registrar noticias y gestionarlas, si desea que se muestren o no bastará con editar una y en el campo 'Mostrar' colocar 'No'. En la pestaña de Preguntas es una ayuda para que los estudiantes y profesores puedan manejarse mejor en el componente o responder dudas frecuentes.
8. En SOPORTE se encuentran aspectos importantes, empezando por Recuperar elemento por si algún elemento fue borrado accidentalmente o es necesario, siempre estará disponible su recuperación. Recuperar datos, si un estudiante o profesor tuviera problemas con su contraseña u otro dato personal desde esta vista se puede arreglar. Por último Base de datos, aquí podrá realizar copias de seguridad de la base de datos y los registros de la fecha, descargarlos y posteriormente importarlos en caso de algún fallo o problema.
9. En ACREDITABLES / Gestionar / Horarios, puede registrar los espacios a ocupar por cada acreditable e imprimir la tabla en caso de querer mostrarse todos los horarios, cuando una materia ya no se vea en alguna hora, podrá cambiarlo arrastrándola a la hora nueva; si lo que se desea en borrar todas las horas o vaciar el horario tiene un botón para esta acción.
10. Cuando los estudiantes se registren deberá ingresar al apartado PRINCIPAL / Registrar / Estudiantes e individualmente registrar el perfil académico (trayecto y pnf), esto en vista de que no hay acceso a la API de DACE para consultar los datos del estudiante. En caso de que un estudiante pase de trayecto debe realizar el mismo procedimiento, buscar al estudiante y actualizar el trayecto o PNF si se cambia.
11. Ya cuando se encuentren inscritos los estudiantes tiene dos vías ACREDITABLES / Gestionar / Asistencias para ver todos los estudiantes inscritos y sus respectivas asistencias o ACREDITABLES / Gestionar / Materias / Ver materia / Estudiante - Asistencia. El estudiante necesita de un 75% de asistencia como uno de los requisitos para aprobar, en esta misma ruta puede asignar la nota del estudiante cuando haya culminado la acreditable.
12. Cada vez que una materia cambie su estado, sea acreditable activa, inactiva, descontinuada, en progreso o finalizada deberá dirigirse a ACREDITABLES / Gestionar / Materias / Editar y cambiar el estado, ya que de esto dependen algunas acciones como poder inscribirse o no.
13. Por último, Gráficos y estadísticas, aquí podrá ver reflejado toda la información de un periodo o periodo y materia concreta.
14. La asistencia y nota son obligación del profesor, pero en caso de que no pueda, el coordinador tiene acceso también.
15. Cuando se registre un nuevo periodo las materias se vaciarán pero no se perderán los registros anteriores, solo se mantendrán ocultos.
