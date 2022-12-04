<h1 align="center">Proyecto de Acreditables</h1>

<p align="center">
    <img src="./public/vendor/img/logo.png" width="120" height="150">
</p>

## 🖥Código

Para clonar y trabajar con el repositorio seguir las siguientes instrucciones:
Abrir la consola de comandos en la carpeta del servidor local (xampp: /htdocs o laragon y wampp /www), pegar el siguiente enlace y darle enter.
```
git clone https://github.com/JesusMiguel03/ProyectoAcreditables.git
```
Se require tener instalado [composer](https://getcomposer.org/download/)
```
composer install
```
Dentro del IDE de su preferencia y en la ruta donde se encuentra la carpeta descargada, pegar los siguientes enlaces y darle enter.
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

Componente web diseñado para la gestión administrativa de procesos dentro de la Coordinación de Acreditables, como bien son:

- Pre-inscripción de estudiantes.
- Inscripciones de los mismos.
- Creación y apertura de cursos.
- Cursos de formación integral.
- Entre otros aspectos importantes.

Este proyecto se conforma por el uso de diferentes lenguajes y sus herramientas, como lo son:

**Lenguajes**
- HTML5.
- CSS3.
- JavaScript.
- Php.

**Plugins**
- [jQuery](https://jquery.com/download/).
- [SweetAlert2](https://sweetalert2.github.io).
- [DataTables](https://datatables.net).
- [Bs stepper](https://johann-s.github.io/bs-stepper/).
- [Slick](http://kenwheeler.github.io/slick/).
- [Spatie](https://spatie.be/docs/laravel-permission/v5/introduction).

**Frameworks**
- [Bootstrap (Frontend)](https://getbootstrap.com/docs/4.6/getting-started/introduction/).
- [Laravel (Backend)](https://laravel.com/docs/8.x/installation).
