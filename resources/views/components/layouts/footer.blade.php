<footer class="main-footer">
    <img style="height: 2rem;" class="mx-2" src="{{ asset('/assets/img/logo.png') }}">
    <strong>Coordinación de Acreditables | UPTA Federico Brito Figueroa </strong> |
    Copyright &copy; 2022-2023 - Todos los derechos reservados.
</footer>

{{-- Control Sidebar --}}
<aside class="control-sidebar control-sidebar-dark"></aside>
</div>

{{-- Scripts --}}
<script src="{{ asset('/assets/js/time.js') }}"></script>
{{-- jQuery --}}
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
{{-- Bootstrap 4 --}}
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- AdminLTE App --}}
<script src="{{ asset('/assets/dist/js/adminlte.js') }}"></script>
@yield('scripts')
</body>

</html>
