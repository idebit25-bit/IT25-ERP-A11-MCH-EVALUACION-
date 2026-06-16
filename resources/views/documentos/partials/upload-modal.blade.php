<!-- Modal subir documento -->

<div
    class="modal fade"
    id="uploadModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Subir Documento

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>

            <div class="modal-body">

                <form>

                    <div class="mb-3">

                        <label class="form-label">
                            Nombre del documento
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            placeholder="Ingrese el nombre"
                        >

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tipo
                            </label>

                            <select
                                id="tipoDocumento"
                                class="form-select"
                            >

                                <option value="">
                                    Seleccione
                                </option>

                                <option value="Manual">
                                    Manual
                                </option>

                                <option value="Formato">
                                    Formato
                                </option>

                                <option value="Política">
                                    Política
                                </option>

                                <option value="Procedimiento">
                                    Procedimiento
                                </option>

                            </select>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Versión
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                placeholder="1.0"
                            >

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Vigencia
                        </label>

                        <input
                            type="date"
                            class="form-control"
                        >

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            PDF
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            accept=".pdf"
                        >

                    </div>

                </form>

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >

                    Cancelar

                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                >

                    Guardar

                </button>

            </div>

        </div>

    </div>

</div>