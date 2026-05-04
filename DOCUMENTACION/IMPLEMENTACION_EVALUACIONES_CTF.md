# 🚀 Implementación del Módulo de Evaluaciones CTF

## 📋 Resumen

Este documento describe la implementación completa del módulo de evaluaciones CTF con validación de flags en formato `synapse{md5}`, seeder de 20 retos base, y comandos de gestión.

**Fecha de Implementación:** 2025-11-11  
**Estado:** ✅ COMPLETADO

---

## ✅ Componentes Implementados

### 1. **Migración de Base de Datos**

**Archivo:** `database/migrations/2025_11_11_000000_add_solution_md5_and_metadata_to_evaluaciones.php`

**Campos Agregados:**
- `solution_md5` (char(32), nullable, indexed) - MD5 de la solución
- `metadata_eval` (json, nullable) - Metadatos adicionales de la evaluación

**Ejecutar migración:**
```bash
php artisan migrate
```

---

### 2. **Servicio de Validación de Flags**

**Archivo:** `app/Services/FlagService.php`

**Métodos:**
- `extractMd5(string $submitted): ?string` - Extrae MD5 de formato `synapse{md5}`
- `validate(string $submitted, string $expectedMd5): bool` - Valida flag contra MD5 esperado
- `isValidFormat(string $submitted): bool` - Valida solo el formato

**Formato de Flag:**
- Formato requerido: `synapse{md5}` donde `md5` es hexadecimal de 32 caracteres
- Ejemplo: `synapse{e99a18c428cb38d5f260853678922e03}`

---

### 3. **Seeder de Evaluaciones CTF Base**

**Archivo:** `database/seeders/EvaluacionesCtfBaseSeeder.php`

**Características:**
- Crea 20 evaluaciones base (4 categorías × 5 retos)
- Categorías: CRYPTO, STEGO, FORENS, WEB
- Dificultades: 1-5 (Fácil a Experto)
- Estado inicial: Borrador (estado_eval = 1)
- Metadata incluye: nivel_label, external_url, flag_format, fuente

**Ejecutar seeder:**
```bash
php artisan db:seed --class=EvaluacionesCtfBaseSeeder
```

**O descomentar en DatabaseSeeder:**
```php
EvaluacionesCtfBaseSeeder::class,
```

---

### 4. **Modelo Evaluacion Actualizado**

**Archivo:** `app/Models/Evaluacion.php`

**Campos Agregados:**
- `solution_md5` en `$fillable`
- `metadata_eval` en `$fillable`
- `metadata_eval` en `$casts` como `array`

---

### 5. **IntentoController Actualizado**

**Archivo:** `app/Http/Controllers/IntentoController.php`

**Cambios:**
- Integración con `FlagService` para validar flags en formato `synapse{md5}`
- Retrocompatibilidad: Si `solution_md5` no existe, usa `flag_hash_eval`
- Validación mejorada con comparación timing-safe usando `hash_equals`

---

### 6. **Comando Artisan para Gestión de Flags**

**Archivo:** `app/Console/Commands/GestionarEvaluacionFlag.php`

**Comandos Disponibles:**

#### Listar evaluaciones:
```bash
php artisan evaluacion:flag --list
```

#### Asignar MD5 desde texto solución:
```bash
php artisan evaluacion:flag {id} --solution="texto_clave_de_la_prueba"
```

#### Asignar MD5 directo:
```bash
php artisan evaluacion:flag {id} --md5="e99a18c428cb38d5f260853678922e03"
```

#### Asignar MD5 y publicar:
```bash
php artisan evaluacion:flag {id} --solution="texto" --publish
```

#### Modo interactivo:
```bash
php artisan evaluacion:flag {id}
```

---

## 🔄 Flujo de Trabajo

### Para el Coach/Admin:

1. **Cargar evaluaciones base:**
   ```bash
   php artisan db:seed --class=EvaluacionesCtfBaseSeeder
   ```

2. **Asignar solution_md5 a cada evaluación:**
   ```bash
   # Opción 1: Desde texto solución
   php artisan evaluacion:flag 1 --solution="texto_clave_de_la_prueba"
   
   # Opción 2: MD5 directo
   php artisan evaluacion:flag 1 --md5="e99a18c428cb38d5f260853678922e03"
   
   # Opción 3: Modo interactivo
   php artisan evaluacion:flag 1
   ```

3. **Publicar evaluación:**
   ```bash
   php artisan evaluacion:flag {id} --solution="texto" --publish
   ```

   O manualmente en tinker:
   ```php
   php artisan tinker
   >>> $e = Evaluacion::find(1);
   >>> $e->estado_eval = 2; // Publicada
   >>> $e->save();
   ```

### Para el Estudiante:

1. **Ver evaluación:**
   - Accede a `/evaluaciones/{id}`
   - Lee la descripción y detalles

2. **Resolver reto:**
   - Resuelve el reto CTF
   - Obtiene la solución

3. **Calcular MD5 de la solución:**
   ```bash
   php -r "echo md5('texto_solucion'), PHP_EOL;"
   ```

4. **Enviar flag:**
   - Formato: `synapse{md5}`
   - Ejemplo: `synapse{e99a18c428cb38d5f260853678922e03}`
   - El sistema valida automáticamente

---

## 📊 Estructura de Datos

### Tabla `evaluaciones`:

| Campo | Tipo | Descripción |
|-------|------|-------------|
| `id_eval` | bigint | ID único |
| `titulo_eval` | string(150) | Título de la evaluación |
| `descripcion_eval` | text | Descripción |
| `categoria_id` | bigint | FK a categorías |
| `dificultad_id` | bigint | FK a dificultades |
| `periodo_id` | bigint | FK a períodos (nullable) |
| `docente_user_id` | bigint | FK a usuarios (nullable) |
| `puntaje_base_eval` | decimal(10,2) | Puntaje base |
| `fecha_inicio_eval` | datetime | Fecha de inicio (nullable) |
| `fecha_fin_eval` | datetime | Fecha de fin (nullable) |
| `flag_hash_eval` | char(32) | Hash MD5 legacy (nullable) |
| `solution_md5` | char(32) | MD5 de la solución (nullable, indexed) |
| `metadata_eval` | json | Metadatos adicionales (nullable) |
| `estado_eval` | smallint | Estado (1=borrador, 2=publicada, 3=cerrada) |

### Metadata JSON (`metadata_eval`):

```json
{
  "nivel_label": "Fácil",
  "external_url": "https://...",
  "flag_format": "synapse{md5}",
  "fuente": "Parte 3 (DOCX)"
}
```

---

## 🔍 Validación de Flags

### Formato Requerido:
- **Formato:** `synapse{md5}`
- **MD5:** Hexadecimal de 32 caracteres (a-f0-9)
- **Case-insensitive:** Se acepta mayúsculas y minúsculas

### Ejemplos Válidos:
- ✅ `synapse{e99a18c428cb38d5f260853678922e03}`
- ✅ `SYNAPSE{E99A18C428CB38D5F260853678922E03}`
- ✅ `Synapse{E99A18C428CB38D5F260853678922E03}`

### Ejemplos Inválidos:
- ❌ `synapse{e99a18c428cb38d5f260853678922e0}` (31 caracteres)
- ❌ `synapse{e99a18c428cb38d5f260853678922e03x}` (33 caracteres)
- ❌ `synapse{e99a18c428cb38d5f260853678922g03}` (carácter inválido)
- ❌ `flag{e99a18c428cb38d5f260853678922e03}` (prefijo incorrecto)
- ❌ `e99a18c428cb38d5f260853678922e03` (sin formato)

---

## 🛠️ Comandos Útiles

### Calcular MD5 desde PHP:
```bash
php -r "echo md5('texto_solucion'), PHP_EOL;"
```

### Calcular MD5 desde Tinker:
```php
php artisan tinker
>>> md5('texto_solucion')
```

### Ver evaluaciones:
```bash
php artisan evaluacion:flag --list
```

### Asignar MD5 y publicar:
```bash
php artisan evaluacion:flag {id} --solution="texto" --publish
```

### Actualizar desde SQL:
```sql
UPDATE evaluaciones
SET solution_md5='e99a18c428cb38d5f260853678922e03', 
    estado_eval=2
WHERE id_eval=1;
```

---

## 📝 Checklist de Implementación

- [x] Migración creada (`solution_md5`, `metadata_eval`)
- [x] Servicio `FlagService` implementado
- [x] Seeder de 20 evaluaciones base creado
- [x] Modelo `Evaluacion` actualizado
- [x] `IntentoController` actualizado con validación
- [x] Comando artisan para gestión de flags creado
- [x] Retrocompatibilidad con `flag_hash_eval` mantenida
- [x] Documentación creada

---

## 🎯 Próximos Pasos

1. **Ejecutar migración:**
   ```bash
   php artisan migrate
   ```

2. **Cargar evaluaciones base:**
   ```bash
   php artisan db:seed --class=EvaluacionesCtfBaseSeeder
   ```

3. **Asignar solution_md5 a cada evaluación:**
   ```bash
   php artisan evaluacion:flag --list  # Ver todas
   php artisan evaluacion:flag {id} --solution="texto" --publish
   ```

4. **Probar validación:**
   - Crear un intento con flag válida
   - Verificar que se valide correctamente
   - Probar con flags inválidas

5. **Conectar rutas (si aún no está hecho):**
   - Verificar que las rutas de evaluaciones estén conectadas al controlador
   - Verificar que los estudiantes puedan ver y entregar flags

---

## 🔗 Referencias

- **Migración:** `database/migrations/2025_11_11_000000_add_solution_md5_and_metadata_to_evaluaciones.php`
- **Servicio:** `app/Services/FlagService.php`
- **Seeder:** `database/seeders/EvaluacionesCtfBaseSeeder.php`
- **Modelo:** `app/Models/Evaluacion.php`
- **Controlador:** `app/Http/Controllers/IntentoController.php`
- **Comando:** `app/Console/Commands/GestionarEvaluacionFlag.php`

---

**Última actualización:** 2025-11-11  
**Estado:** ✅ Implementación completa

