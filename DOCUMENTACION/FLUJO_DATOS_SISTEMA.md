# 📊 Flujo de Datos del Sistema: Desde Evaluación hasta Selección Adaptativa

## 🎯 Resumen Ejecutivo

El sistema procesa los resultados de evaluación de un estudiante, calcula su habilidad (theta) usando IRT con Newton-Raphson, determina su nivel (bajo/medio/alto), y luego selecciona evaluaciones adaptativas basadas en una política que combina IRT + Cadenas de Markov.

---

## 🔄 FLUJO COMPLETO PASO A PASO

### **FASE 1: CAPTURA DE RESULTADO** 📥

#### 1.1. Estudiante Envía Intento
**Archivo:** `app/Http/Controllers/IntentoController.php`
**Método:** `store()`

```
Usuario → Envía respuesta (flag) → IntentoController::store()
```

**Datos capturados:**
- `respuesta_flag_int`: Respuesta del estudiante
- `evaluacion_id`: ID de la evaluación
- `user_id`: ID del estudiante
- `tiempo_envio_int`: Timestamp del envío
- `latencia_seg_int`: Tiempo transcurrido desde inicio

**Validaciones:**
- ✅ Verificar ventana de tiempo (fecha_inicio_eval, fecha_fin_eval)
- ✅ Comparar hash MD5 de respuesta con flag_hash_eval
- ✅ Determinar `es_correcto_int` (boolean)

**Resultado:** Se crea registro en tabla `intentos`

---

### **FASE 2: PROCESAMIENTO DEL INTENTO** ⚙️

#### 2.1. Llamada a ScoringService
**Archivo:** `app/Services/ScoringService.php`
**Método:** `procesarIntento()`

```
IntentoController → ScoringService::procesarIntento($intento)
```

**Proceso en transacción de base de datos:**

#### 2.2. Cálculo Tradicional (EMA - Exponential Moving Average)
**Propósito:** Rendimiento histórico por categoría

**Cálculos:**
1. **Penalización por intentos:**
   ```
   penalizacion = max(0.0, 1 - 0.05 * (nro_intento_int - 1))
   ```
   - 1er intento: 1.0 (sin penalización)
   - 2do intento: 0.95
   - 3er intento: 0.90
   - etc.

2. **Bono por tiempo:**
   ```
   delta = tiempo_envio - fecha_inicio
   ventana = fecha_fin - fecha_inicio
   bonoTiempo = (delta / ventana <= 0.8) ? 1.10 : 1.00
   ```
   - Si entrega en primeros 80% del tiempo → bono 10%

3. **Factor de resultado:**
   ```
   factorResultado = es_correcto ? 1.0 : 0.0 * penalizacion * bonoTiempo
   ```

4. **Actualización EMA:**
   ```
   nuevoEma = anterior + alpha * (factorResultado - anterior)
   ```
   - `alpha = 0.20` (factor de suavizado)
   - Se guarda en tabla `rendimientos` (campo `r_ema`)

**Resultado:** 
- `rendimientos.r_ema` actualizado
- `rendimientos.muestras` incrementado

---

### **FASE 3: CÁLCULO IRT CON NEWTON-RAPHSON** 🧮

#### 3.1. Obtención de Estado Anterior (Markov)
**Archivo:** `app/Services/MarkovService.php`
**Método:** `obtenerEstado()`

```
ScoringService → MarkovService::obtenerEstado(userId, categoriaId)
```

**Proceso:**
1. Obtener theta actual del estudiante en la categoría
2. Mapear theta a estado:
   - `theta < -0.5` → **Bajo**
   - `-0.5 ≤ theta < 0.5` → **Medio**
   - `theta ≥ 0.5` → **Alto**

**Resultado:** `estadoAnterior = 'bajo'|'medio'|'alto'|null`

---

#### 3.2. Cálculo de Theta con Newton-Raphson
**Archivo:** `app/Services/IrtService.php`
**Método:** `actualizarThetaDespuesIntento()`

```
ScoringService → IrtService::actualizarThetaDespuesIntento($intento)
```

**Subproceso 3.2.1: Obtener Historial de Intentos**
- Query: Todos los intentos del usuario en esta categoría
- Ordenados por fecha (más antiguos primero)
- Resultado: Collection de `Intento`

**Subproceso 3.2.2: Preparar Datos IRT**
Para cada intento:
1. Obtener evaluación asociada
2. Obtener parámetros IRT:
   - Si existe `irt_parametros`:
     - `a = a_discriminacion`
     - `b = b_dificultad`
   - Si NO existe (valores por defecto):
     - `a = 1.0` (discriminación estándar)
     - `b = mapearDificultadAB(dificultad_id)`
       - dificultad_id 1 → b = -2.0 (fácil)
       - dificultad_id 2 → b = -1.0 (baja)
       - dificultad_id 3 → b = 0.0 (media)
       - dificultad_id 4 → b = 1.0 (alta)
       - dificultad_id 5 → b = 2.0 (difícil)

3. Convertir respuesta:
   - `respuesta = es_correcto_int ? 1 : 0`

**Resultado:** Array de `['a' => float, 'b' => float, 'respuesta' => 0|1]`

**Subproceso 3.2.3: Algoritmo Newton-Raphson**
**Método:** `newtonRaphson($thetaInicial, $datos)`

**Fórmula IRT-2PL:**
```
P(θ) = 1 / (1 + exp(-a * (θ - b)))
```

**Función de Verosimilitud Logarítmica:**
```
L(θ) = Σ [u_i * ln(P_i(θ)) + (1 - u_i) * ln(1 - P_i(θ))]
```

**Primera Derivada (L'):**
```
L'(θ) = Σ [a_i * (u_i - P_i(θ))]
```

**Segunda Derivada (L''):**
```
L''(θ) = -Σ [a_i² * P_i(θ) * (1 - P_i(θ))]
```

**Iteración Newton-Raphson:**
```
θ_new = θ_old - (L'(θ) / L''(θ))
```

**Parámetros:**
- Máximo iteraciones: 50
- Tolerancia: 0.0001
- Rango válido: [-3.0, +3.0]

**Resultado:** `theta` calculado (float)

**Subproceso 3.2.4: Actualizar Theta en Base de Datos**
1. Calcular theta para la categoría específica
2. Calcular theta global (promedio de todas las categorías)
3. Actualizar `est_habilidades`:
   - `theta_global` = promedio
   - `theta_por_cat[categoria_id]` = theta específico

**Resultado:** 
- `est_habilidades.theta_global` actualizado
- `est_habilidades.theta_por_cat` actualizado (JSON)

---

#### 3.3. Obtención de Estado Nuevo (Markov)
**Archivo:** `app/Services/MarkovService.php`
**Método:** `obtenerEstado()`

```
ScoringService → MarkovService::obtenerEstado(userId, categoriaId)
```

**Proceso:**
1. Obtener theta recién calculado
2. Mapear a estado:
   - `theta < -0.5` → **Bajo**
   - `-0.5 ≤ theta < 0.5` → **Medio**
   - `theta ≥ 0.5` → **Alto**

**Resultado:** `estadoNuevo = 'bajo'|'medio'|'alto'|null`

---

#### 3.4. Registro de Transición Markov
**Archivo:** `app/Services/MarkovService.php`
**Método:** `registrarTransicion()`

```
ScoringService → MarkovService::registrarTransicion(userId, categoriaId, estadoAnterior, estadoNuevo)
```

**Condición:** Solo registrar si `estadoAnterior ≠ estadoNuevo`

**Resultado:** 
- Si cambió: Nuevo registro en tabla `transitions`
  - `estado_origen` = estado anterior
  - `estado_destino` = estado nuevo
- Si no cambió: No se registra nada

---

### **FASE 4: GUARDADO DE METADATA** 💾

#### 4.1. Guardar Score con Metadata IRT
**Archivo:** `app/Services/ScoringService.php`

**Datos guardados en `scores`:**

```php
[
    'user_id' => userId,
    'evaluacion_id' => evaluacionId,
    'puntaje' => puntaje calculado,
    'porcentaje' => porcentaje calculado,
    'calculo_meta' => [
        // Datos tradicionales
        'intento_correcto' => boolean,
        'penalizacion' => float,
        'bono_tiempo' => float,
        'factor_resultado' => float,
        'ema' => float,
        'muestras' => int,
        
        // Datos IRT
        'theta' => float,              // Theta calculado
        'nivel' => 'bajo'|'medio'|'alto', // Nivel determinado
        'estado_anterior' => string,   // Estado antes del intento
        'estado_nuevo' => string,      // Estado después del intento
    ]
]
```

**Resultado:** Registro en tabla `scores` con metadata completa

---

### **FASE 5: PREDICCIÓN Y SELECCIÓN ADAPTATIVA** 🎯

#### 5.1. Selección de Categoría (Política Markov+IRT)
**Archivo:** `app/Services/ItemSelectorService.php`
**Método:** `seleccionarCategoria()`

**Cuándo se ejecuta:** Cuando el sistema necesita recomendar una evaluación

**Proceso:**

**5.1.1. Verificar Historial Suficiente**
- Si `totalIntentos < 5`: Usar **exploración ε-greedy** (ε = 0.2)
- Si `totalIntentos ≥ 5`: Usar **política Markov+IRT**

**5.1.2. Política Markov+IRT**
Para cada categoría activa:

**a) Rendimiento (r_c):**
```
r_c = rendimientos.r_ema (último EMA en esa categoría)
```
- Si no existe: `r_c = 0.5` (neutro)

**b) Entropía (H(s_c)):**
```
distribucion = obtenerDistribucionEstados(userId, categoriaId)
H(s_c) = -Σ P(s) * log₂(P(s))
```
- Mide incertidumbre del estado del estudiante
- Mayor entropía = más incierto = más exploración necesaria

**c) Probabilidad de Subir (T_c,i→i+1):**
```
estadoActual = obtenerEstado(userId, categoriaId)
matriz = calcularMatrizTransicion(categoriaId, 'user', userId)
T_subir = probabilidadSubirNivel(matriz, estadoActual)
```
- Probabilidad de mejorar de nivel basado en historial

**d) Score de Categoría:**
```
Score_c = α(1-r_c) + βH(s_c) + γ(1-T_c,i→i+1)
```

**Coeficientes:**
- `α = 0.5` (peso rendimiento)
- `β = 0.3` (peso entropía)
- `γ = 0.2` (peso probabilidad de subir)

**Interpretación:**
- `(1-r_c)`: Mayor si rendimiento bajo → priorizar categorías con bajo rendimiento
- `H(s_c)`: Mayor si incertidumbre alta → priorizar categorías inciertas
- `(1-T_subir)`: Mayor si baja probabilidad de subir → priorizar categorías donde puede mejorar

**Resultado:** `categoriaId` seleccionada (mayor Score_c)

---

#### 5.2. Selección de Evaluación Adaptativa
**Archivo:** `app/Services/ItemSelectorService.php`
**Método:** `seleccionarEvaluacion()`

**Proceso:**

**5.2.1. Obtener Theta del Estudiante**
```
theta = IrtService::calcularTheta(userId, categoriaId)
nivel = IrtService::obtenerNivel(theta)
```

**5.2.2. Mapear Nivel a Dificultad**
```
bajo  → dificultad_id = 1 (fácil) o 2 (baja)
medio → dificultad_id = 3 (media)
alto  → dificultad_id = 4 (alta) o 5 (difícil)
```

**5.2.3. Buscar Evaluaciones Disponibles**
- Filtrar por:
  - `categoria_id` = categoría seleccionada
  - `dificultad_id` = dificultad mapeada
  - `estado_eval` = 2 (publicadas)
  - `periodo_id` = período actual (si aplica)

**5.2.4. Priorización por Información IRT**
Si hay parámetros IRT y theta disponible:

**Información del Ítem:**
```
I_i(θ) = a² * P(θ) * (1 - P(θ))
```

**Criterio:**
- Priorizar evaluaciones donde `P(θ)` esté en rango [0.4, 0.8]
- Esto asegura que la evaluación sea desafiante pero no imposible
- Maximizar `I_i(θ)` (máxima información)

**Si no hay parámetros IRT:**
- Seleccionar evaluación con `b_dificultad` más cercana a `theta`
- O seleccionar aleatoriamente de las disponibles

**Resultado:** `Evaluacion` recomendada

---

### **FASE 6: PRESENTACIÓN DE RECOMENDACIÓN** 📋

#### 6.1. Vista de Demostración
**Archivo:** `app/Http/Controllers/DemostracionController.php`
**Método:** `index()`

**Proceso:**

1. Obtener todos los estudiantes con theta calculado
2. Agrupar por nivel (bajo/medio/alto)
3. Para cada nivel, obtener ejemplos
4. Para cada ejemplo, obtener evaluaciones recomendadas:
   ```
   ItemSelectorService::obtenerEvaluacionesRecomendadas(userId)
   ```
5. Mostrar en vista:
   - Theta del estudiante
   - Nivel determinado
   - Evaluaciones asignadas
   - Razón de asignación

---

## 📊 RESUMEN DEL FLUJO EN TABLAS

| Fase | Entrada | Proceso | Salida | Tabla/Modelo |
|------|---------|---------|--------|--------------|
| **1. Captura** | Respuesta estudiante | Validación | `Intento` | `intentos` |
| **2. EMA** | `Intento` | Cálculo rendimiento | `r_ema` | `rendimientos` |
| **3. IRT** | Historial intentos | Newton-Raphson | `theta` | `est_habilidades` |
| **3. Markov** | `theta` | Mapeo estado | `estado` | `transitions` |
| **4. Metadata** | Todos los datos | Agregación | JSON metadata | `scores.calculo_meta` |
| **5. Selección** | `theta`, `estado`, `r_ema` | Política Markov+IRT | `Evaluacion` | - |
| **6. Presentación** | `Evaluacion` | Vista | Dashboard | - |

---

## 🔍 DATOS CLAVE EN CADA ETAPA

### **Después del Intento:**
1. `intentos.es_correcto_int` → Resultado inmediato
2. `rendimientos.r_ema` → Rendimiento histórico (EMA)
3. `est_habilidades.theta_global` → Habilidad global (IRT)
4. `est_habilidades.theta_por_cat[categoria_id]` → Habilidad por categoría
5. `transitions.estado_destino` → Estado actual (si cambió)
6. `scores.calculo_meta` → Metadata completa (JSON)

### **Para Selección Adaptativa:**
1. `rendimientos.r_ema` → Rendimiento por categoría
2. `est_habilidades.theta_por_cat` → Habilidad por categoría
3. `transitions` (historial) → Distribución de estados
4. `evaluaciones.irt_parametros` → Parámetros IRT (a, b)
5. `evaluaciones.dificultad_id` → Nivel de dificultad

---

## 🎯 PREDICCIÓN DE ÉXITO

### **Cómo se Predice el Éxito:**

1. **Theta (θ):** Indica habilidad del estudiante
   - `θ < -0.5`: Baja habilidad → necesita evaluaciones fáciles
   - `-0.5 ≤ θ < 0.5`: Habilidad media → evaluaciones medias
   - `θ ≥ 0.5`: Alta habilidad → evaluaciones difíciles

2. **Probabilidad de Acierto (P(θ)):**
   ```
   P(θ) = 1 / (1 + exp(-a * (θ - b)))
   ```
   - Si `P(θ) > 0.8`: Muy fácil → no suficiente desafío
   - Si `0.4 ≤ P(θ) ≤ 0.8`: Óptimo → desafío apropiado
   - Si `P(θ) < 0.4`: Muy difícil → puede frustrar

3. **Selección Óptima:**
   - Buscar evaluación donde `P(θ) ≈ 0.6` (zona de desafío óptimo)
   - Esto maximiza el aprendizaje y la información obtenida

---

## 🔄 FLUJO COMPLETO EN DIAGRAMA

```
ESTUDIANTE ENVÍA INTENTO
    ↓
IntentoController::store()
    ↓
Validar respuesta → es_correcto_int
    ↓
Crear registro en 'intentos'
    ↓
ScoringService::procesarIntento()
    ├─→ Cálculo EMA → rendimientos.r_ema
    ├─→ Obtener estado anterior (Markov)
    ├─→ IrtService::actualizarThetaDespuesIntento()
    │   ├─→ Obtener historial intentos
    │   ├─→ Preparar datos IRT (a, b, respuesta)
    │   ├─→ Newton-Raphson → calcular theta
    │   └─→ Actualizar est_habilidades
    ├─→ Obtener estado nuevo (Markov)
    ├─→ Registrar transición (si cambió) → transitions
    └─→ Guardar metadata → scores.calculo_meta
    ↓
SIGUIENTE PASO: Selección Adaptativa
    ↓
ItemSelectorService::seleccionarCategoria()
    ├─→ Calcular Score_c para cada categoría
    │   ├─→ r_c (rendimiento EMA)
    │   ├─→ H(s_c) (entropía Markov)
    │   └─→ T_subir (probabilidad de subir)
    └─→ Seleccionar categoría con mayor Score_c
    ↓
ItemSelectorService::seleccionarEvaluacion()
    ├─→ Obtener theta del estudiante
    ├─→ Mapear nivel → dificultad
    ├─→ Buscar evaluaciones disponibles
    └─→ Priorizar por información IRT (I_i(θ))
    ↓
EVALUACIÓN RECOMENDADA
```

---

## 💡 PUNTOS CLAVE

1. **Cada intento actualiza theta automáticamente** usando Newton-Raphson
2. **Theta se calcula con TODO el historial** de intentos en esa categoría
3. **El nivel se determina automáticamente** basado en theta
4. **Las transiciones Markov se registran** cuando cambia el nivel
5. **La selección adaptativa combina** rendimiento, incertidumbre y probabilidad de progreso
6. **Las evaluaciones se asignan** según el nivel del estudiante para maximizar aprendizaje

---

## 📝 NOTAS TÉCNICAS

- **Newton-Raphson converge** en máximo 50 iteraciones o cuando delta < 0.0001
- **Theta se limita** al rango [-3.0, +3.0] (estándar IRT)
- **Si no hay suficientes datos**, el sistema usa valores por defecto
- **La política Markov+IRT** requiere al menos 5 intentos para funcionar óptimamente
- **Sin historial suficiente**, se usa exploración ε-greedy (20% exploración aleatoria)

---

¡Este es el flujo completo desde la evaluación hasta la selección adaptativa!

