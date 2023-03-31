@php
    $modelo = atributo($attributes, 'modelo')
@endphp

<input type="text" name="vacio" value=0 class="d-none" hidden>
<p class="vacio col-12">No hay {{ $modelo }} disponibles</p>
