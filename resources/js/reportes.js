/* ------- Reportes.js --------*/
console.log('reportes.js cargado');

document.addEventListener('DOMContentLoaded', () => {

/* ------- Generar Reporte Principal --------*/

    const btnGenerar =
        document.getElementById('btnGenerarReporte');

    if (btnGenerar) {

        btnGenerar.addEventListener('click', () => {

            const tipo =
                document.getElementById('tipoReporte').value;

            const formato =
                document.getElementById('formatoReporte').value;

            const periodo =
                document.getElementById('periodo').value;

let url = '';

if (formato === 'pdf') {

    url = `/reportes/pdf/${tipo}`;

} else {

    url = `/reportes/excel/${tipo}`;

}

if (periodo) {

    url += `?periodo=${encodeURIComponent(periodo)}`;

}

window.open(url, '_blank');

        });

    }
/* ------- Tarjetas Superiores --------*/

    const tarjetas =
        document.querySelectorAll('.reporte-card');

tarjetas.forEach(card => {

    card.addEventListener('click', () => {



        const tipo =
            card.dataset.tipo;

            let titulo = '';
            let contenido = '';

            switch (tipo) {

                case 'evaluaciones':

                    titulo =
                        'Reporte de Evaluaciones';

                    contenido = `
<div class="container-fluid">

    <div class="row text-center mb-3">

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Total</small>

                    <h5 class="mb-0">
                        156
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Promedio</small>

                    <h5 class="mb-0">
                        89%
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Última</small>

                    <h5 class="mb-0">
                        Mayo
                    </h5>

                </div>

            </div>

        </div>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Desempeño General
        </label>

        <div class="progress">

            <div
                class="progress-bar bg-primary"
                style="width:89%;">

                89%

            </div>

        </div>

    </div>

    <div class="text-center">

        <button
            class="btn btn-primary btn-sm me-2 btn-generar"
            data-tipo="evaluaciones">

            Generar reporte

        </button>

        <a
            href="/evaluaciones"
            class="btn btn-outline-secondary btn-sm">

            Ir a Evaluaciones

        </a>

    </div>

</div>
    `;

                break;

                case 'colaboradores':

                    titulo =
                        'Reporte de Colaboradores';

                    contenido = `
<div class="container-fluid">

    <div class="row text-center mb-3">

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Activos</small>

                    <h5 class="mb-0">
                        24
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Áreas</small>

                    <h5 class="mb-0">
                        4
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Pendientes</small>

                    <h5 class="mb-0">
                        3
                    </h5>

                </div>

            </div>

        </div>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Personal Activo
        </label>

        <div class="progress">

            <div
                class="progress-bar bg-success"
                style="width:85%;">

                85%

            </div>

        </div>

    </div>

    <div class="text-center">

        <button
            class="btn btn-primary btn-sm me-2 btn-generar"
            data-tipo="colaboradores">

            Generar reporte

        </button>

        <a
            href="/colaboradores"
            class="btn btn-outline-secondary btn-sm">

            Ir a Colaboradores

        </a>

    </div>

</div>
                    `;

                break;

                case 'documentos':

                    titulo =
                        'Reporte de Documentos';

                    contenido = `
<div class="container-fluid">

    <div class="row text-center mb-3">

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Vigentes</small>

                    <h5 class="mb-0">
                        35
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Por vencer</small>

                    <h5 class="mb-0">
                        4
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-4">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Formatos</small>

                    <h5 class="mb-0">
                        12
                    </h5>

                </div>

            </div>

        </div>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Cumplimiento Documental
        </label>

        <div class="progress">

            <div
                class="progress-bar bg-warning"
                style="width:92%;">

                92%

            </div>

        </div>

    </div>

    <div class="text-center">

        <button
            class="btn btn-primary btn-sm me-2 btn-generar"
            data-tipo="documentos">

            Generar reporte

        </button>

        <a
            href="/documentos"
            class="btn btn-outline-secondary btn-sm">

            Ir a Documentos

        </a>

    </div>

</div>
                    `;

                break;

                case 'general':

                    titulo =
                        'Reporte General RH';

                    contenido = `
 <div class="container-fluid">

    <div class="row text-center mb-3">

        <div class="col-3">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Colab.</small>

                    <h5 class="mb-0">
                        24
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-3">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Eval.</small>

                    <h5 class="mb-0">
                        156
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-3">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Docs.</small>

                    <h5 class="mb-0">
                        35
                    </h5>

                </div>

            </div>

        </div>

        <div class="col-3">

            <div class="card border-0 bg-light">

                <div class="card-body p-2">

                    <small>Prom.</small>

                    <h5 class="mb-0">
                        89%
                    </h5>

                </div>

            </div>

        </div>

    </div>

    <div class="mb-3">

        <label class="form-label">
            Indicador General RH
        </label>

        <div class="progress">

            <div
                class="progress-bar bg-danger"
                style="width:89%;">

                89%

            </div>

        </div>

    </div>

    <div class="text-center">

        <button
            class="btn btn-primary btn-sm btn-generar"
            data-tipo="general">

            Generar reporte

        </button>

    </div>

</div>
                    `;

                break;
            }

            document.getElementById('tituloReporte')
                .innerHTML = titulo;

            document.getElementById('contenidoReporte')
                .innerHTML = contenido;

            const modal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalDetalleReporte'
                    )
                );



            modal.show();

/*------- Botones Generar Reporte desde el Modal de Tarjetas -------*/

            setTimeout(() => {

    const botonesGenerar =
        document.querySelectorAll('.btn-generar');

    botonesGenerar.forEach(btn => {

        btn.addEventListener('click', () => {

            const tipo =
                btn.dataset.tipo;

            document.getElementById(
                'tipoReporte'
            ).value = tipo;

            bootstrap.Modal.getInstance(
                document.getElementById(
                    'modalDetalleReporte'
                )
            ).hide();

            const modalGenerar =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalGenerarReporte'
                    )
                );

            modalGenerar.show();

        });

    });

}, 100);



        });

    });

    /*-------- Historial de Reportes - Boton Ver --------*/

const botonesVer =
    document.querySelectorAll('.btnVerReporte');

botonesVer.forEach(boton => {

    boton.addEventListener('click', () => {

        const id =
            boton.dataset.id;

        const nombre =
            boton.dataset.nombre;

        const tipo =
            boton.dataset.tipo;

document.getElementById(
    'btnPdfReporte'
).dataset.tipo = tipo;

document.getElementById(
    'btnExcelReporte'
).dataset.tipo = tipo;
        const fecha =
            boton.dataset.fecha;

        const usuario =
            boton.dataset.usuario;

        const estado =
            boton.dataset.estado;

        document.getElementById(
            'contenidoVerReporte'
        ).innerHTML = `

            <p>
                <strong>ID:</strong> ${id}
            </p>

            <p>
                <strong>Reporte:</strong> ${nombre}
            </p>

            <p>
                <strong>Tipo:</strong> ${tipo}
            </p>

            <p>
                <strong>Fecha:</strong> ${fecha}
            </p>

            <p>
                <strong>Generado por:</strong> ${usuario}
            </p>

            <p>
                <strong>Estado:</strong> ${estado}
            </p>

        `;

        const modal =
            new bootstrap.Modal(
                document.getElementById(
                    'modalVerReporte'
                )
            );

        modal.show();

    });

});

/*-------- Historial de Reportes - PDF --------*/

console.log('Buscando botón PDF');

const btnPdf =
    document.getElementById(
        'btnPdfReporte'
    );

console.log(btnPdf);

if (btnPdf) {

    btnPdf.addEventListener('click', () => {

        console.log('CLICK PDF');

        const tipo =
            btnPdf.dataset.tipo;

        console.log(tipo);

window.open(
    `/reportes/pdf/${tipo.toLowerCase()}`,
    '_blank'
);

    });

}

/*-------- Historial de Reportes - Excel --------*/

const btnExcel =
    document.getElementById(
        'btnExcelReporte'
    );

if (btnExcel) {

    btnExcel.addEventListener('click', () => {

        const tipo =
            btnExcel.dataset.tipo;

window.open(
    `/reportes/excel/${tipo.toLowerCase()}`,
    '_blank'
);

    });

}

/*-------- Historial de Reportes - Eliminar --------*/

const botonesEliminar =
    document.querySelectorAll(
        '.btnEliminarReporte'
    );

botonesEliminar.forEach(boton => {

    boton.addEventListener('click', () => {

        const nombre =
            boton.dataset.nombre;

        document.getElementById(
            'mensajeEliminarReporte'
        ).innerHTML = `

            ¿Desea eliminar el reporte
            <strong>${nombre}</strong>?

        `;

        const modal =
            new bootstrap.Modal(
                document.getElementById(
                    'modalEliminarReporte'
                )
            );

        modal.show();

    });

});

});