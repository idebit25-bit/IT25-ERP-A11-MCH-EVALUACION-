document.addEventListener('DOMContentLoaded', function () {

    const deleteModal = document.getElementById('deleteModal');

    if (deleteModal) {

        deleteModal.addEventListener('show.bs.modal', function (event) {

        
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-documento');

            document.getElementById('deleteForm').action = `/documentos/${id}`;

            document.getElementById('documentoNombre').textContent = nombre;

        });

    }
const uploadModal = document.getElementById('uploadModal');

if (uploadModal) {

    uploadModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const tipo = button.getAttribute('data-tipo');

        const select = document.getElementById('tipoDocumento');

        if (select) {

            select.value = tipo;

        }

    });

}

});

