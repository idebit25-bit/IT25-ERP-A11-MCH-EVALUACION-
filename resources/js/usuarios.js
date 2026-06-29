/* Usuarios.js */

console.log('usuarios.js cargado');

document.addEventListener('DOMContentLoaded', () => {

    /* Nuevo Usuario */

    const btnNuevo =
        document.getElementById(
            'btnNuevoUsuario'
        );

    if (btnNuevo) {

        btnNuevo.addEventListener('click', () => {

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalNuevoUsuario'
                    )
                );

            modal.show();

        });

    }

    /* Ver Usuario */

    const botonesVer =
        document.querySelectorAll(
            '.btnVerUsuario'
        );

    botonesVer.forEach(boton => {

        boton.addEventListener('click', () => {

            const id =
                boton.dataset.id;

            const nombre =
                boton.dataset.nombre;

            const usuario =
                boton.dataset.usuario;

            const correo =
                boton.dataset.correo;

            const rol =
                boton.dataset.rol;

            const estado =
                boton.dataset.estado;

            const acceso =
                boton.dataset.acceso;

            document.getElementById(
                'contenidoVerUsuario'
            ).innerHTML = `

                <p><strong>ID:</strong> ${id}</p>

                <p><strong>Nombre:</strong> ${nombre}</p>

                <p><strong>Usuario:</strong> ${usuario}</p>

                <p><strong>Correo:</strong> ${correo}</p>

                <p><strong>Rol:</strong> ${rol}</p>

                <p><strong>Estado:</strong> ${estado}</p>

                <p><strong>Último acceso:</strong> ${acceso}</p>

            `;

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalVerUsuario'
                    )
                );

            modal.show();

        });

    });

    /* Editar Usuario */

    const botonesEditar =
        document.querySelectorAll(
            '.btnEditarUsuario'
        );

    botonesEditar.forEach(boton => {

        boton.addEventListener('click', () => {

            document.getElementById(
                'editarNombre'
            ).value =
                boton.dataset.nombre;

            document.getElementById(
                'editarUsuario'
            ).value =
                boton.dataset.usuario;

            document.getElementById(
                'editarCorreo'
            ).value =
                boton.dataset.correo;

            document.getElementById(
                'editarRol'
            ).value =
                boton.dataset.rol;

            document.getElementById(
                'editarEstado'
            ).value =
                boton.dataset.estado;

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalEditarUsuario'
                    )
                );

            modal.show();

        });

    });
    

/* Bloquear Usuario */

    const botonesBloquear =
        document.querySelectorAll(
            '.btnBloquearUsuario'
        );

    botonesBloquear.forEach(boton => {

        boton.addEventListener('click', () => {

            const nombre =
                boton.dataset.nombre;

            const estado =
                boton.dataset.estado;

            if (estado === 'Activo') {

                document.getElementById(
                    'mensajeBloquearUsuario'
                ).textContent =
                    `¿Deseas bloquear a ${nombre}?`;

                document.getElementById(
                    'btnConfirmarBloqueo'
                ).textContent =
                    'Bloquear Usuario';

            } else {

                document.getElementById(
                    'mensajeBloquearUsuario'
                ).textContent =
                    `¿Deseas desbloquear a ${nombre}?`;

                document.getElementById(
                    'btnConfirmarBloqueo'
                ).textContent =
                    'Desbloquear Usuario';

            }

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalBloquearUsuario'
                    )
                );

            modal.show();

        });

    });

});