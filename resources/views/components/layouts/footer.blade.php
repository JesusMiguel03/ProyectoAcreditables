<footer class="main-footer">
    <img style="height: 2rem;" class="mx-2" src="{{ asset('/img/logo.png') }}">
    <strong>Coordinación de Acreditables | UPTA Federico Brito Figueroa </strong> |
    Copyright &copy; 2022-2023 - Todos los derechos reservados.
</footer>

{{-- Control Sidebar --}}
<aside class="control-sidebar control-sidebar-dark"></aside>
</div>

{{-- Scripts --}}
<script src="{{ asset('/js/time.js') }}"></script>
{{-- jQuery --}}
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
{{-- Bootstrap 4 --}}
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- AdminLTE App --}}
<script src="{{ asset('/dist/js/adminlte.js') }}"></script>
@yield('scripts')
</body>

</html>
