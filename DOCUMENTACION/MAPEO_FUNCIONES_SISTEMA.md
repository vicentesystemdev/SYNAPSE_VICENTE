# 🗺️ Mapeo Completo de Funciones del Sistema IRT

## 📋 Desde el Inicio hasta el Fin - Ubicación de Cada Función

---

## 🚀 **INICIO: Recepción del Intento**

### **1. Entrada de Datos (Interfaz de Usuario)**

**Ubicación:** `app/Http/Controllers/IntentoController.php`

**Función:**
```php
public function store(StoreIntentoRequest $request, Evaluacion $evaluacion): RedirectResponse
```

**Líneas:** 18-52

**Qué hace:**
- Recibe la respuesta del estudiante (`respuesta_flag_int`)
- Valida ventana de tiempo de la evaluación
- Calcula si es correcto comparando hash: `hash('md5', $flagUser) === $evaluacion->flag_hash_eval`
- Calcula número de intento: `count() + 1`
- Calcula latencia en segundos
- Crea el registro `Intento` en la BD
- Llama a `ScoringService::procesarIntento()`

**Datos de entrada:**
- `evaluacion_id` (parámetro de ruta)
- `respuesta_flag_int` (de request)
- `user_id` (de Auth)

**Datos de salida:**
- `Intento` creado en BD
- Redirección con mensaje de éxito/error

---

### **2. API Endpoint (Alternativa)**

**Ubicación:** `app/Http/Controllers/Api/DemoApiController.php`

**Función:**
```php
public function submitAttempt(Request $request): JsonResponse
```

**Líneas:** 53-97

**Qué hace:**
- Similar a `IntentoController::store()` pero retorna JSON
- Valida datos de entrada
- Crea `Intento`
- Llama a `ScoringService::procesarIntento()`
- Retorna score con metadata IRT completa

---

## ⚙️ **PROCESAMIENTO: Pipeline Principal**

### **3. Servicio Principal de Scoring**

**Ubicación:** `app/Services/ScoringService.php`

**Función:**
```php
public function procesarIntento(Intento $intento): void
```

**Líneas:** 23-108

**Qué hace:**
- **Orquesta todo el pipeline** de procesamiento
- Ejecuta en transacción de BD
- Llama a todos los servicios en orden:
  1. EMA (tradicional)
  2. `LogisticInitService::estimarProbabilidadEmpirica()`
  3. `IrtService::actualizarThetaDespuesIntento()`
  4. `MarkovService::registrarTransicion()`
  5. `RankingService::recalcForPeriodo()`
- Guarda metadata completa en `scores.calculo_meta`

**Flujo interno:**
```
1. Obtener evaluación
2. Calcular EMA (tradicional)
3. Calcular semilla logística
4. Calcular theta IRT
5. Registrar transición Markov
6. Guardar score con metadata
7. Recalcular ranking
```

---

## 📊 **CÁLCULO EMA (Tradicional)**

### **4. Cálculo de Rendimiento EMA**

**Ubicación:** `app/Services/ScoringService.php`

**Función:** Dentro de `procesarIntento()` (líneas 34-56)

**Qué hace:**
- Calcula penalización por múltiples intentos
- Calcula bono por tiempo
- Calcula factor resultado: `(correcto ? 1.0 : 0.0) * penalizacion * bonoTiempo`
- Actualiza EMA: `EMA_nuevo = EMA_prev + α * (factor_resultado - EMA_prev)`
- Guarda en tabla `rendimientos`

**Fórmula:**
```php
$nuevoEma = $emaPrev + $this->alpha * ($factorResultado - $emaPrev);
```

---

## 🔢 **REGRESIÓN LOGÍSTICA (Semilla de Theta)**

### **5. Servicio de Regresión Logística**

**Ubicación:** `app/Services/LogisticInitService.php`

**Función:**
```php
public function estimarProbabilidadEmpirica(int $userId, int $categoriaId): ?array
```

**Líneas:** 19-123

**Qué hace:**
1. Obtiene historial de intentos del estudiante en la categoría
2. Construye pares `(x_i, u_i)` donde:
   - `x_i` = índice temporal (1, 2, 3, ..., n)
   - `u_i` = resultado binario (0 o 1)
3. Normaliza `x` para estabilidad numérica
4. Ajusta `β₀` y `β₁` usando **Newton-Raphson**
5. Calcula `p_empirico` = promedio de probabilidades
6. Calcula `logit_p` = `log(p/(1-p))` (semilla de theta)

**Fórmula implementada:**
```
logit(p) = β₀ + β₁(índice_temporal)
```

**Newton-Raphson:**
- Gradiente: `g = Σ(u_i - p_i)`
- Hessiano: `H = -Σ(p_i * (1-p_i))`
- Actualización: `β ← β - H^{-1} * g`

**Retorna:**
```php
[
    'p_empirico' => float,
    'logit_p' => float,  // Semilla de theta
    'iter' => int,
    'convergio' => bool,
    'beta' => [β₀, β₁],
    'n' => int,
    'loglik' => float
]
```

**Llamada desde:** `ScoringService::procesarIntento()` (línea 63)

---

## 🎯 **IRT 2PL (Cálculo de Theta)**

### **6. Servicio IRT Principal**

**Ubicación:** `app/Services/IrtService.php`

**Función principal:**
```php
public function calcularTheta(int $userId, int $categoriaId, ?float $thetaSemilla = null): ?array
```

**Líneas:** 24-83

**Qué hace:**
1. Obtiene historial de intentos del estudiante en la categoría
2. Prepara datos IRT: `(u_i, a_i, b_i)` para cada intento
3. Usa `thetaSemilla` (logit_p) como punto inicial
4. Calcula theta usando **Newton-Raphson** con IRT 2PL
5. Retorna theta, iteraciones, convergencia

**Fórmula IRT 2PL:**
```
P_i(θ) = 1 / (1 + exp(-a_i * (θ - b_i)))
```

**Newton-Raphson:**
- Primera derivada: `L'(θ) = Σ a_i * (u_i - P_i)`
- Segunda derivada: `L''(θ) = -Σ a_i² * P_i * (1 - P_i)`
- Actualización: `θ ← θ - L'/L''`

**Retorna:**
```php
[
    'theta' => float,
    'iter' => int,
    'convergio' => bool,
    'n' => int,
    'fallback_reason' => ?string
]
```

---

### **7. Actualización de Theta después del Intento**

**Ubicación:** `app/Services/IrtService.php`

**Función:**
```php
public function actualizarThetaDespuesIntento(Intento $intento, ?float $thetaSemilla = null): array
```

**Líneas:** 106-149

**Qué hace:**
1. Obtiene `user_id` y `categoria_id` del intento
2. Llama a `calcularTheta()` con semilla
3. Actualiza `est_habilidades`:
   - `theta_por_cat[categoriaId]` = theta calculado
   - `theta_global` = promedio de todas las categorías
4. Retorna metadata completa

**Retorna:**
```php
[
    'thetaCat' => ?float,
    'thetaGlobal' => ?float,
    'iter' => int,
    'convergio' => bool,
    'fallback_reason' => ?string
]
```

**Llamada desde:** `ScoringService::procesarIntento()` (línea 69)

---

### **8. Cálculo de Theta Global**

**Ubicación:** `app/Services/IrtService.php`

**Función:**
```php
public function calcularThetaGlobal(int $userId): ?float
```

**Líneas:** 89-99

**Qué hace:**
- Calcula theta global como promedio simple de `theta_por_cat`
- Filtra valores nulos
- Retorna promedio o null si no hay datos

**Llamada desde:** `actualizarThetaDespuesIntento()` (línea 130)

---

### **9. Obtención de Nivel**

**Ubicación:** `app/Services/IrtService.php`

**Función:**
```php
public function obtenerNivel(float $theta): string
```

**Líneas:** 151-158

**Qué hace:**
- Categoriza theta en nivel:
  - `theta < -0.5` → `'bajo'`
  - `-0.5 ≤ theta < 0.5` → `'medio'`
  - `theta ≥ 0.5` → `'alto'`

**Retorna:** `'bajo'`, `'medio'` o `'alto'`

**Llamada desde:** `ScoringService::procesarIntento()` (línea 74)

---

### **10. Funciones Auxiliares IRT**

**Ubicación:** `app/Services/IrtService.php`

#### **`obtenerHistorialIntentos()`** (líneas 160-168)
- Obtiene intentos del estudiante en la categoría
- Ordena por fecha de creación

#### **`prepararDatosIrt()`** (líneas 170-200)
- Prepara datos `(u_i, a_i, b_i)` para cada intento
- Obtiene parámetros IRT de `irt_parametros`
- Mapea dificultad → `b` si no hay parámetros

#### **`obtenerThetaInicial()`** (líneas 202-208)
- Obtiene theta previo de `est_habilidades.theta_por_cat`
- Retorna null si no existe

#### **`mapearDificultadAB()`** (líneas 210-216)
- Mapea `dificultad_id` → `b_dificultad`:
  - 1 → -2.0
  - 2 → -1.0
  - 3 → 0.0
  - 4 → 1.0
  - 5 → 2.0

#### **`calcularPrimeraDerivada()`** (líneas 218-228)
- Calcula `L'(θ)` = `Σ a_i * (u_i - P_i)`

#### **`calcularSegundaDerivada()`** (líneas 230-240)
- Calcula `L''(θ)` = `-Σ a_i² * P_i * (1 - P_i)`

#### **`probabilidadIrt()`** (líneas 242-252)
- Calcula `P_i(θ)` = `1 / (1 + exp(-a_i * (θ - b_i)))`
- Protección contra overflow

#### **`newtonRaphson()`** (líneas 254-290)
- Implementa algoritmo Newton-Raphson
- Maneja convergencia y fallbacks

---

## 🔄 **CADENAS DE MARKOV**

### **11. Servicio de Cadenas de Markov**

**Ubicación:** `app/Services/MarkovService.php`

#### **`obtenerEstado()`** (líneas 26-38)
- Obtiene estado actual (bajo/medio/alto) del estudiante
- Usa `IrtService::obtenerNivelPorCategoria()`

#### **`registrarTransicion()`** (líneas 40-52)
- Registra transición de estado en tabla `transitions`
- Solo si cambia el estado

**Llamada desde:** `ScoringService::procesarIntento()` (línea 72)

#### **`calcularMatrizTransicion()`** (líneas 54-82)
- Calcula matriz de transición de estados
- Para análisis de progresión

#### **`obtenerDistribucionEstados()`** (líneas 84-102)
- Obtiene distribución de estudiantes por estado

#### **`calcularEntropia()`** (líneas 104-123)
- Calcula entropía de la distribución de estados

#### **`probabilidadSubirNivel()`** (líneas 125-145)
- Calcula probabilidad de subir de nivel

---

## 🎯 **ASIGNACIÓN ADAPTATIVA**

### **12. Servicio de Selección de Items**

**Ubicación:** `app/Services/ItemSelectorService.php`

#### **`seleccionarEvaluacion()`** (líneas 26-70)
- Selecciona la siguiente evaluación adaptativamente
- Usa política combinada IRT + Markov
- Considera exploración epsilon-greedy

#### **`obtenerEvaluacionesRecomendadas()`** (líneas 72-105)
- Obtiene lista de evaluaciones recomendadas
- Filtra por categoría y dificultad apropiada

#### **`politicaMarkovIrt()`** (líneas 107-140)
- Calcula score de política: `Score_c = α(1-r_c) + βH(s_c) + γ(1-T_c,i→i+1)`
- Combina IRT y Markov

#### **`exploracionEpsilon()`** (líneas 142-150)
- Implementa exploración epsilon-greedy

---

## 💾 **PERSISTENCIA**

### **13. Modelos de Base de Datos**

#### **`Intento`** - `app/Models/Intento.php`
- Modelo para intentos
- Relaciones: `evaluacion()`, `user()`

#### **`Score`** - `app/Models/Score.php`
- Modelo para puntajes
- Guarda `calculo_meta` (JSON con metadata IRT)

#### **`EstHabilidad`** - `app/Models/EstHabilidad.php`
- Modelo para habilidades estimadas
- Campos: `theta_global`, `theta_por_cat` (JSON)
- Métodos: `obtenerNivel()`, `obtenerNivelPorCategoria()`

#### **`IrtParametro`** - `app/Models/IrtParametro.php`
- Modelo para parámetros IRT
- Campos: `a_discriminacion`, `b_dificultad`, `c_azar`

#### **`Rendimiento`** - `app/Models/Rendimiento.php`
- Modelo para rendimiento EMA
- Campos: `r_ema`, `muestras`

#### **`Transition`** - `app/Models/Transition.php`
- Modelo para transiciones Markov
- Campos: `estado_origen`, `estado_destino`

---

## 📊 **VISUALIZACIÓN Y DEMOSTRACIÓN**

### **14. Controlador de Demostración**

**Ubicación:** `app/Http/Controllers/DemostracionController.php`

**Función:**
```php
public function index(): View
```

**Qué hace:**
- Obtiene estudiantes con theta calculado
- Agrupa por nivel (bajo/medio/alto)
- Obtiene evaluaciones recomendadas
- Calcula estadísticas
- Retorna vista de demostración

**Ruta:** `/dashboard/demostracion`

---

### **15. API de Demostración**

**Ubicación:** `app/Http/Controllers/Api/DemoApiController.php`

#### **`start()`** (líneas 26-47)
- Devuelve metadata de evaluación y parámetros IRT

#### **`submitAttempt()`** (líneas 53-97)
- Crea intento y procesa scoring
- Retorna score con metadata IRT

#### **`userScores()`** (líneas 103-124)
- Retorna theta y scores del usuario

---

## 🎯 **FIN: Resultado Final**

### **16. Datos Persistidos**

**Tabla `intentos`:**
- `es_correcto_int` (0 o 1)
- `nro_intento_int`
- `tiempo_envio_int`
- `latencia_seg_int`

**Tabla `scores`:**
- `puntaje`, `porcentaje`
- `calculo_meta` (JSON completo con metadata IRT)

**Tabla `est_habilidades`:**
- `theta_global` (theta promedio)
- `theta_por_cat` (JSON con theta por categoría)

**Tabla `transitions`:**
- `estado_origen`, `estado_destino`
- Registro de cambios de nivel

**Tabla `rendimientos`:**
- `r_ema` (EMA tradicional)
- `muestras` (número de intentos)

---

## 📋 **Resumen de Flujo Completo**

```
1. UI/API → IntentoController::store() o DemoApiController::submitAttempt()
   ↓
2. ScoringService::procesarIntento()
   ↓
3. ├─ EMA (tradicional) → rendimientos
   ├─ LogisticInitService::estimarProbabilidadEmpirica()
   │   └─ Newton-Raphson: logit(p) = β₀ + β₁(índice) → logit_p
   ├─ IrtService::actualizarThetaDespuesIntento()
   │   ├─ calcularTheta() → theta por categoría
   │   ├─ calcularThetaGlobal() → theta global
   │   └─ obtenerNivel() → bajo/medio/alto
   ├─ MarkovService::registrarTransicion()
   └─ ItemSelectorService::seleccionarEvaluacion()
   ↓
4. Persistencia en BD:
   - scores.calculo_meta (metadata completa)
   - est_habilidades.theta_global
   - est_habilidades.theta_por_cat
   - transitions (si cambia nivel)
   - rendimientos.r_ema
   ↓
5. Respuesta JSON/UI con resultados
```

---

## 🗂️ **Archivos Clave por Función**

### **Regresión Logística:**
- `app/Services/LogisticInitService.php` - Líneas 19-123

### **IRT 2PL:**
- `app/Services/IrtService.php` - Líneas 24-290

### **Markov:**
- `app/Services/MarkovService.php` - Líneas 26-145

### **Asignación Adaptativa:**
- `app/Services/ItemSelectorService.php` - Líneas 26-150

### **Pipeline Principal:**
- `app/Services/ScoringService.php` - Líneas 23-108

### **Controladores:**
- `app/Http/Controllers/IntentoController.php` - Líneas 18-52
- `app/Http/Controllers/Api/DemoApiController.php` - Líneas 53-124
- `app/Http/Controllers/DemostracionController.php` - Líneas 15-80

### **Modelos:**
- `app/Models/Intento.php`
- `app/Models/Score.php`
- `app/Models/EstHabilidad.php`
- `app/Models/IrtParametro.php`
- `app/Models/Rendimiento.php`
- `app/Models/Transition.php`

---

## 📝 **Para el Docente: Mapeo Rápido**

### **Pregunta: "¿Dónde está la función X?"**

**"¿Dónde se calcula theta?"**
→ `app/Services/IrtService.php` - `calcularTheta()` (línea 24)

**"¿Dónde está Newton-Raphson para IRT?"**
→ `app/Services/IrtService.php` - `newtonRaphson()` (línea 254)

**"¿Dónde está la regresión logística?"**
→ `app/Services/LogisticInitService.php` - `estimarProbabilidadEmpirica()` (línea 19)

**"¿Dónde se procesa un intento?"**
→ `app/Services/ScoringService.php` - `procesarIntento()` (línea 23)

**"¿Dónde se guarda theta?"**
→ `app/Services/IrtService.php` - `actualizarThetaDespuesIntento()` (línea 106)
→ Persiste en `est_habilidades` (línea 130)

**"¿Dónde se determina el nivel?"**
→ `app/Services/IrtService.php` - `obtenerNivel()` (línea 151)

**"¿Dónde se recibe el intento desde la UI?"**
→ `app/Http/Controllers/IntentoController.php` - `store()` (línea 18)

**"¿Dónde se guarda la metadata IRT?"**
→ `app/Services/ScoringService.php` - `procesarIntento()` (línea 99)
→ Guarda en `scores.calculo_meta` (línea 101)

---

**Última actualización:** 2025-11-04

