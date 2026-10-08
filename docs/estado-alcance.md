# Estado del alcance — 8 de octubre de 2026

Se conserva el funcionamiento previo del módulo y se retiran las ampliaciones de evaluaciones por indicación del responsable del proyecto. El manual y el documento de alcance originales no fueron modificados.

## Apartado marcado en amarillo del documento de alcance

| Funcionalidad | Estado después del descarte |
| --- | --- |
| Definir y configurar roles y permisos | Conservada: Super Admin, Admin y Usuario; administración de cuentas, estados, contraseñas y permisos operativos. |
| Acceso de colaboradores a sus propias evaluaciones | Pendiente. Se retiró el flujo personal. El usuario común conserva consulta de documentos. |
| Asignación por perfiles y grupos | Pendiente. Se retiró la asignación grupal; permanece el registro individual que ya existía. |
| Validación y publicación de resultados | Pendiente. Se retiraron estas etapas añadidas; permanece el flujo original de evaluaciones. |
| Ampliar historial e indicadores de desempeño | Pendiente. Se retiró la pantalla de evolución añadida; permanecen las pantallas previas. |
| Planes de mejora | Pendiente. Se retiraron las pantallas, rutas y tabla añadidas. |
| Notificaciones de evaluaciones | Pendiente. Se retiró la implementación añadida. |

Se conserva **1 de las 7 ampliaciones marcadas**. Esto no representa el porcentaje de avance del proyecto completo: el manual describe funcionalidades anteriores que siguen en el sistema.

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
- **Usuario:** consulta de documentos. El acceso personal a evaluaciones queda pendiente del alcance.

Los permisos configurables son: gestión de evaluaciones existentes, documentos, colaboradores, consulta de reportes y configuración de catálogos. Ya no se ofrecen permisos para validar/publicar resultados de la ampliación retirada.

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
