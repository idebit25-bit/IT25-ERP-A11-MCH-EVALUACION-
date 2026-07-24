/* ==========================================================
   ERP CAPITAL HUMANO
   CATÁLOGO BASE
   VALORES DE ESCALA
   ========================================================== */

INSERT INTO evaluation_scale_values
(
    scale_id,
    label,
    numeric_value,
    display_order,
    is_active,
    created_at,
    updated_at
)
VALUES

/* Escala Likert 1-5 */

(1,'Muy deficiente',1,1,1,NOW(),NOW()),
(1,'Deficiente',2,2,1,NOW(),NOW()),
(1,'Regular',3,3,1,NOW(),NOW()),
(1,'Bueno',4,4,1,NOW(),NOW()),
(1,'Excelente',5,5,1,NOW(),NOW()),

/* Escala Sí / No */

(2,'No',0,1,1,NOW(),NOW()),
(2,'Sí',1,2,1,NOW(),NOW()),

/* Escala Aprobado / No aprobado */

(3,'No aprobado',0,1,1,NOW(),NOW()),
(3,'Aprobado',1,2,1,NOW(),NOW());