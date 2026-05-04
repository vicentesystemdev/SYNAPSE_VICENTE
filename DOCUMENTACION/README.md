# Synapse CTF MVP

Synapse es una plataforma de evaluaciones tipo CTF construida sobre Laravel 11 con Breeze, Spatie Permission y los servicios necesarios para cálculo de puntajes y rankings. Este repositorio contiene el MVP listo para ejecutarse en Laragon (Windows) con MySQL/MariaDB.

## Requisitos

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/MariaDB (probado en MariaDB 10.4)
- Extensiones PHP habituales de Laravel (mbstring, openssl, pdo_mysql, etc.)

## Instalación rápida

```bash
cp .env.example .env
# Configura en .env la conexión a tu base de datos Laragon
composer install
npm install
php artisan key:generate
php artisan migrate:fresh --seed
```

El seeder registra datos base (roles, catálogos, usuarios demo y evaluaciones) para poder probar inmediatamente.

### Usuarios de ejemplo

| Rol    | Email               | Password   |
|--------|---------------------|------------|
| Admin  | admin@synapse.com   | admin123   |
| Docente | docente@synapse.local | docente123   |
| Student| student_demo@synapse.local | password |

*(Consulta `database/seeders` para más credenciales demo.)*

## Ejecución

```bash
php artisan serve --host=127.0.0.1 --port=8000
npm run dev # opcional para assets
```

Visita `http://127.0.0.1:8000` y autentícate con alguno de los usuarios demo.

## Funcionalidades claves

- Cálculo de puntajes con penalización por intentos y bono por tiempo (`App\Services\ScoringService`).
- Ranking automático por período y categoría con exportes CSV/PDF.
- Dashboard contextual por rol (admin/coach vs estudiante) con métricas básicas.
- Validaciones de ventana de disponibilidad para evaluaciones e intentos.
- Observador de scores para mantener el ranking sincronizado.

## Exports de ranking

Desde la vista de rankings puedes generar reportes en CSV y PDF respetando el período y la skill seleccionada. Si prefieres hacerlo desde consola, puedes apuntar a las rutas autenticado:

```bash
curl -L -o rankings.csv "http://127.0.0.1:8000/rankings/export/csv?periodo_id=1"
curl -L -o rankings.pdf "http://127.0.0.1:8000/rankings/export/pdf?periodo_id=1"
```

Reemplaza `periodo_id` y añade `skill_id` según corresponda.

## Pruebas

Ejecuta la suite completa de PHPUnit con:

```bash
vendor/bin/phpunit
```

Las pruebas cubren los servicios de puntuación y ranking, accesos y exportes principales.

## Notas

- La zona horaria del sistema se maneja en `America/La_Paz` para reportes.
- El flag/hash de las evaluaciones utiliza MD5. Para un reto correcto, almacena `md5(flag_real)` en `flag_hash_eval`.
- `SYNAPSE_IRT_ENABLED` está disponible para futuras integraciones de IRT/IA.
