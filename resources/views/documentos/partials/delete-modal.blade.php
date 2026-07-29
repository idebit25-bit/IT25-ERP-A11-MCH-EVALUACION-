<!-- Modal eliminar documento -->

<div
    class="modal fade"
    id="deleteModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Confirmar eliminación
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body">

                ¿Desea eliminar el documento:

                <strong id="documentoNombre"></strong>?

                <br><br>

                Esta acción no se puede deshacer.

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Cancelar
                </button>

                <form
                    id="deleteForm"
                    method="POST"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Eliminar
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>