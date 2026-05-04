# Guía de Roles y Permisos (Sistema IRT/CTF)

Hemos personalizado la implementación estándar de `spatie/laravel-permission` para incluir un estado en los roles.

## Modelo de Rol Personalizado

El modelo se encuentra en `App\Models\Role`.
Extiende de `Spatie\Permission\Models\Role` y añade la columna `estado`.

### Estados Disponibles
- **1**: Activo
- **2**: Inactivo

### Uso en Código

```php
use App\Models\Role;

// Crear un nuevo rol
$role = Role::create([
    'name' => 'invitado',
    'guard_name' => 'web',
    'estado' => 1
]);

// Verificar estado
if ($role->estado === 1) {
    echo "El rol está activo";
}
```

## Comandos de Inicialización

Para aplicar estos cambios (ATENCIÓN: Borra la base de datos):

```bash
php artisan migrate:refresh --seed
```

Esto ejecutará la migración modificada `create_permission_tables.php` que ahora incluye la columna `estado`.
