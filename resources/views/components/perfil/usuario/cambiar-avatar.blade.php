@php
    $avatares = [
        [
            'nro' => 1,
            'url' => 'vendor/img/avatares/avatar1.webp',
        ],
        [
            'nro' => 2,
            'url' => 'vendor/img/avatares/avatar2.webp',
        ],
        [
            'nro' => 3,
            'url' => 'vendor/img/avatares/avatar3.webp',
        ],
        [
            'nro' => 4,
            'url' => 'vendor/img/avatares/avatar4.webp',
        ],
        [
            'nro' => 5,
            'url' => 'vendor/img/avatares/avatar5.webp',
        ],
        [
            'nro' => 6,
            'url' => 'vendor/img/avatares/avatar6.webp',
        ],
        [
            'nro' => 7,
            'url' => 'vendor/img/avatares/avatar7.webp',
        ],
        [
            'nro' => 8,
            'url' => 'vendor/img/avatares/avatar8.webp',
        ],
        [
            'nro' => 9,
            'url' => 'vendor/img/avatares/avatar9.webp',
        ],
    ];
@endphp

<div class="modal fade" id="avatar" tabindex="-1" role="dialog" aria-labelledby="campoCategoria" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-top">
            <header class="modal-header bg-primary">
                <h5 class="modal-title text-center" id="campoAvatar">Avatares disponibles</h5>
            </header>

            <main class="modal-body">
                <form action="{{ route('perfil.avatar', auth()->user()->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <input type="number" id="avatarID" name="avatarID" class="d-none" hidden>

                    <section class="card">
                        <div class="row mx-auto p-4">
                            @foreach ($avatares as $avatar)
                                <div class="col-4">
                                    <div class="border mx-auto my-2 rounded-circle avatar-contenedor"
                                        {{ Popper::arrow()->pop('Avatar ' . $avatar['nro']) }}>
                                        <img src="{{ request()->secure() ? secure_asset($avatar['url']) : asset($avatar['url']) }}"
                                            alt="Avatar {{ $avatar['nro'] }}" id="{{ $avatar['nro'] }}"
                                            class="p-2 avatar">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section id="avatarSeleccionado" class="d-none card">
                        <header class="p-2 rounded-top border-bottom card-head bg-secondary text-center">
                            <h5>Avatar seleccionado</h5>
                        </header>
                        <main class="card-body text-center">
                            <img alt="Avatar seleccionado" id="seleccion"
                                class="p-3 border border-primary rounded-circle avatar-seleccionado">
                        </main>
                    </section>

                    <x-modal.footer-aceptar />
                </form>
            </main>
        </div>
    </div>
</div>
