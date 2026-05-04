# 📄 Documentación del Módulo de Autenticación Modificado

Este documento detalla las modificaciones realizadas en el módulo de autenticación del sistema Synapse CTF, abarcando las páginas de inicio de sesión, registro y recuperación de contraseña. El objetivo principal de estas modificaciones fue implementar un diseño visual unificado y minimalista con una paleta de colores oscuros y tonos naranjas, además de asegurar la correcta integración con la base de datos y la funcionalidad de verificación de correo electrónico.

---

## 1. Vistas Modificadas (Blade)

Todas las vistas de autenticación (`login.blade.php`, `register.blade.php`, `forgot-password.blade.php`, `reset-password.blade.php`) fueron completamente reemplazadas para eliminar los componentes Blade predeterminados de Laravel (como `<x-guest-layout>`, `<x-input-label>`, etc.) y utilizar HTML, CSS (inline) y JavaScript puros. Esto permitió un control total sobre el diseño visual y la implementación de interacciones personalizadas.

### 1.1. `resources/views/auth/login.blade.php`

*   **Propósito Original:** Formulario de inicio de sesión.
*   **Modificaciones:**
    *   Diseño minimalista con fondo oscuro y elementos en tonos naranjas.
    *   Integración de video de fondo (`/images/Fondo2.mp4`) y banner (`/images/bbn2.png`).
    *   Validación básica de campos y estilo visual para errores.

### 1.2. `resources/views/auth/register.blade.php`

*   **Propósito Original:** Formulario de registro de nuevos usuarios.
*   **Modificaciones:**
    *   Diseño consistente con la página de login (fondo oscuro, tonos naranjas, video/banner).
    *   Inclusión de campos para `name`, `app_usu` (apellido paterno), `apm_usu` (apellido materno), `email` y `password` (con confirmación).
    *   Campo oculto `COD_ROL` establecido con el valor `3` (Estudiante) por defecto.
    *   Validaciones de JavaScript para:
        *   Formato de correo institucional (ej. `lpze.@unifranz.edu.bo`).
        *   Requisitos de fortaleza de contraseña (mínimo 8 caracteres, mayúsculas, minúsculas, números).
        *   Confirmación de contraseña (coincidencia con la contraseña principal).

### 1.3. `resources/views/auth/forgot-password.blade.php`

*   **Propósito Original:** Formulario para solicitar el enlace de restablecimiento de contraseña.
*   **Modificaciones:**
    *   Diseño adaptado al tema oscuro/naranja, manteniendo el video de fondo y el banner.
    *   Formulario simple para ingresar el correo electrónico y enviar la solicitud.

### 1.4. `resources/views/auth/reset-password.blade.php`

*   **Propósito Original:** Formulario para establecer una nueva contraseña utilizando un token de restablecimiento.
*   **Modificaciones:**
    *   Diseño adaptado al tema oscuro/naranja, manteniendo el video de fondo y el banner.
    *   Formulario para ingresar la nueva contraseña y su confirmación.
    *   Se incluyó JavaScript para la validación de fortaleza de la nueva contraseña, similar a la página de registro.
    *   Funcionalidad para mostrar/ocultar contraseña (ícono de ojo).

---

## 2. Lógica del Backend Modificada

### 2.1. Modelo `App\Models\User.php`

*   **Implementación:** Se añadió `implements MustVerifyEmail` para habilitar la verificación de correos electrónicos de Laravel.
*   **`$fillable`:** Se actualizó el array `$fillable` para incluir los campos `app_usu`, `apm_usu` y `activo_usu`, asegurando que el modelo pueda asignarlos masivamente desde el formulario de registro y que coincidan con la estructura de la base de datos `synapse_test.sql`.
*   **`$casts`:** Se agregó `'activo_usu' => 'boolean'` para una correcta interpretación del campo.
*   **`getNombreCompletoAttribute()`:** Se ajustó el accesor para que combine `name`, `app_usu` y `apm_usu` al obtener el nombre completo del usuario.

### 2.2. Controlador `App\Http\Controllers\Auth\RegisteredUserController.php`

*   **Método `store()`:**
    *   **Validación:** Se modificaron las reglas de validación para incluir `app_usu` y `apm_usu` como campos requeridos, y `COD_ROL` para asegurar que el rol enviado exista en la tabla `roles`.
    *   **Creación de Usuario:** Se ajustó la lógica de creación para guardar `app_usu`, `apm_usu` y establecer `activo_usu` como `true` por defecto.
    *   **Asignación de Rol:** Se implementó la lógica para asignar el rol por defecto (ID `3` - Estudiante) al nuevo usuario utilizando la librería Spatie Laravel Permission (`Role::findById($request->COD_ROL)->assignRole()`).
    *   **Verificación de Correo:** Después de registrar al usuario, se dispara el evento `Registered($user)`, que es el mecanismo de Laravel para enviar el correo de verificación (cuando está configurado).

### 2.3. Rutas de Autenticación (`routes/web.php` y `routes/auth.php`)

*   **`routes/web.php`:** Se eliminó la línea `Auth::routes(['verify' => true]);` que requería la instalación de `laravel/ui` y se restauró `require __DIR__ . '/auth.php';`. Esto asegura que todas las rutas de autenticación, incluida la verificación de correo electrónico, se carguen desde el archivo `routes/auth.php` sin dependencias adicionales.
*   **`routes/auth.php`:** Contiene las rutas predeterminadas de autenticación de Laravel, que ahora incluyen las rutas necesarias para la verificación de correo electrónico.

---

## 3. Configuración de Correo Electrónico (`.env`)

La configuración de correo electrónico se estableció en el archivo `.env` con los siguientes parámetros para permitir el envío de correos de verificación y restablecimiento de contraseña a través de Gmail:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=synapserecuperacion@gmail.com
MAIL_PASSWORD=yaitvghjeizgccio
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="synapse@recuperador.com"
MAIL_FROM_NAME="Synapse"
```

---

## 4. Estado de la Verificación de Correos Electrónicos

**Importante:** La funcionalidad de verificación de correos electrónicos ha sido configurada a nivel de código (modelo `User` y rutas de autenticación), y los parámetros del `.env` están listos para el envío. Sin embargo, **la verificación de correos electrónicos aún no ha sido probada exhaustivamente** para confirmar su correcto funcionamiento de extremo a extremo (envío, recepción, clic en enlace y marcado como verificado en la base de datos).

---

## 5. Próximos Pasos (Recomendados)

1.  **Prueba exhaustiva de la verificación de correos:** Registrar un nuevo usuario y verificar que el correo se envíe, se reciba y que el proceso de verificación funcione correctamente.
2.  **Prueba del flujo de recuperación de contraseña:** Asegurarse de que el envío del enlace y el restablecimiento de la contraseña funcionen como se espera.
