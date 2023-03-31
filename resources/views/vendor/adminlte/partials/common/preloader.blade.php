<div class="preloader flex-column justify-content-center align-items-center">

    {{-- Preloader logo --}}
    <img src="{{ request()->secure() ? secure_asset('vendor/img/logo.png') : asset('vendor/img/logo.png') }}"
        class="{{ config('adminlte.preloader.img.effect', 'animation__shake') }}"
        alt="{{ config('adminlte.preloader.img.alt', 'Logo de la UPTA') }}"
        width="{{ config('adminlte.preloader.img.width', 60) }}"
        height="{{ config('adminlte.preloader.img.height', 60) }}">

</div>
