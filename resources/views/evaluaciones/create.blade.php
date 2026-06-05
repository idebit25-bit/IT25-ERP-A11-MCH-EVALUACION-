@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Encabezado -->

    <div class="mb-4">

        <h1 class="fw-bold">
            Nueva Evaluación
        </h1>

        <p class="text-muted">
            Registro de una nueva evaluación dentro del sistema.
        </p>

    </div>

    <!-- Formulario -->

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <form>

                <!-- Empleado -->

                <div class="mb-3">

                    <label class="form-label">
                        Empleado
                    </label>

                    <input 
                        type="text" 
                        class="form-control"
                        placeholder="Nombre del empleado"
                    >

                </div>

                <!-- Tipo -->

                <div class="mb-3">

                    <label class="form-label">
                        Tipo de evaluación
                    </label>

                    <select class="form-select">

                        <option>
                            Seleccionar
                        </option>

                        <option>
                            Desempeño
                        </option>

                        <option>
                            Prueba
                        </option>

                        <option>
                            Seguimiento
                        </option>

                    </select>

                </div>

                <!-- Comentarios -->

                <div class="mb-4">

                    <label class="form-label">
                        Comentarios
                    </label>

                    <textarea 
                        class="form-control"
                        rows="4"
                        placeholder="Comentarios generales"
                    ></textarea>

                </div>

                <!-- Botón -->

                <button class="btn btn-primary">
                    Guardar evaluación
                </button>

            </form>

        </div>

    </div>

</div>

@endsection