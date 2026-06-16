import '../css/app.css';
import '../css/navbar.css';
import '../css/sidebar.css';
import '../css/footer.css';
import '../css/dashboard.css';
import '../css/evaluaciones.css';
import '../css/documentos.css';
import '../css/configuracion.css';
import '../css/colaboradores.css';
import '../css/reportes.css';
import './documentos.js';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';

/*
|--------------------------------------------------------------------------
| Menú Hamburguesa
|--------------------------------------------------------------------------
| Oculta y muestra el sidebar.
*/

document.addEventListener('DOMContentLoaded', () => {

    const button = document.getElementById('menu-toggle');

    const sidebar = document.querySelector('.sidebar');

    if(button && sidebar){

        button.addEventListener('click', () => {

            sidebar.classList.toggle('sidebar-hidden');

        });

    }

});