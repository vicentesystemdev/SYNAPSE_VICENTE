# 📊 Revisión Completa de la Base de Datos - Sistema IRT

## 🎯 Objetivo
Este documento explica cada tabla y atributo de la base de datos del sistema IRT, identificando qué es necesario y qué puede ser innecesario.

---

## ✅ TABLAS ESENCIALES PARA EL SISTEMA IRT

### 1. **`users`** - Usuarios del Sistema
**Propósito:** Almacena información de todos los usuarios (estudiantes, docentes, admin).

**Atributos principales:**
- `id` - Identificador único
- `name` - Nombre del usuario
- `email` - Correo electrónico (único)
- `password` - Contraseña hasheada
- `activo_usu` - Estado activo/inactivo
- `email_verified_at` - Fecha de verificación de email

**Uso en IRT:** ✅ **NECESARIO** - Identifica estudiantes para calcular theta

---

### 2. **`categorias`** - Categorías de Evaluación
**Propósito:** Almacena las categorías de evaluación (WEB, CRYPTO, FORENS, STEGO).

**Atributos principales:**
- `id_cat` - Identificador único
- `codigo_cat` - Código único (ej: 'WEB', 'CRYPTO')
- `nombre_cat` - Nombre descriptivo
- `activo_cat` - Estado activo/inactivo

**Uso en IRT:** ✅ **NECESARIO** - Permite calcular theta por categoría

---

### 3. **`dificultades`** - Niveles de Dificultad
**Propósito:** Almacena los niveles de dificultad (1_facil, 2_baja, 3_media, 4_alta, 5_dificil).

**Atributos principales:**
- `id_dif` - Identificador único
- `nombre_dif` - Nombre descriptivo
- `orden_dif` - Orden numérico (1-5)

**Uso en IRT:** ✅ **NECESARIO** - Mapea a parámetro `b_dificultad` en IRT

---

### 4. **`periodos`** - Períodos Académicos
**Propósito:** Almacena los períodos académicos (ej: '2025-2').

**Atributos principales:**
- `id_per` - Identificador único
- `nombre_per` - Nombre del período (ej: '2025-2')
- `gestion_per` - Año de gestión (ej: '2025')
- `activo_per` - Estado activo/inactivo

**Uso en IRT:** ⚠️ **PARCIALMENTE NECESARIO** - Usado para agrupar evaluaciones, pero no crítico para cálculo de theta

---

### 5. **`evaluaciones`** - Evaluaciones/Pruebas
**Propósito:** Almacena las evaluaciones que los estudiantes deben resolver.

**Atributos principales:**
- `id_eval` - Identificador único
- `categoria_id` - FK a categorías (WEB, CRYPTO, etc.)
- `dificultad_id` - FK a dificultades (1-5)
- `periodo_id` - FK a períodos (nullable)
- `docente_user_id` - FK a usuario docente (nullable)
- `titulo_eval` - Título de la evaluación
- `descripcion_eval` - Descripción (nullable)
- `puntaje_base_eval` - Puntaje base (default: 100)
- `fecha_inicio_eval` - Fecha de inicio (nullable)
- `fecha_fin_eval` - Fecha de fin (nullable)
- `flag_hash_eval` - Hash CTF (nullable, para evaluaciones no-CTF)
- `estado_eval` - Estado (1=borrador, 2=publicada)

**Uso en IRT:** ✅ **NECESARIO** - Contiene las evaluaciones que los estudiantes intentan resolver

---

### 6. **`intentos`** - Intentos de Resolución
**Propósito:** Almacena cada intento de un estudiante por resolver una evaluación.

**Atributos principales:**
- `id_int` - Identificador único
- `evaluacion_id` - FK a evaluaciones
- `user_id` - FK a usuarios (estudiante)
- `respuesta_flag_int` - Respuesta del estudiante (flag)
- `es_correcto_int` - Boolean: correcto/incorrecto
- `nro_intento_int` - Número de intento (1, 2, 3...)
- `tiempo_envio_int` - Timestamp Unix (integer) del envío
- `latencia_seg_int` - Tiempo en segundos (nullable)
- `meta_int` - JSON con metadata adicional (nullable)

**Uso en IRT:** ✅ **CRÍTICO** - Datos de entrada para calcular theta (u_i = es_correcto_int)

---

### 7. **`scores`** - Puntajes Finales
**Propósito:** Almacena el puntaje final de un estudiante por evaluación.

**Atributos principales:**
- `id` - Identificador único
- `user_id` - FK a usuarios
- `evaluacion_id` - FK a evaluaciones
- `puntaje` - Puntaje obtenido (decimal)
- `porcentaje` - Porcentaje obtenido (decimal)
- `calculo_meta` - JSON con metadata completa del cálculo IRT

**Uso en IRT:** ✅ **CRÍTICO** - Contiene `calculo_meta` con:
  - `seed_logistica`: p_empirico, logit_p, iter, convergio
  - `irt`: theta_cat, theta_global, nivel, iter, convergio, fallback_reason

**Atributo clave:** `calculo_meta` almacena toda la información del proceso IRT

---

### 8. **`est_habilidades`** - Habilidades Estimadas (Theta)
**Propósito:** Almacena el theta calculado por Newton-Raphson para cada estudiante.

**Atributos principales:**
- `id_esth` - Identificador único
- `user_id` - FK a usuarios (unique, 1:1)
- `theta_global` - Theta global (promedio de todas las categorías)
- `theta_por_cat` - JSON con theta por categoría: `{"WEB":0.6, "CRYPTO":0.4, ...}`

**Uso en IRT:** ✅ **CRÍTICO** - Almacena el resultado final del cálculo IRT

**Ejemplo de `theta_por_cat`:**
```json
{
  "1": 0.6689,  // ID de categoría WEB
  "2": 0.5234,  // ID de categoría CRYPTO
  "3": -0.1234, // ID de categoría FORENS
  "4": 0.7890   // ID de categoría STEGO
}
```

---

### 9. **`irt_parametros`** - Parámetros IRT 2PL
**Propósito:** Almacena los parámetros IRT (a, b) de cada evaluación.

**Atributos principales:**
- `id_irt` - Identificador único
- `evaluacion_id` - FK a evaluaciones (unique, 1:1)
- `a_discriminacion` - Parámetro de discriminación (default: 1.0)
- `b_dificultad` - Parámetro de dificultad (mapeado desde dificultad_id)
- `c_azar` - ❌ **NO USADO** - Parámetro de azar (nullable, para IRT 3PL, no implementado actualmente)

**Uso en IRT:** ✅ **CRÍTICO** - Parámetros necesarios para calcular theta usando IRT 2PL

**Mapeo de dificultad → b_dificultad:**
- Dificultad 1 (1_facil) → b = -2.0
- Dificultad 2 (2_baja) → b = -1.0
- Dificultad 3 (3_media) → b = 0.0
- Dificultad 4 (4_alta) → b = 1.0
- Dificultad 5 (5_dificil) → b = 2.0

---

### 10. **`transitions`** - Transiciones de Estado Markov
**Propósito:** Almacena las transiciones de estado (bajo → medio → alto) para cadenas de Markov.

**Atributos principales:**
- `id` - Identificador único
- `user_id` - FK a usuarios
- `categoria_id` - FK a categorías
- `estado_origen` - Estado anterior ('bajo', 'medio', 'alto')
- `estado_destino` - Estado nuevo ('bajo', 'medio', 'alto')
- `created_at` - Timestamp de la transición

**Uso en IRT:** ✅ **NECESARIO** - Para análisis de progresión de estudiantes y asignación adaptativa

**Estados posibles:**
- `bajo`: theta < -0.5
- `medio`: -0.5 ≤ theta < 0.5
- `alto`: theta ≥ 0.5

---

## ⚠️ TABLAS COMPLEMENTARIAS (No críticas para IRT)

### 11. **`rendimientos`** - Rendimiento EMA (Media Móvil Exponencial)
**Propósito:** Almacena el rendimiento tradicional usando EMA (Exponential Moving Average).

**Atributos principales:**
- `id` - Identificador único
- `user_id` - FK a usuarios
- `categoria_id` - FK a categorías
- `r_ema` - Valor EMA (0.0 a 1.0)
- `muestras` - Número de muestras usadas

**Uso en IRT:** ⚠️ **COMPLEMENTARIO** - Método tradicional de scoring, se mantiene por compatibilidad pero IRT es más preciso

**Nota:** Esta tabla se usa para el cálculo tradicional de scoring (EMA), pero el sistema IRT es más preciso y es el método principal.

---

### 12. **`rankings`** - Rankings de Estudiantes
**Propósito:** Almacena las posiciones de los estudiantes en rankings por período/categoría.

**Atributos principales:**
- `id` - Identificador único
- `user_id` - FK a usuarios
- `periodo_id` - FK a períodos (nullable)
- `skill_id` - FK a categorías (nullable, para ranking por categoría)
- `posicion` - Posición en el ranking
- `puntaje_total` - Puntaje total acumulado

**Uso en IRT:** ⚠️ **COMPLEMENTARIO** - Para mostrar rankings, no necesario para cálculo de theta

**Nota:** Esta tabla se usa para visualización de rankings, pero no es necesaria para el cálculo de theta.

---

## ❌ TABLAS NO USADAS O OBSOLETAS

### 13. **`audit_logs`** - Logs de Auditoría
**Propósito:** Almacena logs de auditoría del sistema.

**Atributos principales:**
- `id` - Identificador único
- `user_id` - FK a usuarios
- `action` - Acción realizada
- `model` - Modelo afectado
- `changes` - JSON con cambios
- `created_at` - Timestamp

**Uso en IRT:** ❌ **NO NECESARIO** - Solo para auditoría, no afecta cálculo de theta

**Recomendación:** Puede eliminarse si no se usa auditoría, pero no afecta el sistema IRT.

---

## 📋 TABLAS DEL SISTEMA (Laravel)

### 14. **`cache`** - Cache del Sistema
**Propósito:** Cache de Laravel.

**Uso en IRT:** ❌ **NO NECESARIO** - Solo para cache, no afecta cálculo de theta

---

### 15. **`jobs`** - Cola de Trabajos
**Propósito:** Cola de trabajos asíncronos de Laravel.

**Uso en IRT:** ❌ **NO NECESARIO** - Solo para trabajos en cola, no afecta cálculo de theta

---

### 16. **`permissions`** - Permisos (Spatie)
**Propósito:** Sistema de permisos y roles.

**Uso en IRT:** ⚠️ **PARCIALMENTE NECESARIO** - Para control de acceso, no afecta cálculo de theta

---

## 📊 RESUMEN POR IMPORTANCIA

### ✅ **CRÍTICAS para IRT:**
1. `users` - Identifica estudiantes
2. `categorias` - Categorías de evaluación
3. `dificultades` - Niveles de dificultad
4. `evaluaciones` - Evaluaciones a resolver
5. `intentos` - Datos de entrada (u_i)
6. `scores` - Puntajes y metadata IRT
7. `est_habilidades` - Theta calculado
8. `irt_parametros` - Parámetros IRT (a, b)
9. `transitions` - Transiciones Markov

### ⚠️ **COMPLEMENTARIAS:**
10. `rendimientos` - EMA tradicional (compatibilidad)
11. `rankings` - Rankings visuales
12. `periodos` - Agrupación temporal

### ❌ **NO NECESARIAS para IRT:**
13. `audit_logs` - Solo auditoría
14. `cache` - Solo cache
15. `jobs` - Solo cola de trabajos

---

## 🔍 FLUJO DE DATOS IRT

```
1. Student intenta resolver evaluación
   ↓
2. Se crea registro en `intentos` (es_correcto_int)
   ↓
3. ScoringService::procesarIntento() ejecuta:
   a) Regresión Logística (semilla de theta)
   b) IRT 2PL con Newton-Raphson (cálculo de theta)
   c) Actualiza `est_habilidades` (theta_global, theta_por_cat)
   d) Guarda metadata en `scores.calculo_meta`
   e) Registra transición en `transitions` (si cambia nivel)
   ↓
4. Sistema clasifica nivel (bajo/medio/alto) basado en theta
   ↓
5. ItemSelectorService asigna evaluaciones adaptativamente
```

---

## 📝 NOTAS IMPORTANTES

### Atributos Clave para IRT:

1. **`intentos.es_correcto_int`** → `u_i` en IRT (0 o 1)
2. **`irt_parametros.a_discriminacion`** → `a_i` en IRT 2PL
3. **`irt_parametros.b_dificultad`** → `b_i` en IRT 2PL
4. **`est_habilidades.theta_global`** → `θ` global calculado
5. **`est_habilidades.theta_por_cat`** → `θ_c` por categoría
6. **`scores.calculo_meta`** → Metadata completa del proceso IRT

### Atributos que NO se usan en IRT:

- `rendimientos.r_ema` - Solo para EMA tradicional (método complementario)
- `rankings.posicion` - Solo para visualización de rankings
- `audit_logs.*` - Solo para auditoría del sistema
- `irt_parametros.c_azar` - ❌ **NO IMPLEMENTADO** - Para IRT 3PL, no usado actualmente (sistema usa IRT 2PL)

---

## 🎯 CONCLUSIÓN PARA EL DOCENTE

**Tablas esenciales para IRT (9):**
- `users`, `categorias`, `dificultades`, `evaluaciones`, `intentos`, `scores`, `est_habilidades`, `irt_parametros`, `transitions`

**Tablas complementarias (3):**
- `rendimientos` (EMA tradicional), `rankings` (visualización), `periodos` (agrupación)

**Tablas no necesarias para IRT:**
- `audit_logs`, `cache`, `jobs` (solo para sistema Laravel)

**El sistema IRT funciona correctamente con las 9 tablas esenciales.**

---

---

## ⚠️ ATRIBUTOS NO USADOS O RESERVADOS

### 1. `irt_parametros.c_azar`
- **Estado:** ❌ **NO USADO**
- **Propósito:** Reservado para IRT 3PL (parámetro de azar)
- **Uso actual:** El sistema usa IRT 2PL, no IRT 3PL
- **Recomendación:** Mantener nullable para futura implementación de IRT 3PL

### 2. `rankings.skill_id`
- **Estado:** ✅ **USADO** (para rankings por categoría)
- **Propósito:** Permite filtrar rankings por categoría específica
- **Uso actual:** Se usa en `RankingService` y `RankingController`

### 3. Atributos eliminados (ya no existen):
- `scores.ema_cat_score` - ❌ Eliminado en migración `update_scores_schema`
- `scores.ema_global_score` - ❌ Eliminado en migración `update_scores_schema`
- `scores.ultimo_correcto_score` - ❌ Eliminado en migración `update_scores_schema`
- `rankings.r_global_rank` - ❌ Eliminado en migración `update_rankings_schema`

**Nota:** Estos atributos fueron eliminados en migraciones de actualización para mantener el esquema limpio.

---

**Última actualización:** 2025-11-04

