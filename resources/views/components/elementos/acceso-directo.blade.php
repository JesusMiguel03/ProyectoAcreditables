<section class="mt-4">
    <h2>Acceso rápido</h2>
    <div class="row">

        @php
            $iconos = ['fa-th-large', 'fa-question', 'fa-cog'];
            $accesos = ['Materias', 'Consultas', 'Perfil'];
        @endphp

        <x-elementos.card-acceso :url="route('materias.index')" :icono="$iconos[0]" :nombreAcceso="$accesos[0]" />
        <x-elementos.card-acceso :url="route('preguntas.index')" :icono="$iconos[1]" :nombreAcceso="$accesos[1]" />
        <x-elementos.card-acceso :url="route('perfil.index')" :icono="$iconos[2]" :nombreAcceso="$accesos[2]" />

    </div>
</section>
