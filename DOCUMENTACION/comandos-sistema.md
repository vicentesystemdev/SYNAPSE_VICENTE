# Comandos del Sistema Synapse - Guía Completa

## 📋 Resumen

Tu sistema ya tiene varios comandos y seeders para gestionar datos. Aquí está la guía completa de lo que existe y cómo usarlo.

---

## 🔄 RESETEO Y LIMPIEZA

### Comando Artisan: `reset:datos` (NUEVO)
Resetea estudiantes, intentos y/o evaluaciones con flags específicos.

```bash
# Resetear solo intentos (mantiene estudiantes y evaluaciones)
php artisan reset:datos --intentos

# Resetear solo evaluaciones (elimina también intentos relacionados)
php artisan reset:datos --pruebas

# Resetear solo estudiantes (elimina también sus datos)
php artisan reset:datos --estudiantes

# RESETEO COMPLETO - Flag general
php artisan reset:datos --todo

# Sin confirmación (para scripts)
php artisan reset:datos --todo --force
```

**¿Qué elimina cada opción?**

| Flag | Elimina |
|------|---------|
| `--intentos` | intentos, scores, rankings, rendimientos, est_habilidades |
| `--pruebas` | evaluaciones (y en cascada: intentos, scores) |
| `--estudiantes` | usuarios con rol "estudiante" (y todos sus datos) |
| `--todo` | **TODO lo anterior** |

---

## 🌱 SEEDERS - GENERAR DATOS

### 1. Seeder Principal
```bash
# Ejecuta todos los seeders configurados
php artisan db:seed
```

**Ejecuta en orden:**
1. `RoleSeeder` - Crea roles (admin, docente, estudiante)
2. `CatalogoBasicoSeeder` - Categorías, dificultades, periodos
3. `AdminUserSeeder` - Usuario administrador
4. `DemoDataSeeder` - Docente demo
5. `IrtQuickSeed` - Datos rápidos IRT (1 estudiante, 6 intentos)
6. `IrtDemoSeed` - **30 estudiantes** con diferentes niveles

### 2. Seeders Individuales

#### Evaluaciones CTF Base (20 retos reales)
```bash
php artisan db:seed --class=EvaluacionesCtfBaseSeeder
```
Crea 20 evaluaciones CTF basadas en retos reales del documento DOCX.

#### Evaluaciones CTF Completo (200 retos)
```bash
php artisan db:seed --class=EvaluacionesCtfCompletoSeeder
```
Crea ~200 evaluaciones CTF (50 por categoría: WEB, CRYPTO, STEGO, FORENS).

#### Asignar Flags a Evaluaciones
```bash
php artisan db:seed --class=EvaluacionFlagsSeeder
```
**Importante:** Este seeder asigna la **misma flag** a todas las evaluaciones para pruebas.
- Flag por defecto: `test123`
- MD5: `cc03e747a6afbbcbf8be7668acfebee5`
- Flag esperada: `synapse{cc03e747a6afbbcbf8be7668acfebee5}`

**Para cambiar la flag:** Edita el archivo `database/seeders/EvaluacionFlagsSeeder.php` línea 21.

#### IRT Demo Seed (30 estudiantes)
```bash
php artisan db:seed --class=IrtDemoSeed
```
Crea 30 estudiantes con diferentes niveles:
- 10 estudiantes nivel bajo (15-35% correctos)
- 10 estudiantes nivel medio (40-60% correctos)
- 10 estudiantes nivel alto (65-90% correctos)

---

## 🎯 COMANDOS ARTISAN ESPECÍFICOS

### Gestionar Flags de Evaluaciones
```bash
# Listar todas las evaluaciones
php artisan evaluacion:flag --list

# Asignar flag a una evaluación específica
php artisan evaluacion:flag 1 --solution="texto_secreto"

# Asignar MD5 directo
php artisan evaluacion:flag 1 --md5="cc03e747a6afbbcbf8be7668acfebee5"

# Asignar y publicar
php artisan evaluacion:flag 1 --solution="texto" --publish
```

### Crear Intentos de Demo
```bash
# Crear 10 intentos para el estudiante ID 5
php artisan demo:crear-intentos 5 --cantidad=10 --correctos=70

# Crear intentos solo de una categoría
php artisan demo:crear-intentos 5 --categoria=1 --cantidad=15
```

---

## 📝 SCRIPTS PHP DIRECTOS

### 1. Demo Rápida IRT
```bash
php demo-rapida.php
```
**Qué hace:**
- Selecciona o crea un estudiante demo
- Crea 5 intentos nuevos (60% correctos)
- Muestra theta calculado y nivel
- Muestra metadata IRT con convergencia

### 2. Listar Estudiantes
```bash
php listar-estudiantes.php
```
Lista todos los usuarios con rol "estudiante".

### 3. Verificar Demo Estudiante
```bash
php verificar-demo-estudiante.php {user_id}
```
Muestra información detallada de un estudiante:
- Datos personales
- Intentos realizados
- Scores
- Theta calculado
- Nivel IRT

### 4. Verificar Demo General
```bash
php verificar-demo.php
```
Verifica el estado general del sistema de demo.

### 5. Verificar Estructura BD
```bash
php verificar-estructura-bdd.php
```
Verifica que todas las tablas existan correctamente.

### 6. Verificar Estudiantes
```bash
php verificar-estudiantes.php
```
Muestra resumen de todos los estudiantes y sus datos.

---

## 🔥 FLUJOS DE TRABAJO COMUNES

### Reseteo Completo y Regeneración
```bash
# 1. Resetear todo
php artisan reset:datos --todo --force

# 2. Regenerar estructura base
php artisan db:seed

# 3. Crear evaluaciones CTF
php artisan db:seed --class=EvaluacionesCtfCompletoSeeder

# 4. Asignar flags a todas las evaluaciones
php artisan db:seed --class=EvaluacionFlagsSeeder

# 5. Verificar
php verificar-estructura-bdd.php
```

### Limpiar Solo Intentos (Mantener Usuarios y Evaluaciones)
```bash
# Resetear intentos
php artisan reset:datos --intentos --force

# Regenerar intentos de demo
php artisan db:seed --class=IrtDemoSeed
```

### Crear Datos de Prueba Rápidos
```bash
# 1. Asegurarse de tener evaluaciones
php artisan db:seed --class=EvaluacionesCtfBaseSeeder

# 2. Asignar flags
php artisan db:seed --class=EvaluacionFlagsSeeder

# 3. Crear estudiantes con intentos
php artisan db:seed --class=IrtDemoSeed

# 4. Verificar con demo rápida
php demo-rapida.php
```

---

## 📊 COMPARACIÓN: ¿Qué Usar Cuándo?

| Necesidad | Comando Recomendado |
|-----------|---------------------|
| **Reseteo completo del sistema** | `php artisan reset:datos --todo` |
| **Limpiar solo intentos** | `php artisan reset:datos --intentos` |
| **Eliminar estudiantes** | `php artisan reset:datos --estudiantes` |
| **Generar 30 estudiantes de prueba** | `php artisan db:seed --class=IrtDemoSeed` |
| **Crear evaluaciones CTF** | `php artisan db:seed --class=EvaluacionesCtfCompletoSeeder` |
| **Asignar misma flag a todas** | `php artisan db:seed --class=EvaluacionFlagsSeeder` |
| **Asignar flag específica** | `php artisan evaluacion:flag {id} --solution="texto"` |
| **Demo rápida del sistema** | `php demo-rapida.php` |
| **Ver datos de estudiante** | `php verificar-demo-estudiante.php {id}` |

---

## ⚠️ IMPORTANTE

### Datos que NO se Eliminan con `--todo`
- Categorías (WEB, CRYPTO, STEGO, FORENS)
- Dificultades (1-5)
- Periodos
- Usuarios con roles: admin, docente
- Parámetros IRT de evaluaciones

### Orden de Eliminación (Respeta Foreign Keys)
1. Intentos
2. Scores
3. Rankings
4. Rendimientos
5. Estimaciones de habilidad
6. Evaluaciones (si `--pruebas`)
7. Estudiantes (si `--estudiantes`)

### Transacciones
Todos los comandos de reseteo usan transacciones. Si hay un error, se revierten todos los cambios.

---

## 🎓 EJEMPLOS PRÁCTICOS

### Escenario 1: Nuevo Semestre
```bash
# Limpiar estudiantes del semestre anterior
php artisan reset:datos --estudiantes --force

# Mantener las evaluaciones, solo resetear intentos
php artisan reset:datos --intentos --force

# Listo para nuevos estudiantes
```

### Escenario 2: Testing de IRT
```bash
# Reseteo completo
php artisan reset:datos --todo --force

# Crear datos de prueba
php artisan db:seed --class=IrtDemoSeed

# Verificar cálculos
php demo-rapida.php
```

### Escenario 3: Agregar Más Evaluaciones
```bash
# No resetear nada, solo agregar
php artisan db:seed --class=EvaluacionesCtfCompletoSeeder

# Asignar flags a las nuevas
php artisan db:seed --class=EvaluacionFlagsSeeder
```

---

## 📌 Notas Finales

1. **Backup antes de resetear en producción:**
   ```bash
   mysqldump -u usuario -p synapse > backup_$(date +%Y%m%d_%H%M%S).sql
   ```

2. **El comando `reset:datos` es el FLAG GENERAL** que pediste - usa `--todo` para resetear todo.

3. **Los seeders GENERAN datos**, el comando `reset:datos` los ELIMINA.

4. **Para desarrollo:** Usa `--force` para evitar confirmaciones.

5. **Para producción:** Nunca uses `--force`, siempre revisa lo que vas a eliminar.
