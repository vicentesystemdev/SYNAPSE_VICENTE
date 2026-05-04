# ⚡ Resumen Rápido: Dónde Está Cada Función

## 🎯 Para el Docente: "¿Dónde está la función X?"

---

## 📍 **Ubicación Rápida por Función**

### **1. Recibir Intento desde UI**
**Archivo:** `app/Http/Controllers/IntentoController.php`  
**Función:** `store()` (línea 18)  
**Ruta:** `POST /evaluaciones/{evaluacion}/intentos`

---

### **2. Procesar Intento (Pipeline Principal)**
**Archivo:** `app/Services/ScoringService.php`  
**Función:** `procesarIntento()` (línea 23)  
**Llamada desde:** `IntentoController::store()` (línea 49)

---

### **3. Regresión Logística (Semilla de Theta)**
**Archivo:** `app/Services/LogisticInitService.php`  
**Función:** `estimarProbabilidadEmpirica()` (línea 19)  
**Llamada desde:** `ScoringService::procesarIntento()` (línea 63)  
**Ecuación:** `logit(p) = β₀ + β₁(índice_temporal)`  
**Usa:** Newton-Raphson (líneas 52-99)

---

### **4. IRT 2PL (Cálculo de Theta)**
**Archivo:** `app/Services/IrtService.php`  
**Función principal:** `calcularTheta()` (línea 24)  
**Llamada desde:** `IrtService::actualizarThetaDespuesIntento()` (línea 115)  
**Ecuación:** `P_i(θ) = 1 / (1 + exp(-a_i * (θ - b_i)))`  
**Usa:** Newton-Raphson (líneas 41-74)

---

### **5. Actualizar Theta en BD**
**Archivo:** `app/Services/IrtService.php`  
**Función:** `actualizarThetaDespuesIntento()` (línea 106)  
**Llamada desde:** `ScoringService::procesarIntento()` (línea 69)  
**Guarda en:** `est_habilidades` (línea 130)

---

### **6. Determinar Nivel (Bajo/Medio/Alto)**
**Archivo:** `app/Services/IrtService.php`  
**Función:** `obtenerNivel()` (línea 151)  
**Llamada desde:** `ScoringService::procesarIntento()` (línea 74)  
**Lógica:** 
- `theta < -0.5` → `'bajo'`
- `-0.5 ≤ theta < 0.5` → `'medio'`
- `theta ≥ 0.5` → `'alto'`

---

### **7. Cadenas de Markov**
**Archivo:** `app/Services/MarkovService.php`  
**Función:** `registrarTransicion()` (línea 40)  
**Llamada desde:** `ScoringService::procesarIntento()` (línea 72)  
**Guarda en:** Tabla `transitions`

---

### **8. Asignación Adaptativa**
**Archivo:** `app/Services/ItemSelectorService.php`  
**Función:** `seleccionarEvaluacion()` (línea 26)  
**Usa:** Política IRT + Markov (línea 107)

---

### **9. Guardar Metadata IRT**
**Archivo:** `app/Services/ScoringService.php`  
**Función:** `procesarIntento()` (línea 99)  
**Guarda en:** `scores.calculo_meta` (JSON)  
**Contiene:** Seed logística, IRT, Markov, iteraciones, convergencia

---

## 📊 **Flujo Visual Completo**

```
┌─────────────────────────────────────────────────────────┐
│ 1. UI/API                                                │
│    app/Http/Controllers/IntentoController.php            │
│    Función: store() (línea 18)                         │
│    ↓                                                     │
│    Crea Intento en BD                                   │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 2. Pipeline Principal                                   │
│    app/Services/ScoringService.php                      │
│    Función: procesarIntento() (línea 23)                │
│    ↓                                                     │
│    ├─ EMA (tradicional) → rendimientos                  │
│    ├─ LogisticInitService → logit_p                     │
│    ├─ IrtService → theta                                │
│    ├─ MarkovService → transición                        │
│    └─ ItemSelectorService → recomendación              │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 3. Regresión Logística                                  │
│    app/Services/LogisticInitService.php                 │
│    Función: estimarProbabilidadEmpirica() (línea 19)    │
│    ↓                                                     │
│    Newton-Raphson: logit(p) = β₀ + β₁(índice)          │
│    ↓                                                     │
│    Retorna: logit_p (semilla de theta)                 │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 4. IRT 2PL                                              │
│    app/Services/IrtService.php                          │
│    Función: calcularTheta() (línea 24)                  │
│    ↓                                                     │
│    Newton-Raphson: P_i(θ) = 1/(1+exp(-a*(θ-b)))        │
│    ↓                                                     │
│    Retorna: theta                                       │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 5. Actualizar Theta                                     │
│    app/Services/IrtService.php                          │
│    Función: actualizarThetaDespuesIntento() (línea 106) │
│    ↓                                                     │
│    Guarda en est_habilidades:                           │
│    - theta_global                                        │
│    - theta_por_cat                                       │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 6. Determinar Nivel                                     │
│    app/Services/IrtService.php                          │
│    Función: obtenerNivel() (línea 151)                  │
│    ↓                                                     │
│    Retorna: 'bajo', 'medio' o 'alto'                   │
└─────────────────────────────────────────────────────────┘
                        ↓
┌─────────────────────────────────────────────────────────┐
│ 7. Persistencia Final                                   │
│    app/Services/ScoringService.php                      │
│    Función: procesarIntento() (línea 99)                │
│    ↓                                                     │
│    Guarda en scores.calculo_meta:                       │
│    - seed_logistica (p_empirico, logit_p, iter, ...)     │
│    - irt (theta_cat, theta_global, nivel, iter, ...)    │
│    - markov (estado_anterior, estado_nuevo)             │
└─────────────────────────────────────────────────────────┘
```

---

## 🔍 **Preguntas Frecuentes del Docente**

### **"¿Dónde está Newton-Raphson para IRT?"**
**Respuesta:**  
- Archivo: `app/Services/IrtService.php`
- Función: `calcularTheta()` (línea 24)
- Newton-Raphson: Líneas 41-74
- Fórmula: `θ ← θ - L'/L''`
- Primera derivada: `L'(θ) = Σ a_i * (u_i - P_i)` (línea 52)
- Segunda derivada: `L''(θ) = -Σ a_i² * P_i * (1 - P_i)` (línea 53)

---

### **"¿Dónde está Newton-Raphson para Regresión Logística?"**
**Respuesta:**  
- Archivo: `app/Services/LogisticInitService.php`
- Función: `estimarProbabilidadEmpirica()` (línea 19)
- Newton-Raphson: Líneas 52-99
- Fórmula: `β ← β - H^{-1} * g`
- Gradiente: `g = Σ(u_i - p_i)` (línea 70)
- Hessiano: `H = -Σ(p_i * (1-p_i))` (línea 73)

---

### **"¿Dónde se guarda theta?"**
**Respuesta:**  
- Archivo: `app/Services/IrtService.php`
- Función: `actualizarThetaDespuesIntento()` (línea 106)
- Guarda en: `est_habilidades` (línea 130)
- Campos: `theta_global`, `theta_por_cat` (JSON)

---

### **"¿Dónde se procesa el intento?"**
**Respuesta:**  
- Archivo: `app/Services/ScoringService.php`
- Función: `procesarIntento()` (línea 23)
- Llamada desde: `IntentoController::store()` (línea 49)
- Ejecuta: EMA → Logística → IRT → Markov → Persistencia

---

### **"¿Dónde está la metadata IRT?"**
**Respuesta:**  
- Archivo: `app/Services/ScoringService.php`
- Función: `procesarIntento()` (línea 76)
- Guarda en: `scores.calculo_meta` (JSON) (línea 101)
- Contiene: Seed logística, IRT, Markov, iteraciones, convergencia

---

### **"¿Dónde se determina el nivel?"**
**Respuesta:**  
- Archivo: `app/Services/IrtService.php`
- Función: `obtenerNivel()` (línea 151)
- Llamada desde: `ScoringService::procesarIntento()` (línea 74)
- Lógica: Compara theta con umbrales (-0.5, 0.5)

---

### **"¿Dónde se recibe el intento?"**
**Respuesta:**  
- Archivo: `app/Http/Controllers/IntentoController.php`
- Función: `store()` (línea 18)
- Ruta: `POST /evaluaciones/{evaluacion}/intentos`
- Recibe: `respuesta_flag_int` (de request)
- Calcula: `es_correcto_int` (comparando hash)

---

## 📁 **Estructura de Archivos**

```
app/
├── Http/
│   └── Controllers/
│       ├── IntentoController.php          ← Recibe intento (línea 18)
│       └── Api/
│           └── DemoApiController.php      ← API alternativa (línea 53)
│
└── Services/
    ├── ScoringService.php                 ← Pipeline principal (línea 23)
    ├── LogisticInitService.php            ← Regresión logística (línea 19)
    ├── IrtService.php                     ← IRT 2PL (línea 24)
    ├── MarkovService.php                  ← Cadenas de Markov (línea 40)
    └── ItemSelectorService.php            ← Asignación adaptativa (línea 26)

app/Models/
├── Intento.php                            ← Modelo de intentos
├── Score.php                               ← Modelo de scores
├── EstHabilidad.php                       ← Modelo de theta
├── IrtParametro.php                       ← Modelo de parámetros IRT
├── Rendimiento.php                        ← Modelo de EMA
└── Transition.php                         ← Modelo de transiciones Markov
```

---

## 🎯 **Resumen Ultra-Rápido**

| Función | Archivo | Línea | Llama desde |
|---------|---------|-------|-------------|
| Recibir intento | `IntentoController.php` | 18 | UI/API |
| Procesar intento | `ScoringService.php` | 23 | `IntentoController` |
| Regresión logística | `LogisticInitService.php` | 19 | `ScoringService` |
| IRT 2PL | `IrtService.php` | 24 | `IrtService::actualizarThetaDespuesIntento()` |
| Actualizar theta | `IrtService.php` | 106 | `ScoringService` |
| Determinar nivel | `IrtService.php` | 151 | `ScoringService` |
| Markov | `MarkovService.php` | 40 | `ScoringService` |
| Asignación adaptativa | `ItemSelectorService.php` | 26 | Vista de demostración |

---

**Última actualización:** 2025-11-04

