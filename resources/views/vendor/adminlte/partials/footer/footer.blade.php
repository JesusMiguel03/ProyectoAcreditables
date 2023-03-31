<footer class="main-footer">
    <img style="height: 2rem;" class="mx-2"
        src="{{ request()->secure() ? secure_asset('vendor/img/logo.png') : asset('vendor/img/logo.png') }}">
    <strong>Coordinación de Acreditables | UPTA Federico Brito Figueroa </strong> |
    Copyright &copy; <span id="fecha"></span> | Todos los derechos reservados.
</footer>

<script>
    document.getElementById('fecha').innerHTML = `2022 - ${new Date().getFullYear()}`
</script>
