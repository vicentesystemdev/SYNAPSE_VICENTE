# ✅ Resumen: Flujo UI → Motor IRT (CORREGIDO)

## 🎯 Tu Resumen (CORRECTO con ajustes)

### **Flujo:**
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

✅ **Flujo correcto**

---

## 📝 Datos Requeridos (CORREGIDO)

### ❌ **NO incluir estos campos (se obtienen automáticamente):**

```json
{
  "categoria_id": 3,          // ❌ NO se envía - Se obtiene de evaluacion.categoria_id
  "dificultad_id": 4,          // ❌ NO se envía - Se obtiene de evaluacion.dificultad_id
  "nro_intento_int": 2,        // ❌ NO se envía - Se calcula automáticamente
  "es_correcto_int": 1         // ❌ NO se envía - Se calcula del flag_hash
}
```

### ✅ **SÍ incluir estos campos (lo que debe enviar la UI):**

```json
{
  "user_id": 12,                          // ✅ Requerido (o de Auth)
  "evaluacion_id": 45,                     // ✅ Requerido
  "respuesta_flag_int": "flag{demo123}"   // ✅ Requerido (respuesta del usuario)
}
```

### ⚠️ **Opcional:**

```json
{
  "tiempo_envio_int": 1234567890  // ⚠️ Opcional (se calcula si no se envía)
}
```

---

## 🔍 Explicación de los Datos

### **1. `user_id`** ✅
- **Origen:** `Auth::id()` o `request->input('user_id')`
- **Uso:** Identifica al estudiante

### **2. `evaluacion_id`** ✅
- **Origen:** `request->input('evaluacion_id')` o parámetro de ruta
- **Uso:** Identifica la evaluación que se está resolviendo

### **3. `respuesta_flag_int`** ✅
- **Origen:** `request->input('respuesta_flag_int')` o `request->input('respuesta')`
- **Uso:** Respuesta del estudiante (flag)
- **Ejemplo:** `"flag{demo123}"`

### **4. `tiempo_envio_int`** ⚠️
- **Origen:** `request->input('tiempo_envio_int')` o `now()->timestamp`
- **Uso:** Timestamp Unix del envío
- **Nota:** Si no se envía, se calcula automáticamente

---

## 📊 Cómo se Obtienen Automáticamente

### **1. `categoria_id`** - Se obtiene de la evaluación
```php
$evaluacion = Evaluacion::findOrFail($evaluacion_id);
$categoriaId = $evaluacion->categoria_id;  // Se obtiene automáticamente
```

### **2. `dificultad_id`** - Se obtiene de la evaluación
```php
$dificultadId = $evaluacion->dificultad_id;  // Se obtiene automáticamente
```

### **3. `nro_intento_int`** - Se calcula del historial
```php
$nro = Intento::where('user_id', $userId)
    ->where('evaluacion_id', $evaluacion->id_eval)
    ->count() + 1;  // Se calcula automáticamente
```

### **4. `es_correcto_int`** - Se calcula del flag_hash
```php
$esCorrecto = hash('md5', $flagUser) === strtolower($evaluacion->flag_hash_eval);
// Se calcula automáticamente comparando el hash
```

### **5. `latencia_seg_int`** - Se calcula del tiempo
```php
$latencia = $evaluacion->fecha_inicio_eval 
    ? $evaluacion->fecha_inicio_eval->diffInSeconds($now, false) 
    : null;  // Se calcula automáticamente
```

---

## ✅ Resumen Final

### **Datos que la UI debe enviar (mínimos):**
```json
POST /api/intentos
{
  "user_id": 12,
  "evaluacion_id": 45,
  "respuesta_flag_int": "flag{demo123}"
}
```

### **Datos que el sistema calcula automáticamente:**
- ✅ `categoria_id` - De la evaluación
- ✅ `dificultad_id` - De la evaluación
- ✅ `nro_intento_int` - Del historial
- ✅ `es_correcto_int` - Del flag_hash
- ✅ `latencia_seg_int` - Del tiempo
- ✅ `tiempo_envio_int` - Si no se envía, se calcula

### **Respuesta del sistema:**
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
    "titulo": "WEB - 3_media"
  }
}
```

---

## ✅ Conclusión

**Tu resumen es correcto** con estos ajustes:

1. ✅ **Flujo:** Correcto
2. ⚠️ **Datos:** Solo enviar `user_id`, `evaluacion_id`, `respuesta_flag_int`
3. ❌ **NO enviar:** `categoria_id`, `dificultad_id`, `nro_intento_int`, `es_correcto_int` (se obtienen automáticamente)

**El motor está completo y listo para la interfaz de usuario.**

---

**Última actualización:** 2025-11-04

