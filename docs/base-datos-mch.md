# Base independiente del módulo de capital humano

Preparada el 15 de octubre de 2026 en el servidor local MySQL/MariaDB.

- Origen conservado: `capital_humano_dev` (58 tablas).
- Nueva base: `capital_humano_mch` (39 tablas).
- La aplicación continúa conectada al origen; no se cambió `.env`.
- La copia es una instantánea independiente, sin sincronización posterior.

## Estructura conservada

| Función | Tablas |
| --- | --- |
| Personal | users, departments, positions |
| Catálogos referenciados por el personal | educational_levels, marital_statuses, states, municipalities, neighborhoods |
| Acceso | roles, permissions, model_has_roles, role_has_permissions |
| Evaluaciones | evaluations, evaluation_answers, evaluation_types, evaluation_periods, evaluation_categories, evaluation_competencies, evaluation_questions, evaluation_scales, evaluation_scale_values, evaluation_templates, evaluation_template_questions |
| Compatibilidad de Reportes | user_evaluations |
| Documentos | documents, document_counters |
| Mejora | improvement_plans, improvement_actions, improvement_updates |
| Seguimiento | notifications, activity_logs |
| Infraestructura Laravel | migrations, cache, cache_locks, jobs, job_batches, failed_jobs, sessions, password_reset_tokens |

Se conservaron las columnas, tipos, índices, identificadores, secuencias y relaciones de las tablas seleccionadas para preservar los datos y la compatibilidad con los modelos actuales. No se hizo una poda de columnas de personal: el modelo declara campos adicionales a los capturados por el formulario y pueden contener antecedentes. Esta separación elimina módulos ajenos, sin rediseñar el expediente del colaborador.

`user_evaluations` sigue siendo necesaria para la consulta por departamentos de Reportes. Su unificación con `evaluations` requiere un cambio de código posterior. Los catálogos de domicilio, escolaridad y estado civil se conservaron por sus claves foráneas en `users`.

Las tablas auxiliares de Laravel se crearon vacías; no se copiaron sesiones, tokens de recuperación, caché ni trabajos pendientes. `sessions` y `password_reset_tokens` se conservan como parte de la estructura que crea la migración base de Laravel, aunque el flujo actual no las use. Los registros de migración de la nueva base corresponden a los 11 archivos locales, como línea base del esquema importado; no se copiaron migraciones del ERP ajeno.

## Tablas excluidas

contacts, contract_types, contracts, customer_addresses, customer_documents,
customer_interactions, customer_invitations, customers, invoice_payments, invoices,
model_has_permissions, order_documents, order_notes, order_user, orders,
user_academic_trajectories, user_career_paths, user_relatives, user_work_experiences.

Sus datos siguen en la base original. No se eliminaron ni trasladaron.

## Validación realizada

- Copia desde una transacción de solo lectura con instantánea consistente del origen.
- Comparación de cantidades y SHA-256 de todas las filas de las 31 tablas de datos copiadas.
- 17 claves foráneas existentes comprobadas sin referencias huérfanas.
- 13 relaciones adicionales de evaluaciones, respuestas, plantillas y planes comprobadas sin referencias huérfanas.
- 35 rutas GET comprobadas con una conexión temporal a la nueva base y usuario Super Admin: respuesta HTTP 200.
- Escrituras de usuario, asignación de rol y notificación verificadas dentro de una transacción revertida.
- Disponibilidad de los 8 PDF existentes comprobada mediante el servicio de archivos de la aplicación.

Estas comprobaciones no sustituyen una prueba manual completa de todos los flujos y roles antes de cambiar la conexión principal.

## Archivos y uso posterior

Los PDF se almacenan fuera de la base: ambas bases referencian los mismos archivos locales. Una base independiente no crea un almacenamiento de archivos independiente. Para operar ambas versiones simultáneamente con ediciones o borrados de documentos, se debe separar también el almacenamiento.

Las herramientas locales y el informe de verificación están en `.codex/db-isolation`, excluido de Git. No se publicaron datos ni credenciales.

Antes de activar la nueva base, hay que revisar si el origen recibió cambios posteriores a esta instantánea y actualizar la copia según corresponda. El cambio de conexión no forma parte de esta preparación. No ejecutar `migrate:fresh` ni revertir las migraciones base importadas: las migraciones históricas del proyecto no reconstruyen por sí solas todo el esquema del ERP importado.
