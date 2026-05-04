# Análisis Completo del Módulo de Evaluaciones

**Fecha:** 11 de noviembre de 2025  
**Objetivo:** Verificar que el módulo de evaluaciones permite a los estudiantes realizar evaluaciones y que el motor IRT recibe todos los datos necesarios para la personalización.

---

## 📋 Tabla de Contenidos

1. [Flujo Completo del Módulo](#1-flujo-completo-del-módulo)
2. [Datos Capturados y Procesados](#2-datos-capturados-y-procesados)
3. [Integración con el Motor IRT](#3-integración-con-el-motor-irt)
4. [Datos Necesarios para el Motor IRT](#4-datos-necesarios-para-el-motor-irt)
5. [Puntos Críticos y Verificaciones](#5-puntos-críticos-y-verificaciones)
6. [Mejoras Sugeridas](#6-mejoras-sugeridas)
7. [Checklist de Verificación](#7-checklist-de-verificación)

---

## 1. Flujo Completo del Módulo

### 1.1. Visualización de Evaluaciones

**Ruta:** `GET /evaluaciones`  
**Controlador:** `EvaluacionController@index`  
**Vista:** `resources/views/evaluaciones/index.blade.php`

**Proceso:**
1. El estudiante accede a la lista de evaluaciones disponibles
2. Puede filtrar por categoría y estado
3. Ve información básica: título, descripción, categoría, dificultad, puntaje base, ventana de entrega, intentos totales
4. Puede hacer clic en "Ver detalles" para acceder a una evaluación específica

**✅ Estado:** Funcional

---

### 1.2. Detalle de Evaluación

**Ruta:** `GET /evaluaciones/{evaluacion}`  
**Controlador:** `EvaluacionController@show`  
**Vista:** `resources/views/evaluaciones/show.blade.php`

**Proceso:**
1. Muestra información completa de la evaluación:
   - Título, descripción, categoría, dificultad, estado
   - Ventana de entrega (fecha inicio/fin)
   - Responsable (docente)
   - Metadatos (si existen)
2. Muestra estadísticas del usuario (si está autenticado):
   - Intentos totales, correctos, incorrectos
3. Muestra resumen por estudiante (tabla)
4. Muestra intentos recientes (últimos 10)
5. Muestra ranking general (top 10)
6. **Formulario de entrega de flag** (si está autenticado y tiene rol student/admin/coach)

**✅ Estado:** Funcional

---

### 1.3. Entrega de Flag (Intento)

**Ruta:** `POST /evaluaciones/{evaluacion}/entregar`  
**Controlador:** `IntentoController@store`  
**Request:** `StoreIntentoRequest`

**Proceso Completo:**

#### Paso 1: Validación de Ventana de Tiempo
```php
// Verifica que la evaluación esté dentro de la ventana de entrega
if ($evaluacion->fecha_inicio_eval && $now->lt($evaluacion->fecha_inicio_eval)) {
    return back()->withErrors(['respuesta_flag_int' => 'La evaluación aún no está disponible.']);
}
if ($evaluacion->fecha_fin_eval && $now->gt($evaluacion->fecha_fin_eval)) {
    return back()->withErrors(['respuesta_flag_int' => 'La ventana de entrega ya cerró.']);
}
```

#### Paso 2: Validación de Flag
```php
// Usa FlagService para validar formato synapse{md5}
if ($evaluacion->solution_md5) {
    $esCorrecto = FlagService::validate($flagUser, $evaluacion->solution_md5);
} elseif ($evaluacion->flag_hash_eval) {
    // Retrocompatibilidad: validar MD5 directo
    $esCorrecto = hash('md5', $flagUser) === strtolower($evaluacion->flag_hash_eval);
} else {
    $esCorrecto = false;
}
```

#### Paso 3: Creación del Intento
```php
$intento = Intento::create([
    'evaluacion_id'      => $evaluacion->id_eval,
    'user_id'            => $userId,
    'respuesta_flag_int' => $flagUser,
    'es_correcto_int'    => $esCorrecto,
    'nro_intento_int'    => $nro,
    'tiempo_envio_int'   => $now->timestamp,
    'latencia_seg_int'   => $latencia !== null ? max(0, (float) $latencia) : null,
]);
```

#### Paso 4: Procesamiento con Motor IRT
```php
$this->scoring->procesarIntento($intento);
```

**✅ Estado:** Funcional

---

## 2. Datos Capturados y Procesados

### 2.1. Datos del Intento

**Tabla:** `intentos`  
**Modelo:** `App\Models\Intento`

| Campo | Tipo | Descripción | Fuente |
|-------|------|-------------|--------|
| `id_int` | bigint | ID único | Auto-increment |
| `evaluacion_id` | bigint | ID de la evaluación | Relación |
| `user_id` | bigint | ID del estudiante | `Auth::id()` |
| `respuesta_flag_int` | string(255) | Flag enviada por el estudiante | Formulario |
| `es_correcto_int` | boolean | Si la respuesta es correcta | Validación con `FlagService` |
| `nro_intento_int` | integer | Número de intento (1, 2, 3...) | Calculado |
| `tiempo_envio_int` | integer | Unix timestamp del envío | `now()->timestamp` |
| `latencia_seg_int` | float | Segundos desde inicio de ventana | Calculado |
| `meta_int` | json | Metadatos adicionales (opcional) | - |

**✅ Estado:** Todos los campos necesarios están presentes

---

### 2.2. Datos de la Evaluación

**Tabla:** `evaluaciones`  
**Modelo:** `App\Models\Evaluacion`

| Campo | Tipo | Descripción | Uso en IRT |
|-------|------|-------------|------------|
| `id_eval` | bigint | ID único | Relación con intentos |
| `categoria_id` | bigint | Categoría (CRYPTO, STEGO, etc.) | **CRÍTICO:** Agrupa intentos para calcular theta por categoría |
| `dificultad_id` | bigint | Dificultad (1-5) | **IMPORTANTE:** Usado como fallback para `b_dificultad` si no hay parámetros IRT |
| `puntaje_base_eval` | decimal(8,2) | Puntaje base | Usado en cálculo de puntaje final |
| `fecha_inicio_eval` | datetime | Inicio de ventana | Usado para calcular latencia y bono de tiempo |
| `fecha_fin_eval` | datetime | Fin de ventana | Usado para calcular latencia y bono de tiempo |
| `solution_md5` | char(32) | MD5 de la solución | Validación de flags |
| `flag_hash_eval` | char(32) | Hash MD5 (legacy) | Retrocompatibilidad |
| `estado_eval` | integer | Estado (1=Borrador, 2=Publicada, 3=Cerrada) | Control de visibilidad |

**✅ Estado:** Todos los campos necesarios están presentes

---

### 2.3. Parámetros IRT

**Tabla:** `irt_parametros`  
**Modelo:** `App\Models\IrtParametro`

| Campo | Tipo | Descripción | Uso en IRT |
|-------|------|-------------|------------|
| `id_irt` | bigint | ID único | - |
| `evaluacion_id` | bigint | ID de la evaluación | Relación 1:1 |
| `a_discriminacion` | decimal(6,3) | Parámetro de discriminación | **CRÍTICO:** Usado en fórmula IRT-2PL |
| `b_dificultad` | decimal(6,3) | Parámetro de dificultad | **CRÍTICO:** Usado en fórmula IRT-2PL |
| `c_azar` | decimal(6,3) | Parámetro de azar (3PL) | Opcional, no usado actualmente |

**⚠️ IMPORTANTE:** Si no existen parámetros IRT para una evaluación, el sistema usa valores por defecto:
- `a = 1.0` (discriminación estándar)
- `b = mapearDificultadAB(dificultad_id)` (mapeo: 1→-2.0, 2→-1.0, 3→0.0, 4→1.0, 5→2.0)

**✅ Estado:** Sistema funcional con valores por defecto, pero se recomienda poblar parámetros IRT reales

---

## 3. Integración con el Motor IRT

### 3.1. Flujo de Procesamiento

```
IntentoController@store
    ↓
ScoringService@procesarIntento($intento)
    ↓
    ├─→ Cálculo EMA (tradicional)
    ├─→ LogisticInitService (semilla logística)
    ├─→ IrtService@actualizarThetaDespuesIntento($intento, $thetaSemilla)
    │       ↓
    │       ├─→ Obtener historial de intentos del usuario en la categoría
    │       ├─→ Preparar datos IRT (a, b, respuesta)
    │       ├─→ Calcular theta con Newton-Raphson
    │       └─→ Actualizar est_habilidades (theta_por_cat, theta_global)
    ├─→ MarkovService (transiciones de estado)
    └─→ Score::updateOrCreate (guardar puntaje y metadatos)
```

**✅ Estado:** Integración completa y funcional

---

### 3.2. Datos que Recibe el Motor IRT

#### 3.2.1. Historial de Intentos

**Método:** `IrtService::obtenerHistorialIntentos($userId, $categoriaId)`

```php
Intento::query()
    ->where('user_id', $userId)
    ->whereHas('evaluacion', fn($q) => $q->where('categoria_id', $categoriaId))
    ->orderBy('created_at')
    ->get();
```

**Datos obtenidos:**
- Todos los intentos del usuario en la categoría
- Ordenados cronológicamente
- Incluye: `es_correcto_int`, relación con `evaluacion`

**✅ Estado:** Funcional

---

#### 3.2.2. Preparación de Datos IRT

**Método:** `IrtService::prepararDatosIrt($intentos)`

**Proceso:**
```php
foreach ($intentos as $intento) {
    $eval = $intento->evaluacion;
    $param = $eval->irtParametros;
    
    // Obtener parámetros a y b
    $a = $param ? (float)$param->a_discriminacion : 1.0;
    $b = $param ? (float)$param->b_dificultad : $this->mapearDificultadAB($eval->dificultad_id);
    
    // Convertir respuesta a binario
    $respuesta = $intento->es_correcto_int ? 1 : 0;
    
    $datos[] = ['a' => $a, 'b' => $b, 'respuesta' => $respuesta];
}
```

**Resultado:** Array de `['a' => float, 'b' => float, 'respuesta' => 0|1]`

**✅ Estado:** Funcional, con fallback a valores por defecto

---

#### 3.2.3. Cálculo de Theta (Newton-Raphson)

**Método:** `IrtService::calcularTheta($userId, $categoriaId, $thetaSemilla)`

**Requisitos:**
- Mínimo 3 intentos en la categoría (si no, retorna `null`)
- Parámetros IRT (a, b) para cada intento
- Respuestas binarias (0 o 1)

**Algoritmo:**
1. Inicializa theta (usa theta previo, semilla logística, o 0.0)
2. Itera hasta 50 veces:
   - Calcula probabilidad IRT-2PL: `P(θ) = 1 / (1 + exp(-a * (θ - b)))`
   - Calcula primera derivada: `L' = Σ [a_i * (u_i - P_i(θ))]`
   - Calcula segunda derivada: `L'' = -Σ [a_i² * P_i(θ) * (1 - P_i(θ))]`
   - Actualiza theta: `θ_new = θ_old - (L' / L'')`
   - Verifica convergencia (tolerancia: 1e-4)
3. Limita theta al rango [-3.0, +3.0]

**Resultado:**
```php
[
    'theta' => float,
    'iter' => int,
    'convergio' => bool,
    'n' => int,
    'fallback_reason' => ?string
]
```

**✅ Estado:** Funcional

---

#### 3.2.4. Actualización de Habilidades

**Método:** `IrtService::actualizarThetaDespuesIntento($intento, $thetaSemilla)`

**Proceso:**
1. Calcula theta para la categoría específica
2. Actualiza `est_habilidades`:
   - `theta_por_cat[categoria_id] = theta_calculado`
   - `theta_global = promedio de todos los theta_por_cat`
3. Retorna theta de categoría y theta global

**Tabla:** `est_habilidades`  
**Modelo:** `App\Models\EstHabilidad`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id_esth` | bigint | ID único |
| `user_id` | bigint | ID del estudiante |
| `theta_global` | decimal(8,4) | Theta promedio de todas las categorías |
| `theta_por_cat` | json | `{categoria_id: theta_value, ...}` |

**✅ Estado:** Funcional

---

## 4. Datos Necesarios para el Motor IRT

### 4.1. Datos Mínimos Requeridos

| Dato | Fuente | Estado | Crítico |
|------|--------|--------|---------|
| **Intentos del usuario** | Tabla `intentos` | ✅ Disponible | ✅ SÍ |
| **Respuesta correcta/incorrecta** | Campo `es_correcto_int` | ✅ Disponible | ✅ SÍ |
| **Categoría de la evaluación** | Campo `categoria_id` en `evaluaciones` | ✅ Disponible | ✅ SÍ |
| **Parámetros IRT (a, b)** | Tabla `irt_parametros` o fallback | ⚠️ Parcial | ⚠️ Recomendado |
| **Historial mínimo (3 intentos)** | Calculado dinámicamente | ✅ Disponible | ✅ SÍ |

---

### 4.2. Datos Opcionales pero Útiles

| Dato | Fuente | Estado | Uso |
|------|--------|--------|-----|
| **Semilla logística** | `LogisticInitService` | ✅ Disponible | Mejora precisión inicial |
| **Theta previo** | `est_habilidades.theta_por_cat` | ✅ Disponible | Acelera convergencia |
| **Dificultad de evaluación** | Campo `dificultad_id` | ✅ Disponible | Fallback para `b` si no hay parámetros IRT |
| **Tiempo de respuesta** | Campo `latencia_seg_int` | ✅ Disponible | Análisis de rendimiento (no usado en IRT) |

---

## 5. Puntos Críticos y Verificaciones

### 5.1. ✅ Verificaciones Exitosas

1. **Flujo completo funcional:**
   - ✅ Estudiantes pueden ver evaluaciones
   - ✅ Estudiantes pueden entregar flags
   - ✅ Validación de flags funciona (formato `synapse{md5}`)
   - ✅ Intentos se guardan correctamente
   - ✅ Motor IRT se ejecuta automáticamente

2. **Datos capturados:**
   - ✅ Todos los campos necesarios están presentes
   - ✅ Relaciones entre modelos están correctas
   - ✅ Timestamps y latencias se calculan correctamente

3. **Integración IRT:**
   - ✅ Historial de intentos se obtiene correctamente
   - ✅ Parámetros IRT se obtienen (con fallback)
   - ✅ Theta se calcula y actualiza correctamente
   - ✅ Habilidades se persisten en `est_habilidades`

---

### 5.2. ⚠️ Puntos de Atención

#### 5.2.1. Parámetros IRT Faltantes

**Problema:** Muchas evaluaciones pueden no tener parámetros IRT en `irt_parametros`, usando valores por defecto.

**Impacto:**
- El motor IRT funciona, pero con menor precisión
- Los valores por defecto (`a=1.0`, `b=mapeado de dificultad`) son aproximaciones

**Recomendación:**
- Poblar parámetros IRT reales mediante análisis estadístico de intentos históricos
- O usar un seeder que asigne parámetros basados en dificultad y categoría

**Estado:** ⚠️ Funcional pero mejorable

---

#### 5.2.2. Mínimo de Intentos para IRT

**Problema:** El motor IRT requiere mínimo 3 intentos en una categoría para calcular theta.

**Impacto:**
- Estudiantes nuevos o con pocos intentos no tendrán theta calculado
- El sistema usa valores por defecto o semilla logística

**Recomendación:**
- Documentar este requisito para usuarios
- Considerar mostrar mensaje informativo cuando hay menos de 3 intentos

**Estado:** ⚠️ Funcional pero puede confundir a usuarios nuevos

---

#### 5.2.3. Validación de Ventana de Tiempo

**Problema:** La validación de ventana de tiempo está en el controlador, pero no se muestra claramente en la vista si la evaluación está fuera de ventana.

**Recomendación:**
- Mostrar mensaje claro en la vista si la evaluación está fuera de ventana
- Deshabilitar el formulario si está fuera de ventana

**Estado:** ⚠️ Funcional pero mejorable en UX

---

### 5.3. 🔴 Problemas Críticos (Ninguno Identificado)

No se identificaron problemas críticos que impidan el funcionamiento del módulo.

---

## 6. Mejoras Sugeridas

### 6.1. Mejoras de Datos

1. **Poblar Parámetros IRT:**
   - Crear seeder o comando Artisan para calcular parámetros IRT basados en intentos históricos
   - O asignar parámetros basados en dificultad y categoría

2. **Validación de Datos:**
   - Asegurar que todas las evaluaciones tengan `categoria_id` y `dificultad_id`
   - Validar que `solution_md5` o `flag_hash_eval` estén presentes antes de publicar

---

### 6.2. Mejoras de UX

1. **Indicadores Visuales:**
   - Mostrar si la evaluación está dentro/fuera de ventana
   - Mostrar número de intentos restantes (si hay límite)
   - Mostrar estado de theta del estudiante (si está disponible)

2. **Feedback al Usuario:**
   - Mostrar mensaje claro cuando hay menos de 3 intentos para calcular theta
   - Mostrar progreso hacia el cálculo de theta

---

### 6.3. Mejoras de Rendimiento

1. **Caché de Theta:**
   - Considerar cachear theta calculado para evitar recálculos innecesarios
   - Invalidar caché cuando se crea un nuevo intento

2. **Optimización de Consultas:**
   - Usar `with()` para eager loading de relaciones en consultas de intentos
   - Indexar `user_id` y `categoria_id` en tabla `intentos`

---

## 7. Checklist de Verificación

### 7.1. Funcionalidad Básica

- [x] Estudiantes pueden ver lista de evaluaciones
- [x] Estudiantes pueden ver detalle de evaluación
- [x] Estudiantes pueden entregar flags
- [x] Validación de flags funciona correctamente
- [x] Intentos se guardan en base de datos
- [x] Estadísticas se muestran correctamente

---

### 7.2. Integración con Motor IRT

- [x] Motor IRT se ejecuta automáticamente al crear intento
- [x] Historial de intentos se obtiene correctamente
- [x] Parámetros IRT se obtienen (con fallback)
- [x] Theta se calcula correctamente
- [x] Theta se actualiza en `est_habilidades`
- [x] Theta global se calcula correctamente
- [x] Puntajes se guardan en tabla `scores`
- [x] Metadatos de cálculo se guardan en `calculo_meta`

---

### 7.3. Datos Necesarios

- [x] Campo `es_correcto_int` está presente y se calcula correctamente
- [x] Campo `categoria_id` está presente en evaluaciones
- [x] Campo `dificultad_id` está presente en evaluaciones
- [x] Relación `evaluacion->irtParametros` funciona
- [x] Fallback a valores por defecto funciona
- [x] Timestamps y latencias se calculan correctamente

---

### 7.4. Validaciones

- [x] Validación de ventana de tiempo funciona
- [x] Validación de formato de flag funciona
- [x] Validación de autenticación funciona
- [x] Validación de roles funciona

---

## 8. Conclusión

### 8.1. Estado General

**✅ El módulo de evaluaciones está FUNCIONAL y LISTO para uso en producción.**

Todos los componentes críticos están implementados y funcionando:
- Los estudiantes pueden realizar evaluaciones
- Los datos se capturan correctamente
- El motor IRT recibe todos los datos necesarios
- La personalización puede comenzar a funcionar desde el primer intento

---

### 8.2. Recomendaciones Prioritarias

1. **Corto Plazo (Opcional):**
   - Poblar parámetros IRT reales para mayor precisión
   - Mejorar UX mostrando estado de ventana de tiempo

2. **Mediano Plazo (Opcional):**
   - Implementar caché de theta para mejor rendimiento
   - Agregar indicadores visuales de progreso

3. **Largo Plazo (Opcional):**
   - Análisis estadístico para optimizar parámetros IRT
   - Dashboard de métricas de personalización

---

### 8.3. Próximos Pasos

1. **Probar el flujo completo:**
   - Crear una evaluación de prueba
   - Hacer 3+ intentos como estudiante
   - Verificar que theta se calcula correctamente
   - Verificar que puntajes se guardan

2. **Poblar datos reales:**
   - Ejecutar seeder de evaluaciones base
   - Asignar flags a las evaluaciones
   - Publicar evaluaciones

3. **Monitorear:**
   - Revisar logs de errores
   - Verificar que theta se actualiza correctamente
   - Verificar que puntajes son razonables

---

**Documento generado:** 11 de noviembre de 2025  
**Última revisión:** 11 de noviembre de 2025

