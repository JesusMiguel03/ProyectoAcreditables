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
- Historial de acciones (Bitácora).

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
El manejo de este se lleva a cabo por el usuario de rol Coordinador (superusuario), las credenciales para acceder desde este perfil son:
```
u6@email.com
```
```
password
```
Dentro del componente el primer paso para mantener la integridad y seguridad de este es cambiar las credenciales previamente nombradas, para ello vaya al ícono que se encuentra al lado derecho de su nombre y rol, dentro de esta vista podrá cambiar la contraseña y correo (objetivo principalmente) y posteriormente otros datos como nombre, apellido e ícono de perfil.

El procedimiento de registrar todos los elementos necesarios para la apertura de las acreditables se lista de la siguiente forma:
[Nota: PRINCIPAL / Periodo u otros apartados hacen referencia al menú lateral izquierdo.]

1. [Obligatorio] Primeramente registre el periodo en (PRINCIPAL / Periodo). El componente seleccionará el último periodo registrado siempre y cuando este sea considerado el actual (Busca la última fase, año de inicio y año de fin). PD: Una parte importante de acciones internas requiren de la existencia de un periodo o en el caso de gráficos y estadísticas, la ausencia de este podría dar resultados incorrectos o no deseados.

2. [Opcional / Recomendado] Registre áreas de conocimiento en (PRINCIPAL / Registrar / Áreas de Conocimiento), estas son necesarias para completar un perfil de profesor, puesto que, representan la especialidad y capacidad de este para impartir una acreditable.

3. [Obligatorio] A continuación registre algunos profesores en (PRINCIPAL / Registrar / Profesores), primero se registra como usuario (con rol de profesor) y posteriormente se registra su perfil académico o profesional.

4. [Opcional / Recomendado] Continuando con algunos campos necesarios para registrar una materia en su totalidad tenemos las categorías, vaya a (ACREDITABLES / Gestionar / Categorías) para agregar algunas, estas servirán como un filtro para los estudiantes al momento de buscar una acreditable o como información complementaria de qué tratará la materia.

5. [Obligatorio] El registro de una materia se lleva a cabo en (ACREDITABLES / Gestionar / Materias), una vez se registre se recomienda editar y completar los campos adicionales, pues estos o bien brindan información y/o hacen más descriptiva la materia se requieren en algunas salidas, nómbrese el PDF de Inscripción como uno de ellos. Si bien es altamente recomendado realizar este procedimiento completo, tiene la opción a completar esta información posteriormente.

6. [Opcional] Dentro del apartado (DATOS ACADÉMICOS) se encuentran los PNF y Trayectos registrados en la universidad, estos se recomiendan mantener actualizados, ya que el perfil académico de los estudiantes depende de ello así como el número de acreditable (trayecto).

7. [Opcional / Recomendado] (INFORMACIÓN / Noticias) registre noticias que afecten a las acreditables para mantener informado a los estudiantes u otro tipo de noticias que puedan ser de interés para ellos. Estas noticias se muestran en formato carrusel con un límite de hasta 10 pequeñas cartas, las noticias que se cargarán serán las primeras 10 que cuenten con el campo 'Mostrar' en 'Si', este número puede ser editado en cualquier momento accediendo al archivo 'ArchivoRaíz/config/variables.php' cambie el número de la variable 'carrusel' por la cantidad que desee mostrar. PD: Esta variable también afecta al carrusel de materias.

8. [Opcional / Recomendado] En (SOPORTE) se encuentran apartados de ayuda que mantienen funcional al componente (SOPORTE / Recuperar elemento) en caso de haber borrado por error algún registro y que sea necesario, (SOPORTE / Recuperar datos) esta vista provee métodos de ayuda en caso de que un usuario tenga problemas con sus datos (cédula o contraseña), esto pues, ya que no se tiene acceso a un servicio SMTP para añadir la opción de recuperar vía correo. Por último (SOPORTE / Base de datos) dentro de este podrá realizar las copias de seguridad de la base de datos, se listará cada una de estas copias y podrá descargarla, extraer el archivo .sql y a continuación importar este archivo en caso de algún fallo con los registros. PD: Estos respaldos son totalmente independientes y se encuentran en una carpeta aparte ('ArhivoRaíz/storage/app/Laravel').

9. [Opcional / Recomendado] (ACREDITABLES / Gestionar / Horarios) Puede registrar de manera dinámica un horario general que contenga todas las acreditables, la hora en que se imparten y el espacio donde se realizarán, esta tabla también da la opción de arrastrar la etiqueta de la acreditable a otro bloque de hora en caso de ser necesario. Para vaciar este horario tiene un botón donde se ocultan todas las acreditables o si solo desea remover una hora puede acceder a ella y borrarla.

10. [Obligatorio] Posterior al registro de uno o varios estudiantes debe acceder a (PRINCIPAL / Registrar / Estudiantes) e individualmente completar el perfil académico de cada uno (trayecto y pnf). Este proceso tedioso es resultado de no existir acceso a la API de DACE para consultar esta información. Al momento en que un estudiante pase de trayecto (deberá validar este proceso) tendrá que actualizar su trayecto manualmente o PNF en caso de algún cambio.

11. [Obligatorio] Una vez inscritos puede acceder a la asistencia de dos maneras (ACREDITABLES / Gestionar / Asistencias) para visualizar todas e ir individualmente colocándola o bien (ACREDITABLES / Gestionar / Materias) Ver materia / Estudiante - Asistencia y asignarla. El estudiante necesita de un 75% de asistencia como uno de los requisitos para aprobar una acreditable.

12. [Obligatorio] Cuando el estado de una materia cambie (Activo, En progreso, Finalizado, Descontinuado, Inactivo) deberá reflejarlo en la materia correspondiente, ya que las acciones que puedan realizar los estudiantes dependen de este estado (Inscribirse o no).

13. [Opcional] (PRINCIPAL / Gráficos y Estadísticas) aquí se refleja toda la información recopilable de los registros, tiene la opción de listar todo por periodo o si lo desea por periodo y materia.

14. [Obligatorio] (ACREDITABLES / Gestionar / Materias) Ver materia / Estudiante / Asignar nota, una vez se finalice la acreditable se debe colocar la nota del estudiante pues es un requisito para su aprobación. Esta puede ser asignada por el profesor correspondiente o coordinador.

15. Una vez finalizado una fase, se registra un nuevo periodo, al hacerlo todas las materias se 'vaciarán', es decir, todos los estudiantes que se inscribieron en el periodo anterior serán ocultados y solo cargará a los nuevos inscritos del periodo actual. PD: Esta información se mantiene existente pero oculta en el componente, accesible por medio de gráficos y estadísticas.
