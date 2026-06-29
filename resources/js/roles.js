
/* Roles.js */

console.log('roles.js cargado');

document.addEventListener('DOMContentLoaded', () => {

    /* Nuevo Rol */

    const btnNuevo =
        document.getElementById(
            'btnNuevoRol'
        );

    if (btnNuevo) {

        btnNuevo.addEventListener('click', () => {

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalNuevoRol'
                    )
                );

            modal.show();

        });

    }

    /* Ver Rol */

    const botonesVer =
        document.querySelectorAll(
            '.btnVerRol'
        );

    botonesVer.forEach(boton => {

        boton.addEventListener('click', () => {

            const id =
                boton.dataset.id;

            const nombre =
                boton.dataset.nombre;

            const descripcion =
                boton.dataset.descripcion;

            const usuarios =
                boton.dataset.usuarios;

            const estado =
                boton.dataset.estado;

            document.getElementById(
                'contenidoVerRol'
            ).innerHTML = `

                <p><strong>ID:</strong> ${id}</p>

                <p><strong>Nombre:</strong> ${nombre}</p>

                <p><strong>Descripción:</strong> ${descripcion}</p>

                <p><strong>Usuarios asignados:</strong> ${usuarios}</p>

                <p><strong>Estado:</strong> ${estado}</p>

            `;

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalVerRol'
                    )
                );

            modal.show();

        });

    });

    /* Editar Rol */

    const botonesEditar =
        document.querySelectorAll(
            '.btnEditarRol'
        );

    botonesEditar.forEach(boton => {

        boton.addEventListener('click', () => {

            document.getElementById(
                'editarNombreRol'
            ).value =
                boton.dataset.nombre;

            document.getElementById(
                'editarDescripcionRol'
            ).value =
                boton.dataset.descripcion;

            document.getElementById(
                'editarEstadoRol'
            ).value =
                boton.dataset.estado;

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalEditarRol'
                    )
                );

            modal.show();

        });

    });

    /* Cambiar Estado */

    const botonesEstado =
        document.querySelectorAll(
            '.btnEstadoRol'
        );

    botonesEstado.forEach(boton => {

        boton.addEventListener('click', () => {

            const nombre =
                boton.dataset.nombre;

            const estado =
                boton.dataset.estado;

            if (estado === 'Activo') {

                document.getElementById(
                    'mensajeEstadoRol'
                ).textContent =
                    `¿Deseas desactivar el rol ${nombre}?`;

                document.getElementById(
                    'btnConfirmarEstadoRol'
                ).textContent =
                    'Desactivar Rol';

            } else {

                document.getElementById(
                    'mensajeEstadoRol'
                ).textContent =
                    `¿Deseas activar el rol ${nombre}?`;

                document.getElementById(
                    'btnConfirmarEstadoRol'
                ).textContent =
                    'Activar Rol';

            }

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalEstadoRol'
                    )
                );

            modal.show();

        });

    });

});