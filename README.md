# Guía de despliegue en Laragon 8 (Windows)

Esta guía resume cómo levantar **Synapse CTF MVP** en tu entorno de **Laragon 8** sin adivinar configuraciones.

## 1) ¿Qué necesitas instalar?

Si ya usas Laragon 8 como en tu captura, solo valida esto:

- PHP **8.2 o superior** (tu Laragon tiene PHP 8.3, ✅ compatible).
- Apache o Nginx (en tu caso Apache 2.4, ✅).
- MySQL/MariaDB activo (en tu caso MySQL 8.4, ✅).
- Composer disponible en terminal de Laragon.
- Node.js 18+ y npm (para compilar assets frontend).

## 2) Clonar o copiar el proyecto

Coloca el proyecto dentro de `C:\laragon\www\` para que Laragon lo detecte como sitio local.

Ejemplo:

```powershell
cd C:\laragon\www
git clone <URL_DEL_REPO> synapse
cd synapse
```

## 3) Configurar variables de entorno

1. Copia el archivo base:

```powershell
copy .env.example .env
```

2. Edita `.env` y ajusta BD:

```env
APP_NAME=Synapse
APP_ENV=local
APP_DEBUG=true
APP_URL=http://synapse.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=synapse
DB_USERNAME=root
DB_PASSWORD=
```

> Si en Laragon tu `root` tiene contraseña, colócala en `DB_PASSWORD`.

## 4) Crear la base de datos

Desde HeidiSQL/phpMyAdmin o terminal MySQL crea la BD vacía:

```sql
CREATE DATABASE synapse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 5) Instalar dependencias y preparar app

En terminal de Laragon, dentro del proyecto:

```powershell
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
```

Esto crea estructura y datos demo (usuarios, roles, evaluaciones).

## 6) Levantar el sistema

Tienes dos opciones válidas:

### Opción A: con virtual host de Laragon (recomendado)

- Solo deja el proyecto en `www/synapse`.
- Reinicia Laragon (o Menú → Apache → Reload).
- Abre: `http://synapse.test`

### Opción B: con servidor interno de Laravel

```powershell
php artisan serve --host=127.0.0.1 --port=8000
npm run dev
```

Y navega a `http://127.0.0.1:8000`.

## 7) Usuarios demo para entrar

- **Admin**: `admin@synapse.com` / `admin123`
- **Docente**: `docente@synapse.local` / `docente123`
- **Estudiante**: `student_demo@synapse.local` / `password`

## 8) Problemas comunes en Laragon 8

- **Error de extensiones PHP**: habilita en `php.ini` extensiones de Laravel (`mbstring`, `openssl`, `pdo_mysql`, `fileinfo`, etc.).
- **APP_KEY missing**: ejecuta `php artisan key:generate`.
- **No carga CSS/JS**: ejecuta `npm install` y `npm run dev`.
- **Error de conexión a BD**: revisa `DB_HOST`, `DB_PORT`, usuario/clave en `.env`.
- **Puerto ocupado**: cambia puerto en `php artisan serve --port=8080` o libera conflicto en Windows.

## 9) ¿Solo lo bajo y ya trabajo?

Sí, **casi**: no basta con descargar. Debes ejecutar como mínimo:

1. `composer install`
2. `copy .env.example .env`
3. configurar `.env` (BD)
4. `php artisan key:generate`
5. `php artisan migrate:fresh --seed`

Con eso ya puedes trabajar en local en Laragon 8.
