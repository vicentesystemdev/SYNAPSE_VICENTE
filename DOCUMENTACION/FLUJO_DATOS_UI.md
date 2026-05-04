# 📊 Flujo de Datos: Interfaz de Usuario → Motor IRT

## ✅ Resumen del Flujo (CORRECTO con ajustes)

```
[Interfaz de Evaluación]
  ↓
(Envío de datos del intento)
  ↓
IntentoController::store() o DemoApiController::submitAttempt()
  ↓
ScoringService::procesarIntento()
  ├─ LogisticInitService (regresión → logit_p)
  ├─ IrtService (θ_cat, θ_global)
  ├─ MarkovService (transición de nivel)
  ├─ ItemSelectorService (siguiente evaluación)
  └─ Persistencia en BD
  ↓
[Respuesta JSON → UI]
  → { correcto: true, puntaje: 75, nivel: "Medio", proxima: { eval_id: 46 } }
```

---

## 📝 Datos Requeridos para Plantillas de Evaluación

### ⚠️ **Ajustes Necesarios:**

**Datos que SÍ debe enviar la UI:**
```json
{
  "user_id": 12,              // ✅ Requerido (o de Auth)
  "evaluacion_id": 45,        // ✅ Requerido
  "respuesta_flag_int": "flag{demo123}",  // ✅ Requerido (respuesta del usuario)
  "tiempo_envio_int": 1234567890  // ⚠️ Opcional (se calcula automáticamente si no se envía)
}
```

**Datos que NO debe enviar la UI (se obtienen automáticamente):**
```json
{
  "categoria_id": 3,          // ❌ NO se envía - Se obtiene de evaluacion.categoria_id
  "dificultad_id": 4,         // ❌ NO se envía - Se obtiene de evaluacion.dificultad_id
  "nro_intento_int": 2,       // ❌ NO se envía - Se calcula automáticamente
  "es_correcto_int": 1        // ❌ NO se envía - Se calcula del flag_hash
}
```

---

## 🔍 Explicación Detallada

### **1. Datos que la UI debe enviar:**

#### ✅ **`user_id`**
- **Tipo:** `integer`
- **Obtener de:** `Auth::id()` o `request->input('user_id')`
- **Uso:** Identifica al estudiante

#### ✅ **`evaluacion_id`**
- **Tipo:** `integer`
- **Obtener de:** `request->input('evaluacion_id')` o parámetro de ruta
- **Uso:** Identifica la evaluación que se está resolviendo

#### ✅ **`respuesta_flag_int`**
- **Tipo:** `string`
- **Obtener de:** `request->input('respuesta_flag_int')` o `request->input('respuesta')`
- **Uso:** Respuesta del estudiante (flag)
- **Ejemplo:** `"flag{demo123}"` o `"FLAG{ok}"`

#### ⚠️ **`tiempo_envio_int`** (Opcional)
- **Tipo:** `integer` (timestamp Unix)
- **Obtener de:** `request->input('tiempo_envio_int')` o `now()->timestamp`
- **Uso:** Tiempo de envío del intento
- **Nota:** Si no se envía, se calcula automáticamente con `now()->timestamp`

---

### **2. Datos que se obtienen automáticamente:**

#### ❌ **`categoria_id`** - NO se envía
```php
// Se obtiene de la evaluación
$evaluacion = Evaluacion::findOrFail($evaluacion_id);
$categoriaId = $evaluacion->categoria_id;  // Se obtiene automáticamente
```

#### ❌ **`dificultad_id`** - NO se envía
```php
// Se obtiene de la evaluación
$dificultadId = $evaluacion->dificultad_id;  // Se obtiene automáticamente
```

#### ❌ **`nro_intento_int`** - NO se envía
```php
// Se calcula automáticamente
$nro = Intento::where('user_id', $userId)
    ->where('evaluacion_id', $evaluacion->id_eval)
    ->count() + 1;  // Se calcula automáticamente
```

#### ❌ **`es_correcto_int`** - NO se envía
```php
// Se calcula automáticamente del flag_hash
$esCorrecto = hash('md5', $flagUser) === strtolower($evaluacion->flag_hash_eval);
// Se calcula automáticamente comparando el hash
```

#### ❌ **`latencia_seg_int`** - NO se envía
```php
// Se calcula automáticamente
$latencia = $evaluacion->fecha_inicio_eval 
    ? $evaluacion->fecha_inicio_eval->diffInSeconds($now, false) 
    : null;  // Se calcula automáticamente
```

---

## 📊 Flujo Completo con Datos

### **1. UI envía:**
```json
POST /api/intentos
{
  "user_id": 12,
  "evaluacion_id": 45,
  "respuesta": "flag{demo123}",
  "tiempo_envio": 1234567890  // Opcional
}
```

### **2. Sistema procesa:**
```php
// DemoApiController::submitAttempt()
$evaluacion = Evaluacion::findOrFail(45);
$userId = 12;
$respuesta = "flag{demo123}";

// Se obtienen automáticamente:
$categoriaId = $evaluacion->categoria_id;        // 3
$dificultadId = $evaluacion->dificultad_id;      // 4
$nroIntento = Intento::where(...)->count() + 1;  // 2
$esCorrecto = hash('md5', $respuesta) === $evaluacion->flag_hash_eval;  // true/false
$tiempoEnvio = $request->input('tiempo_envio') ?? now()->timestamp;  // 1234567890

// Se crea el intento:
Intento::create([
    'user_id' => $userId,                    // 12
    'evaluacion_id' => $evaluacion->id_eval, // 45
    'categoria_id' => $categoriaId,          // 3 (automático)
    'dificultad_id' => $dificultadId,        // 4 (automático)
    'respuesta_flag_int' => $respuesta,       // "flag{demo123}"
    'es_correcto_int' => $esCorrecto,        // 1 (automático)
    'nro_intento_int' => $nroIntento,        // 2 (automático)
    'tiempo_envio_int' => $tiempoEnvio,      // 1234567890
    'latencia_seg_int' => $latencia,          // calculado automáticamente
]);
```

### **3. Sistema responde:**
```json
{
  "ok": true,
  "score": {
    "puntaje": 75.0,
    "porcentaje": 75.0,
    "calculo_meta": {
      "intento_correcto": true,
      "penalizacion": 0.95,
      "bono_tiempo": 1.10,
      "factor_resultado": 1.045,
      "seed_logistica": {
        "p_empirico": 0.65,
        "logit_p": 0.619,
        "iter": 4,
        "convergio": true
      },
      "irt": {
        "theta_cat": 0.6234,
        "theta_global": 0.6234,
        "iter": 2,
        "convergio": true,
        "nivel": "medio",
        "estado_anterior": "medio",
        "estado_nuevo": "medio"
      }
    }
  }
}
```

---

## 🎯 Respuesta JSON Mejorada para UI

### **Estructura recomendada:**
```json
{
  "ok": true,
  "correcto": true,
  "puntaje": 75.0,
  "porcentaje": 75.0,
  "nivel": "medio",
  "theta": {
    "categoria": 0.6234,
    "global": 0.6234
  },
  "proxima_evaluacion": {
    "id": 46,
    "titulo": "WEB - 3_media",
    "categoria": "web",
    "dificultad": "media"
  },
  "metadata": {
    "iteraciones_irt": 2,
    "convergio": true,
    "iteraciones_logistica": 4,
    "convergio_logistica": true
  }
}
```

---

## ✅ Checklist para Plantillas de Evaluación

### **Datos mínimos requeridos:**
- [x] `user_id` - Identificador del estudiante
- [x] `evaluacion_id` - Identificador de la evaluación
- [x] `respuesta_flag_int` - Respuesta del estudiante (flag)

### **Datos opcionales:**
- [ ] `tiempo_envio_int` - Timestamp Unix (se calcula si no se envía)

### **Datos que NO se deben enviar:**
- [ ] `categoria_id` - Se obtiene de la evaluación
- [ ] `dificultad_id` - Se obtiene de la evaluación
- [ ] `nro_intento_int` - Se calcula automáticamente
- [ ] `es_correcto_int` - Se calcula del flag_hash
- [ ] `latencia_seg_int` - Se calcula automáticamente

---

## 📝 Notas Finales

### **Para el Frontend:**

1. **Solo necesitas enviar 3 datos:**
   - `user_id` (o usar Auth)
   - `evaluacion_id`
   - `respuesta_flag_int` (respuesta del usuario)

2. **El sistema calcula automáticamente:**
   - Categoría y dificultad (de la evaluación)
   - Número de intento (del historial)
   - Si es correcto (del flag_hash)
   - Tiempo de envío (si no se envía)

3. **La respuesta incluye:**
   - Puntaje y porcentaje
   - Nivel (bajo/medio/alto)
   - Theta (por categoría y global)
   - Próxima evaluación recomendada
   - Metadata completa del cálculo

---

**Última actualización:** 2025-11-04
**Estado:** ✅ Flujo verificado y correcto

