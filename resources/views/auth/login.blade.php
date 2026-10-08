@extends('layouts.auth')

@section('content')

<div class="container">

    <div class="row justify-content-center align-items-center"
         style="min-height: 100vh;">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body p-5">

                    <div class="text-center mb-4">

                        <h2>

                            ERP Capital Humano

                        </h2>

                        <p class="text-muted">

                            Inicio de sesión

                        </p>

                    </div>

                    <form
                        method="POST"
                        action="{{ route('login.store') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Correo electrónico

                            </label>

                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                value="{{ old('email') }}"
                                required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Contraseña

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                name="password"
                                required>

                        </div>

                        <button
                            class="btn btn-primary w-100">

                            Iniciar sesión

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
