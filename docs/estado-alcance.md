# Estado del alcance — actualizado el 14 de octubre de 2026

Se conserva el funcionamiento previo del módulo y se retiran las ampliaciones de evaluaciones por indicación del responsable del proyecto. El manual y el documento de alcance originales no fueron modificados.

## Apartado marcado en amarillo del documento de alcance

| Funcionalidad | Estado actual |
| --- | --- |
| Definir y configurar roles y permisos | Conservada: Super Admin, Admin y Usuario; administración de cuentas, estados, contraseñas y permisos operativos. |
| Acceso de colaboradores a sus propias evaluaciones | Implementado: listado, respuestas del colaborador, consulta del evaluador, resultados publicados y reapertura por Super Admin con bitácora. |
| Asignación por perfiles y grupos | Pendiente. Se retiró la asignación grupal; permanece el registro individual que ya existía. |
| Validación y publicación de resultados | Implementadas: revisión por evaluador asignado, validación y publicación por Admin con evaluaciones.gestionar o Super Admin. Registro de responsables, fechas y bitácora. |
| Ampliar historial e indicadores de desempeño | Implementado: historial individual, filtros, indicadores de resultados publicados y gráfica por periodos cuando existe una referencia histórica compatible. |
| Planes de mejora | Implementados: plan por evaluación publicada, acciones con responsables y fechas, avances comentados, vencimientos visibles y cierre administrativo con bitácora. |
| Notificaciones de evaluaciones | Implementadas dentro del sistema: campana junto al perfil, historial y lectura individual o conjunta. Avisos para colaborador y evaluador activos al asignar, cambiar fecha/responsables/estado y completar o cancelar. |

Actualmente están disponibles **6 de las 7 ampliaciones marcadas**, tras las nuevas autorizaciones. Queda pendiente la asignación por perfiles/grupos (retirada nuevamente a solicitud del responsable). Esto no representa el porcentaje de avance del proyecto completo. Los apartados fechados siguientes conservan la historia de las entregas.

## Otros cambios conservados

- El logotipo enlaza al inicio correspondiente: Dashboard para administradores; Documentos para Usuario. En esa pantalla deja de ser un enlace.
- Icono de empresa en la pestaña del navegador y pantalla de acceso.
- Estilos compilados corregidos para que los logos no aparezcan con dimensiones desproporcionadas.
- Autenticación de cuentas activas, navegación y formularios necesarios para el control de accesos.
- Las cuentas locales y la reparación de las tablas faltantes del respaldo.
- Los cambios en Configuración y Reportes que ya estaban presentes antes de nuestra intervención.

## Roles conservados

- **Super Admin:** acceso completo y gestión de cuentas y permisos.
- **Admin:** acceso operativo a los módulos existentes según los permisos habilitados; no administra roles ni cuentas privilegiadas.
- **Usuario:** consulta de documentos, notificaciones propias y listado Mis evaluaciones. El colaborador responde sus pruebas desde Mis evaluaciones.

Los permisos configurables son: gestión de evaluaciones existentes, documentos, colaboradores, consulta de reportes y configuración de catálogos. Ya no se ofrecen permisos para validar/publicar resultados de la ampliación retirada. Las notificaciones propias están disponibles para los tres roles activos.

## Base de datos y respaldo

Se guardó una copia del código modificado y de las tablas afectadas en `.codex/backups`, fuera de Git. Se revirtió únicamente la migración de ampliación de evaluaciones, conservando cuentas, asignaciones de roles y configuración de permisos. No se restauró toda la base a una fecha anterior.

La migración de accesos independiente es:

```powershell
php artisan migrate --path=database/migrations/2026_10_08_000001_configure_access_control.php
```

Requiere el esquema del ERP importado y conserva permisos previamente configurados. Las migraciones históricas no reconstruyen todo el respaldo: no usar `migrate:fresh` sobre la base con información.

## Repositorio de trabajo

Único remoto de este proyecto:

https://github.com/idebit25-bit/IT25-ERP-A11-MCH-EVALUACION-.git

El cambio del remoto no publica archivos por sí mismo. Los respaldos, `.env`, dependencias y configuración local del editor no se incluyen en Git.

## Notificaciones incorporadas nuevamente

Los avisos se generan para eventos nuevos; no se generan avisos retroactivos. Se guardan en la base de datos y el contador se actualiza al cargar una página. No se envían correos. No contienen calificaciones ni habilitan acceso adicional a evaluaciones. Validación, publicación, vencimientos y planes siguen pendientes, por lo que no generan avisos. La migración 2026_10_08_000002_create_notifications_table conserva la tabla existente del respaldo.

## Listado personal de evaluaciones

Disponible en /mis-evaluaciones para las cuentas activas con roles admitidos. Todos los roles ven únicamente asignaciones en las que participan. No muestra calificaciones ni observaciones. Incluye pendientes, completadas y canceladas; no cambia el inicio ni habilita las rutas administrativas. Regla confirmada: responde el colaborador evaluado; el evaluador supervisa y consulta lo enviado.

## Flujo personal autorizado el 10 de octubre de 2026

El colaborador evaluado responde las preguntas de selección de la plantilla. El evaluador asignado consulta el estado y revisa lo enviado; cualquier colaborador puede participar como evaluador de otra persona. Solo Super Admin reabre una prueba completada, con motivo obligatorio y copia de respuestas, observaciones y promedio anteriores en bitácora. El colaborador corrige y reenvía; ningún administrador responde por terceros. Las rutas antiguas de captura respetan esta regla. Las pruebas cerradas no se editan sin reapertura y las que tienen respuestas no se eliminan ni cambian de colaborador o plantilla.

El promedio conserva el cálculo existente de los valores numéricos seleccionados; no se agregó un motor de respuestas correctas ni publicación de resultados. El evaluador y Super Admin pueden revisar las respuestas completadas; la publicación al colaborador continúa pendiente. No hay monitoreo en tiempo real ni guardado automático de borradores. Los avisos enlazan al detalle personal y notifican la reapertura.

## Correcciones de Documentos completadas el 12 de octubre de 2026

Correcciones autorizadas del módulo existente, separadas de las ampliaciones marcadas del alcance:

- Formulario independiente, modal y edición admiten PDF de hasta 5 MB, conservan los datos tras validaciones y comparten los campos.
- Tipos y estados limitados a los valores del catálogo; versión limitada a los 20 caracteres del esquema real. Contador transaccional para códigos DOC, conservando los códigos existentes.
- La edición sin archivo conserva el PDF; al reemplazar, primero se guarda el nuevo y se confirma el registro antes de retirar el anterior. Un fallo de almacenamiento conserva el documento previo.
- Sin fecha se muestra «Sin vencimiento». El estado permanece manual: no se ocultan documentos vencidos ni se modifica automáticamente el estado.
- Ver y descargar PDF usan /documentos/{id}/archivo y comprueban sesión, estado de cuenta y rol. Los archivos faltantes muestran un aviso con instrucciones.
- Los ocho PDFs registrados se trasladaron al disco privado documents, con comparación SHA-256 antes de eliminar la copia pública. Se guardó un respaldo local en .codex/backups.
- Se conserva consulta para Usuario; la carga, modificación y eliminación requieren Super Admin o Admin con documentos.gestionar.

Para instalar estas correcciones en otra copia del proyecto: ejecutar la migración 2026_10_10_000001_create_document_counters_table.php, ejecutar php artisan documentos:privatizar y recompilar los recursos. Respaldar previamente los documentos y registros. El comando de traslado avisa de archivos faltantes y no retira copias públicas si no coinciden con las privadas.

Pendientes fuera de esta reparación: historial de versiones, vencimiento automático y reglas de ocultación de documentos. No se han publicado estos cambios recientes en GitHub. Verificación: 21 pruebas y 167 aserciones aprobadas; carga de listado, alta, edición y detalle comprobada por HTTP; PDF autenticado devuelve application/pdf y visitante sin sesión vuelve al login.
## Revisión, validación y publicación — 12 de octubre de 2026

Flujo autorizado: el colaborador responde; el evaluador asignado registra observaciones obligatorias y confirma la revisión; Admin con evaluaciones.gestionar o Super Admin valida y luego publica. Se conserva el estado completed para respuestas enviadas y se distinguen las etapas mediante fechas y responsables. No se cambian automáticamente las evaluaciones antiguas: las completadas quedan pendientes de revisión.

El detalle personal muestra el resultado y las observaciones al colaborador cuando está publicado. El evaluador y los administradores autorizados conservan su acceso de supervisión. La revisión notifica a administradores autorizados; la publicación notifica al colaborador con enlace al resultado. Las acciones se registran en bitácora y se bloquean pasos fuera de orden o repetidos.

Reabrir sigue siendo exclusivo de Super Admin: se guardan los antecedentes y se anulan revisión, validación y publicación. Tras reenviar las respuestas, deben repetirse esas etapas. Las observaciones del evaluador son distintas de las observaciones del colaborador. No se modifica el cálculo existente de calificación.

Migración: 2026_10_12_000001_add_evaluation_publication.php. Respaldo previo local en .codex/backups. Acciones disponibles desde el detalle de Mis evaluaciones o el enlace de seguimiento del detalle administrativo.

Pendientes del alcance tras esta entrega: asignación por perfiles y grupos, historial e indicadores de evolución del desempeño y planes de mejora. Las notas anteriores describen el estado histórico; la publicación al colaborador ya está implementada con las reglas de este apartado.
## Diseño de Roles y permisos — 12 de octubre de 2026

Se reorganizó la pantalla manteniendo Bootstrap y el diseño del módulo: resumen de los tres roles, permisos del administrador agrupados por módulo y cuentas con rol, estado y edición desplegable. Se incorporó búsqueda por nombre, apellidos o correo, resultados vacíos, identificación de la cuenta actual y recuperación del formulario con errores. Se distinguen las acciones globales del rol y las individuales de una cuenta. Se conserva la autorización exclusiva del superadministrador y las reglas existentes para proteger su propio acceso.

## Historial e indicadores de desempeño — 13 de octubre de 2026

Nueva autorización: historial administrativo desde Reportes > Historial e indicadores, para Super Admin o Admin con reportes.consultar. Este permiso habilita un detalle de solo consulta; no permite responder, revisar, validar, publicar ni reabrir. El historial propio se abre desde Mis evaluaciones y solo incluye registros del usuario como evaluado, no los de terceros a quienes supervisa. Las calificaciones propias se muestran cuando están completadas y publicadas.

Filtros por colaborador (administrativo), plantilla, periodo y tipo; incluye cuentas y catálogos inactivos para conservar la consulta histórica. Listado paginado de 15 registros con estados y detalle. Los indicadores consideran únicamente resultados completados y publicados; requieren seleccionar una plantilla para mostrar último resultado, anterior y diferencia en puntos. No se calcula promedio entre plantillas.

Se ordena la evolución por inicio y fin del periodo. Si hay varias evaluaciones en un periodo, se usa la última por fecha de evaluación e ID. La gráfica muestra hasta 12 periodos consecutivos compatibles con el último resultado y una tabla con sus valores. Los resultados no comparables permanecen en el historial; no se mezclan ni se asigna cero a datos faltantes. La reapertura excluye el resultado hasta su nueva publicación.

Migración aditiva: 2026_10_13_000001_add_evaluation_comparison_snapshot.php agrega comparison_snapshot nullable. Al enviar respuestas, se guardan preguntas, instrucciones, tipo, obligatoriedad, peso, escala, opciones con valores y preguntas respondidas. La referencia se compara sin consultar el catálogo actual. Se mantiene el promedio simple existente. Una reapertura conserva la referencia anterior en bitácora y el nuevo envío la reemplaza. El detalle utiliza los enunciados guardados cuando existen.

Las evaluaciones antiguas no contienen una copia histórica completa de las escalas; se conservan y muestran sin inferir comparabilidad. No se rellenan con datos actuales ni se modifican respuestas/calificaciones existentes. Los periodos necesitan fecha de inicio para comparar; periodos con la misma fecha de inicio no se comparan entre sí. No hay exportación nueva ni planes de mejora en esta entrega.

Para otra instalación, aplicar únicamente la migración indicada sobre el esquema existente. No usar migrate:fresh. La asignación por perfiles/grupos permanece retirada. Pendientes actuales: esa asignación y planes de mejora.

## Planes de mejora — entrega del 14 de octubre de 2026

Acceso desde Planes de mejora en la barra lateral. Super Admin y Admin con evaluaciones.gestionar pueden crear, modificar, cerrar, cancelar y reabrir. El colaborador evaluado y los responsables consultan el plan completo; cada responsable solo registra avances de sus acciones. Ser evaluador o tener permiso de reportes no da acceso general a planes. El permiso de gestión permite consultar todos los planes.

Cada evaluación completada y publicada admite un plan con varias acciones. Se registra objetivo, descripción de acciones y resultados esperados, responsable activo y fecha compromiso. Cada avance exige porcentaje de 0 a 100 y comentario. Los responsables pueden corregir porcentajes explicando el motivo; se conserva cada movimiento. El promedio de acciones es avance reportado, no una nueva calificación de desempeño.

El 100 % no cierra automáticamente: el administrador verifica todas las acciones y registra una conclusión. Cierre, cancelación y reapertura conservan antecedentes; no hay borrado de planes ni acciones. Las fechas nuevas no pueden ser anteriores al día actual; una fecha antigua puede conservarse al corregir otros datos. Las acciones pendientes cuya fecha pasó se marcan vencidas al consultar. Cuentas desactivadas se señalan para reasignación administrativa.

Se guardan cambios en el seguimiento del plan y en bitácora. Bloqueos transaccionales y control de versión rechazan envíos desactualizados. Una sola evaluación no puede generar planes duplicados. La referencia del resultado original se conserva para administración; reabrir la evaluación no borra ni cancela el plan, y aparece una advertencia para revisar su vigencia.

Notificaciones internas para participantes y administradores activos con permiso de gestión, excepto quien realiza el cambio. Se emiten por cambios guardados, dentro de la misma transacción de base de datos, sin WebSockets, correos ni consultas periódicas nuevas. No hay avisos automáticos por vencimiento. Los responsables tienen acceso al contenido del plan compartido, pero esto no amplía sus permisos sobre las respuestas de la evaluación.

Migración aditiva: 2026_10_13_000002_create_improvement_plans.php crea improvement_plans, improvement_actions e improvement_updates. Aplicar únicamente esta migración sobre el esquema existente; no usar migrate:fresh. No se cargan archivos de evidencia: por ahora se describe el cumplimiento en comentarios. Para probar: crear plan de una evaluación publicada, asignar acciones a una cuenta de prueba, registrar 50 % y 100 %, revisar la bitácora, cerrar como administrador y comprobar que ya no admite avances hasta reabrirse.

## Unificación de accesos — primera etapa, 14 de octubre de 2026

Roles y permisos se presenta como Usuarios y permisos. Configuración conserva una sola tarjeta de acceso a esa misma pantalla y la ruta GET /configuracion/usuarios redirige a /configuracion/roles, respetando la autorización exclusiva del Super Admin. Se retiraron la vista antigua de usuarios con indicadores fijos y su JavaScript de modales.

El expediente y la edición del colaborador ofrecen Administrar acceso al Super Admin: filtra por el ID exacto y abre la cuenta. Desde la cuenta se puede volver al expediente o mostrar todas las cuentas. La búsqueda y paginación de cinco cuentas se conservan.

El alta de colaboradores conserva la contraseña inicial y el rol Usuario. Los cambios posteriores de contraseña se centralizan en Usuarios y permisos: la edición de colaborador no admite ese campo, incluso mediante solicitudes manuales. Estado active/inactive sigue compartido con Colaboradores para conservar las bajas/reactivaciones existentes; ambas pantallas explican que desactivar bloquea el inicio de sesión. No se separó el estado laboral del acceso ni se añadieron permisos.

Esta etapa no requiere migración. Sigue pendiente la reorganización visual de catálogos de Configuración, revisión de indicadores fijos (respaldos y datos generales), y consolidación interna de las operaciones de estado. No confundir esa reorganización con eliminar los catálogos que usan las evaluaciones.

## Presentación del detalle de planes — 14 de octubre de 2026

Objetivo en columna lateral y acciones en columna principal en pantallas amplias; distribución vertical en móvil. Las acciones muestran responsable, fecha y porcentaje antes de desplegar sus formularios. Cierre administrativo e historial se consultan bajo demanda. Los formularios con errores permanecen abiertos; la paginación del historial abre y enlaza esa sección. Se conservan las reglas de acceso y seguimiento.
