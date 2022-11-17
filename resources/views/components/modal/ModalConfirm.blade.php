{{-- Button trigger modal --}}
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">
    {{ __('Eliminar') }}
</button>

{{-- Modal --}}
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header mx-auto">
                <h5 class="modal-title" id="confirmModalLabel">¿Desea eliminar este curso?</h5>
            </div>
            <div class="modal-footer mx-auto">
                {{-- <form action="{{ route('courses.destroy', $course['id']) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger"
                        style="width: 5.5rem">Eliminar</button>
                </form> --}}
                <button type="button" class="btn btn-danger" style="width: 5.5rem" data-dismiss="modal">Borrar</button>
                <button type="button" class="btn btn-secondary" style="width: 5.5rem" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
