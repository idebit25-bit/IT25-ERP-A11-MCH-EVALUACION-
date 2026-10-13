# Estado del alcance — 8 de octubre de 2026

Se conserva el funcionamiento previo del módulo y se retiran las ampliaciones de evaluaciones por indicación del responsable del proyecto. El manual y el documento de alcance originales no fueron modificados.

## Apartado marcado en amarillo del documento de alcance

| Funcionalidad | Estado después del descarte |
| --- | --- |
| Definir y configurar roles y permisos | Conservada: Super Admin, Admin y Usuario; administración de cuentas, estados, contraseñas y permisos operativos. |
| Acceso de colaboradores a sus propias evaluaciones | Implementado el flujo personal: listado, respuestas del colaborador, consulta del evaluador y reapertura por Super Admin con bitácora. Publicación de resultados sigue pendiente. |
| Asignación por perfiles y grupos | Pendiente. Se retiró la asignación grupal; permanece el registro individual que ya existía. |
| Validación y publicación de resultados | Implementadas: revisión por evaluador asignado, validación y publicación por Admin con evaluaciones.gestionar o Super Admin. Registro de responsables, fechas y bitácora. |
| Ampliar historial e indicadores de desempeño | Pendiente. Se retiró la pantalla de evolución añadida; permanecen las pantallas previas. |
| Planes de mejora | Pendiente. Se retiraron las pantallas, rutas y tabla añadidas. |
| Notificaciones de evaluaciones | Implementadas dentro del sistema: campana junto al perfil, historial y lectura individual o conjunta. Avisos para colaborador y evaluador activos al asignar, cambiar fecha/responsables/estado y completar o cancelar. |

Se conservó roles y permisos y se implementaron nuevamente las notificaciones por solicitud del responsable: **2 de las 7 ampliaciones marcadas** disponibles, con notificaciones limitadas al flujo actual. Esto no representa el porcentaje de avance del proyecto completo: el manual describe funcionalidades anteriores que siguen en el sistema.

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