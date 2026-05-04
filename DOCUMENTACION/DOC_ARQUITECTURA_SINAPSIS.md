# Documento de Arquitectura de Synapse

## 1. Resumen general del sistema
Synapse es una plataforma Laravel enfocada en gestionar retos de ciberseguridad/evaluaciones con analíticas avanzadas (IRT, cadenas de Markov y ranking EMA) para tres tipos de usuarios: administradores, docentes y estudiantes. El `DashboardController` centraliza la experiencia presentando un menú dinámico por rol y redirigiendo a vistas específicas bajo `resources/views/main`, `admin/`, `docente/` y `estudiante/` según permisos asignados con Spatie Roles.【F:app/Http/Controllers/DashboardController.php†L23-L124】【F:resources/views/main/index.blade.php†L1-L38】

Los módulos principales expuestos en las vistas ya reorganizadas son:
- **Usuarios/Roles:** CRUD de administradores, docentes y estudiantes dentro de `resources/views/admin/usuarios` y equivalentes docentes, respaldados por los controladores `AdminDashboard\*Controller` y validaciones de prefijo de correo.【F:routes/web.php†L21-L44】【F:app/Http/Controllers/AdminDashboard/AdminController.php†L16-L162】
- **Configuraciones/Plantillas:** Vistas stub en `admin/configuracion` y `admin/plantillas` (también en `docente/plantillas`) listas para formularios especializados usando el layout `layouts.dashboard`.【F:routes/web.php†L26-L55】【F:resources/views/layouts/dashboard.blade.php†L1-L70】
- **Evaluaciones e intentos:** `EvaluacionController`, `IntentoController` y los modelos `Evaluacion`, `Intento`, `Score` administran el ciclo de vida de retos y envíos, aplicando validaciones de ventana de publicación y cálculo de puntajes adaptativos.【F:app/Http/Controllers/EvaluacionController.php†L19-L176】【F:app/Http/Controllers/IntentoController.php†L19-L71】【F:app/Models/Evaluacion.php†L12-L56】
- **Rankings y Exportaciones:** `RankingController` y `ExportController` consumen `RankingService`/`Score` para construir tablas por período/categoría y descargar CSV/PDF.【F:app/Http/Controllers/RankingController.php†L19-L137】【F:app/Http/Controllers/ExportController.php†L18-L87】【F:app/Services/RankingService.php†L13-L71】
- **Reportes IRT/Analítica:** Vistas stub (`admin/reportes_irt`, `docente/reportes_irt`) y el `DemostracionController` apoyado en `IrtService`, `ItemSelectorService` y `MarkovService` muestran potencial del scoring adaptativo, listando estudiantes por niveles y evaluaciones recomendadas.【F:resources/views/admin/reportes_irt/index.blade.php†L1-L18】【F:resources/views/docente/reportes_irt/index.blade.php†L1-L17】【F:app/Http/Controllers/DemostracionController.php†L12-L92】
- **Auditoría y perfil:** Plantillas base en `admin/auditoria` y `estudiante/perfil`, con `ProfileController` para edición básica y los controladores de autenticación/registro provistos por Breeze reforzando el flujo de verificación y reset de contraseñas.【F:resources/views/admin/auditoria/index.blade.php†L1-L18】【F:app/Http/Controllers/ProfileController.php†L17-L58】【F:app/Http/Controllers/Auth/AuthenticatedSessionController.php†L13-L44】

## 2. Mapa de rutas por rol
Todas las rutas viven en `routes/web.php` y se agrupan por middleware `role`. A continuación se resumen en tablas.

### Admin
| Ruta (URI) | Nombre | Método | Controlador@acción | Vista Blade | Middleware |
| --- | --- | --- | --- | --- | --- |
| `/admin/dashboard` | `admin.dashboard` | GET | `AdminDashboardController@index` | `admin/dashboard/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L17-L19】【F:app/Http/Controllers/AdminDashboardController.php†L18-L49】 |
| `/admin/dashboard/demostracion` | `admin.dashboard.demostracion` | GET | `DemostracionController@index` | `dashboard/demostracion.blade.php` (renderizado con datos IRT) | `auth`, `role:admin`【F:routes/web.php†L18-L20】【F:app/Http/Controllers/DemostracionController.php†L12-L92】 |
| `/admin/panel/usuarios` | `admin.usuarios.index` | GET | Route::view | `admin/usuarios/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L21-L24】 |
| `/admin/panel/usuarios/nuevo` | `admin.usuarios.create` | GET | Route::view | `admin/usuarios/create.blade.php` | `auth`, `role:admin`【F:routes/web.php†L21-L24】 |
| `/admin/panel/usuarios/{usuario}` | `admin.usuarios.show` | GET | Route::view | `admin/usuarios/show.blade.php` | `auth`, `role:admin`【F:routes/web.php†L21-L24】 |
| `/admin/panel/usuarios/{usuario}/editar` | `admin.usuarios.edit` | GET | Route::view | `admin/usuarios/edit.blade.php` | `auth`, `role:admin`【F:routes/web.php†L21-L24】 |
| `/admin/roles` | `admin.roles.index` | GET | Route::view | `admin/roles/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L25-L25】 |
| `/admin/configuracion` | `admin.configuracion.index` | GET | Route::view | `admin/configuracion/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L26-L26】 |
| `/admin/plantillas` | `admin.plantillas.index` | GET | Route::view | `admin/plantillas/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L27-L30】 |
| `/admin/plantillas/crear` | `admin.plantillas.create` | GET | Route::view | `admin/plantillas/create.blade.php` | `auth`, `role:admin`【F:routes/web.php†L27-L30】 |
| `/admin/plantillas/{plantilla}/editar` | `admin.plantillas.edit` | GET | Route::view | `admin/plantillas/edit.blade.php` | `auth`, `role:admin`【F:routes/web.php†L27-L30】 |
| `/admin/intentos` | `admin.intentos.index` | GET | Route::view | `admin/intentos/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L30-L31】 |
| `/admin/reportes-irt` | `admin.reportes_irt.index` | GET | Route::view | `admin/reportes_irt/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L31-L32】 |
| `/admin/exportaciones` | `admin.exportaciones.index` | GET | Route::view | `admin/exportaciones/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L32-L33】 |
| `/admin/auditoria` | `admin.auditoria.index` | GET | Route::view | `admin/auditoria/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L33-L33】 |
| `/admin/admins` | `admin.admins.index` | GET | `AdminController@index` | `admin/usuarios/admins/index.blade.php` | `auth`, `role:admin`【F:routes/web.php†L35-L37】【F:app/Http/Controllers/AdminDashboard/AdminController.php†L16-L63】 |
| `/admin/admins/create` | `admin.admins.create` | GET | `AdminController@create` | `admin/usuarios/admins/create.blade.php` | `auth`, `role:admin`【F:app/Http/Controllers/AdminDashboard/AdminController.php†L22-L28】 |
| `/admin/admins` | `admin.admins.store` | POST | `AdminController@store` | redirección a índice tras crear | `auth`, `role:admin`【F:routes/web.php†L35-L37】【F:app/Http/Controllers/AdminDashboard/AdminController.php†L30-L63】 |
| `/admin/admins/{admin}` | `admin.admins.show` | GET | `AdminController@show` | `admin/usuarios/admins/show.blade.php` | `auth`, `role:admin`【F:app/Http/Controllers/AdminDashboard/AdminController.php†L65-L72】 |
| `/admin/admins/{admin}/edit` | `admin.admins.edit` | GET | `AdminController@edit` | `admin/usuarios/admins/edit.blade.php` | `auth`, `role:admin`【F:app/Http/Controllers/AdminDashboard/AdminController.php†L74-L83】 |
| `/admin/admins/{admin}` | `admin.admins.update` | PUT/PATCH | `AdminController@update` | redirección tras actualización | `auth`, `role:admin`【F:app/Http/Controllers/AdminDashboard/AdminController.php†L85-L131】 |
| `/admin/admins/{admin}` | `admin.admins.destroy` | DELETE | `AdminController@destroy` | redirección | `auth`, `role:admin`【F:app/Http/Controllers/AdminDashboard/AdminController.php†L153-L162】 |
| `/admin/admins/{admin}/toggle-status` | `admin.admins.toggle-status` | PUT | `AdminController@toggleStatus` | redirección (flash) | `auth`, `role:admin`【F:routes/web.php†L35-L38】【F:app/Http/Controllers/AdminDashboard/AdminController.php†L133-L151】 |
| `/admin/estudiantes` (REST) | `admin.estudiantes.*` | GET/POST/etc. | `AdminDashboard\EstudianteController@*` | vistas en `admin/usuarios/estudiantes/*.blade.php` | `auth`, `role:admin`【F:routes/web.php†L39-L42】【F:app/Http/Controllers/AdminDashboard/EstudianteController.php†L17-L163】 |
| `/admin/estudiantes/{estudiante}/toggle-status` | `admin.estudiantes.toggle-status` | PUT | `EstudianteController@toggleStatus` | redirección | `auth`, `role:admin`【F:routes/web.php†L39-L42】【F:app/Http/Controllers/AdminDashboard/EstudianteController.php†L134-L152】 |
| `/admin/docentes` (REST) | `admin.docentes.*` | GET/POST/etc. | `AdminDashboard\DocenteController@*` | vistas en `admin/usuarios/docentes/*.blade.php` | `auth`, `role:admin`【F:routes/web.php†L42-L43】【F:app/Http/Controllers/AdminDashboard/DocenteController.php†L17-L163】 |
| `/admin/docentes/{docente}/toggle-status` | `admin.docentes.toggle-status` | PUT | `DocenteController@toggleStatus` | redirección | `auth`, `role:admin`【F:routes/web.php†L42-L43】【F:app/Http/Controllers/AdminDashboard/DocenteController.php†L134-L152】 |

### Docente
| Ruta | Nombre | Método | Controlador@acción | Vista | Middleware |
| --- | --- | --- | --- | --- | --- |
| `/docente-dashboard` | `docente.dashboard` | GET | `DocenteDashboardController@index` | `docente/dashboard/index.blade.php` | `auth`, `role:docente`【F:routes/web.php†L46-L50】【F:app/Http/Controllers/DocenteDashboard/DocenteDashboardController.php†L17-L39】 |
| `/docente-dashboard/intentos` | `docente.intentos.index` | GET | Route::view | `docente/intentos/index.blade.php` | `auth`, `role:docente`【F:routes/web.php†L50-L55】 |
| `/docente-dashboard/plantillas` | `docente.plantillas.index` | GET | Route::view | `docente/plantillas/index.blade.php` | `auth`, `role:docente`【F:routes/web.php†L50-L54】 |
| `/docente-dashboard/plantillas/crear` | `docente.plantillas.create` | GET | Route::view | `docente/plantillas/create.blade.php` | `auth`, `role:docente`【F:routes/web.php†L50-L54】 |
| `/docente-dashboard/plantillas/{id}/editar` | `docente.plantillas.edit` | GET | Route::view | `docente/plantillas/edit.blade.php` | `auth`, `role:docente`【F:routes/web.php†L50-L54】 |
| `/docente-dashboard/reportes-irt` | `docente.reportes_irt.index` | GET | Route::view | `docente/reportes_irt/index.blade.php` | `auth`, `role:docente`【F:routes/web.php†L54-L55】【F:resources/views/docente/reportes_irt/index.blade.php†L1-L17】 |
| `/docente-dashboard/exportaciones` | `docente.exportaciones.index` | GET | Route::view | `docente/exportaciones/index.blade.php` | `auth`, `role:docente`【F:routes/web.php†L54-L55】 |
| `/docente-dashboard/estudiantes` (REST) | `docente.estudiantes.*` | GET/POST/etc. | `DocenteDashboard\EstudianteController@*` | vistas en `docente/estudiantes/*.blade.php` | `auth`, `role:docente`【F:routes/web.php†L57-L59】【F:app/Http/Controllers/DocenteDashboard/EstudianteController.php†L17-L144】 |
| `/docente-dashboard/estudiantes/{id}/toggle-status` | `docente.estudiantes.toggle-status` | PUT | `DocenteDashboard\EstudianteController@toggleStatus` | redirección | `auth`, `role:docente`【F:routes/web.php†L57-L59】【F:app/Http/Controllers/DocenteDashboard/EstudianteController.php†L115-L133】 |

### Estudiante
| Ruta | Nombre | Método | Controlador@acción | Vista | Middleware |
| --- | --- | --- | --- | --- | --- |
| `/mi-dashboard` | `estudiante.dashboard` | GET | `DashboardController@studentOverview` | `estudiante/dashboard/index.blade.php` | `auth`, `role:estudiante`【F:routes/web.php†L62-L64】【F:app/Http/Controllers/DashboardController.php†L104-L184】 |
| `/mis-intentos` | `estudiante.intentos.index` | GET | Route::view | `estudiante/intentos/index.blade.php` | `auth`, `role:estudiante`【F:routes/web.php†L62-L65】 |

### Rutas compartidas
- **Evaluaciones CRUD** (`/evaluaciones/*`): lectura disponible para todo usuario autenticado, mientras que crear/editar/borrar exige `role:admin|docente`. Renderizan `docente.evaluaciones.*` para gestores y `estudiante.evaluaciones.*` para alumnos.【F:routes/web.php†L67-L80】【F:app/Http/Controllers/EvaluacionController.php†L19-L176】
- **Intentos** (`POST /evaluaciones/{evaluacion}/entregar`): único endpoint para registrar envíos, protegido sólo por `auth` dado que la pertenencia al reto ya valida permisos dentro del `IntentoController`.【F:routes/web.php†L81-L82】【F:app/Http/Controllers/IntentoController.php†L19-L71】
- **Rankings y exportaciones** (`/rankings`, `/rankings/export/*`): comparten controlador pero el layout cambia según rol (`admin/docente/estudiante`).【F:routes/web.php†L84-L86】【F:app/Http/Controllers/RankingController.php†L41-L59】

## 3. Descripción de controladores
A continuación se listan los controladores y métodos públicos relevantes. Todos heredan del `Controller` base (stub en `app/Http/Controllers/Controller.php`).【F:app/Http/Controllers/Controller.php†L1-L7】

### DashboardController
- `index()`: Construye el menú principal tomando los roles del usuario autenticado y renderiza `main.index`. Depende de `Auth` y `RankingService` para poblar enlaces contextuales.【F:app/Http/Controllers/DashboardController.php†L23-L101】
- `studentOverview()`: Restringido a estudiantes, revisa si debe redirigir a una evaluación demo y prepara estadísticas invocando `buildStudentDashboard()`; usa modelos `Periodo`, `Intento`, `Ranking`, `Score`, `EstHabilidad` y vista `estudiante.dashboard.index`.【F:app/Http/Controllers/DashboardController.php†L104-L184】
- Métodos privados `buildStudentDashboard`, `resolveDemoEvaluacion`, `pickDemoEvaluacion` y `orderDemoCandidates`: recalculan ranking por período y seleccionan evaluaciones demo analizando metadata JSON (servicios `RankingService`).【F:app/Http/Controllers/DashboardController.php†L126-L227】

### AdminDashboardController
- `index()`: Obtiene el período activo, recalcula ranking, genera top 5 y heatmap de puntajes (modelos `Periodo`, `Score`, `Evaluacion`, `User`) para `admin.dashboard.index`. Ideal para añadir más tarjetas sin modificar lógica en vistas.【F:app/Http/Controllers/AdminDashboardController.php†L18-L49】

### AdminDashboard\AdminController / DocenteController / EstudianteController
- Cada controlador REST maneja un tipo de usuario con validaciones específicas de email/prefix, asignación de roles (`Spatie\Role`), toggles de estado y vistas dentro de `admin/usuarios/*`. Todas las operaciones de escritura redirigen al índice con mensajes flash para mantener la lógica en controladores y evitar duplicación de formularios en vistas (apoyadas por el componente `components/forms/user-fields`).【F:app/Http/Controllers/AdminDashboard/AdminController.php†L16-L162】【F:app/Http/Controllers/AdminDashboard/DocenteController.php†L17-L163】【F:app/Http/Controllers/AdminDashboard/EstudianteController.php†L17-L163】【F:resources/views/components/forms/user-fields.blade.php†L1-L54】

### DocenteDashboardController & DocenteDashboard\EstudianteController
- `DocenteDashboardController@index` replica la lógica de resumen de ranking (sin filtrar todavía por cursos) y sirve `docente.dashboard.index` como punto de extensión para métricas docentes.【F:app/Http/Controllers/DocenteDashboard/DocenteDashboardController.php†L17-L39】
- El controlador de estudiantes permite a cada docente dar de alta, editar y dar de baja alumnos usando el mismo set de validaciones que el admin pero restringido a su prefijo. Sus vistas viven bajo `docente/estudiantes`.【F:app/Http/Controllers/DocenteDashboard/EstudianteController.php†L17-L144】

### DemostracionController
- `index()`: Consulta estudiantes con `theta` calculado, agrupa por nivel, pide recomendaciones a `ItemSelectorService` (que a su vez usa `IrtService` y `MarkovService`) y muestra la demo en la vista `dashboard.demostracion`. Este flujo ilustra cómo extender reportes IRT sin duplicar vistas principales.【F:app/Http/Controllers/DemostracionController.php†L12-L92】【F:app/Services/ItemSelectorService.php†L17-L139】【F:app/Services/MarkovService.php†L13-L112】

### EvaluacionController
- `index()`: Lista evaluaciones con filtros dinámicos y cambia de vista (docente vs. estudiante) según rol actual; utiliza `Evaluacion`, `Categoria` y relaciones cargadas con `withCount` para estadísticas rápidas.【F:app/Http/Controllers/EvaluacionController.php†L19-L40】
- `create()/edit()`: Preparan catálogos (categorías, dificultades, períodos, docentes) y envían formularios a las vistas `docente.evaluaciones.*`.【F:app/Http/Controllers/EvaluacionController.php†L42-L50】【F:app/Http/Controllers/EvaluacionController.php†L153-L161】
- `store()/update()/destroy()`: Persisten datos validados (`StoreEvaluacionRequest`, `UpdateEvaluacionRequest`) y usan `assertVentanaDisponible()` para impedir publicación fuera de ventana activa.【F:app/Http/Controllers/EvaluacionController.php†L52-L197】
- `realizar()/show()`: Preparan estadísticas de intentos por usuario, validan disponibilidad temporal y muestran los dashboards en `estudiante.evaluaciones.realizar` y `estudiante.evaluaciones.show`.【F:app/Http/Controllers/EvaluacionController.php†L61-L151】

### IntentoController
- `store()`: Valida ventana de entrega, chequea la flag con `FlagService`, crea el intento, calcula latencia y llama a `ScoringService::procesarIntento` para registrar `Score`/`Rendimiento`, redirigiendo con mensajes contextualizados. Única vía para registrar envíos.【F:app/Http/Controllers/IntentoController.php†L19-L71】

### RankingController & ExportController
- `RankingController@index` arma filtros de período/categoría, recalcula ranking en caliente y selecciona la vista según rol. Sus métodos `exportCsv` y `exportPdf` generan streams y PDFs usando `RankingService` y DomPDF.【F:app/Http/Controllers/RankingController.php†L19-L137】
- `ExportController` ofrece descargas con validación obligatoria de período, compartiendo el dataset con el controlador de ranking para no duplicar lógica.【F:app/Http/Controllers/ExportController.php†L18-L87】

### ProfileController
- `edit`, `update`, `destroy` cubren edición básica del perfil, invalidación de email y eliminación de cuenta apoyándose en las vistas `estudiante/perfil/edit`. Amplía los flujos de Breeze para personalización mínima sin mezclar lógica en Blade.【F:app/Http/Controllers/ProfileController.php†L17-L58】

### Api\DemoApiController
- Exposición REST orientada a demos: `start` entrega metadatos/IRT para una evaluación, `submitAttempt` crea intentos usando `ScoringService` y retorna el cálculo, `userScores` resume `theta` y últimos `Score`. Ideal para integraciones externas que quieran probar la IA sin tocar vistas internas.【F:app/Http/Controllers/Api/DemoApiController.php†L13-L83】【F:app/Http/Controllers/Api/DemoApiController.php†L85-L134】

### Controladores de autenticación (Breeze)
- `AuthenticatedSessionController`, `RegisteredUserController`, `ConfirmablePasswordController`, `PasswordController`, `PasswordResetLinkController`, `NewPasswordController`, `EmailVerificationPromptController`, `EmailVerificationNotificationController` y `VerifyEmailController` gestionan login, registro (incluyendo selección de rol y campos paternos), confirmación, cambios de contraseña y verificación de correo. Todos usan vistas en `resources/views/auth` y redirigen al dashboard tras cada flujo exitoso, garantizando que los usuarios bloqueados (`activo_usu=false`) sean rechazados tras autenticarse.【F:app/Http/Controllers/Auth/AuthenticatedSessionController.php†L13-L44】【F:app/Http/Controllers/Auth/RegisteredUserController.php†L19-L57】【F:app/Http/Controllers/Auth/PasswordController.php†L12-L24】【F:app/Http/Controllers/Auth/PasswordResetLinkController.php†L13-L35】【F:app/Http/Controllers/Auth/NewPasswordController.php†L17-L55】【F:app/Http/Controllers/Auth/EmailVerificationNotificationController.php†L9-L19】

## 4. Relación Modelo ↔ Controlador ↔ Vista
- **Evaluaciones:** Rutas `/evaluaciones*` → `EvaluacionController@{index,create,...}` → Modelos `Evaluacion`, `Categoria`, `Dificultad`, `Periodo`, `Score` → servicios internos (`assertVentanaDisponible`) → Vistas `docente/evaluaciones/*` para gestión y `estudiante/evaluaciones/*` para consumo. Los docentes/administradores deben ampliar lógica en el controlador, no en Blade, siguiendo el patrón actual.【F:app/Http/Controllers/EvaluacionController.php†L19-L197】【F:resources/views/docente/evaluaciones/index.blade.php†L1-L33】
- **Intentos/Scoring:** `POST /evaluaciones/{evaluacion}/entregar` → `IntentoController@store` → Modelos `Intento`, `Score`, `Rendimiento` + servicios `ScoringService`, `IrtService`, `MarkovService`, `LogisticInitService` → sin vista (redirige a `evaluaciones.*`). El cálculo de puntajes y theta ocurre exclusivamente en `ScoringService` para aislar la lógica matemática.【F:app/Http/Controllers/IntentoController.php†L19-L71】【F:app/Services/ScoringService.php†L23-L107】
- **Rankings:** `/rankings` → `RankingController@index` → `RankingService` (que opera sobre modelos `Score` y `Ranking`) → vistas `admin.rankings.index`, `docente.rankings.index`, `estudiante.rankings.index` reutilizando filtros comunes.【F:app/Http/Controllers/RankingController.php†L19-L59】【F:app/Services/RankingService.php†L13-L71】
- **Exportaciones:** `/rankings/export/*` → `ExportController@rankingsCsv/Pdf` → mismos servicios/modelos que ranking → descargas invocadas desde vistas `admin/exportaciones/index` o `docente/exportaciones/index` (plantillas stub).【F:routes/web.php†L32-L33】【F:app/Http/Controllers/ExportController.php†L18-L87】【F:resources/views/admin/exportaciones/index.blade.php†L1-L16】
- **Perfil:** `/profile` (gestionado por Breeze) → `ProfileController` → modelo `User` → vista `estudiante/perfil/edit`. Todo cambio de lógica debe hacerse en el controlador para mantener la vista como formulario pasivo.【F:app/Http/Controllers/ProfileController.php†L17-L38】
- **Auditoría:** `/admin/auditoria` → Route::view → plantilla `admin/auditoria/index` que hereda `layouts.dashboard`. Para registrar eventos reales se espera un futuro `AuditLogController`, pero la plantilla ya define tarjetas y copy que los módulos pueden reutilizar.【F:routes/web.php†L33-L33】【F:resources/views/admin/auditoria/index.blade.php†L1-L18】

## 5. Ubicación y responsabilidad de los componentes Blade
- `resources/views/components/forms`: contiene piezas reutilizables para formularios complejos, como `user-fields`, que empaqueta etiquetas, validaciones HTML y mensajes dinámicos para nombres, apellidos, correos con prefijos obligatorios y requisitos de contraseña. Se debe invocar desde cualquier formulario CRUD de usuarios para evitar duplicaciones.【F:resources/views/components/forms/user-fields.blade.php†L1-L54】
- `resources/views/components/tables`, `components/cards`, `components/alerts`, `components/scripts`: directorios listados en el árbol de componentes (actualmente con plantillas genéricas o esperando ampliaciones). Úselos para macro-componentes (tablas responsive, cards de métricas, alertas estandarizadas) antes de crear nuevas vistas completas; el layout `x-app-layout` y `layouts.dashboard` ya esperan estos componentes para mantener consistencia.【5f19cb†L1-L6】
- `resources/views/layouts/dashboard.blade.php`: layout AdminLTE empleado por admin/docente; incluye navbar, sidebar, slots `sidebar_menu`, `content_header` y `content`, por lo que cualquier vista bajo `admin/` o `docente/` debe extenderlo para aprovechar scripts comunes y estilos de AdminLTE.【F:resources/views/layouts/dashboard.blade.php†L1-L70】

Ejemplo de uso recomendado: al crear un nuevo formulario de gestión (p.ej. “Asignar badges”), extender `layouts.dashboard`, incluir el componente `components.forms.user-fields` si aplica y renderizar datos en tarjetas o tablas reutilizando los directorios mencionados.

## 6. Convenciones para el equipo
1. **Nomenclatura de vistas:** Siga el patrón `rol/modulo/accion.blade.php`. Existen ejemplos claros como `docente/evaluaciones/index.blade.php` y `admin/exportaciones/index.blade.php`; cualquier nueva pantalla debe ubicarse dentro de la carpeta del rol que la consume para mantener el enrutamiento simplificado.【F:resources/views/docente/evaluaciones/index.blade.php†L1-L33】【F:resources/views/admin/exportaciones/index.blade.php†L1-L16】
2. **Definición de rutas:** Agrupe nuevas rutas dentro del bloque y prefijo del rol correspondiente en `routes/web.php`, usando `->name('rol.')` para mantener nombres consistentes. Para recursos complejos utilice `Route::resource` y agregue endpoints complementarios (`toggle-status`, exportaciones) dentro del mismo grupo.【F:routes/web.php†L17-L65】
3. **Reutilización de controladores:** Antes de crear un controlador nuevo, evalúe si existe uno especializado (p.ej. `AdminDashboard\DocenteController`) que pueda ampliarse con métodos adicionales. Agregar métodos pequeños (reportes filtrados, acciones masivas) es preferible a duplicar controladores o mover lógica a Blade.【F:app/Http/Controllers/AdminDashboard/DocenteController.php†L17-L163】
4. **Componentes Blade antes que HTML duplicado:** Use `components/forms`, `components/alerts`, etc. para uniformar estilos. Si un componente aún no existe (por ejemplo en `components/tables`), créelo allí y compártalo entre vistas en lugar de replicar tablas manuales.【5f19cb†L1-L6】
5. **Lógica de negocio en Services:** Cualquier cálculo complejo debe residir en `app/Services` (e.g., `RankingService`, `ScoringService`, `ItemSelectorService`). Si se necesita una nueva métrica de ranking o un algoritmo de recomendación, añada un servicio o extienda los existentes, luego inyéctelo en el controlador pertinente via constructor. Evite colocar cálculos en Blade o Jobs sin un servicio intermediario.【F:app/Services/RankingService.php†L13-L71】【F:app/Services/ScoringService.php†L23-L107】
6. **Middleware/políticas:** Aproveche los bloques `Route::middleware(['role:...'])` ya definidos. Si un módulo es compartido, agregue middleware específicos en el controlador o utiliza políticas de Laravel para validar acceso sobre modelos, en lugar de replicar vistas para cada rol.【F:routes/web.php†L17-L87】

## 7. Puntos de extensión recomendados
- **Reportes de rendimiento avanzados:** Parta de `RankingController` + vistas `admin/rankings`/`docente/rankings`; agregue filtros o columnas usando datos del `RankingService` para no recalcular en Blade. Para exportaciones personalizadas extienda `ExportController` o añada nuevos métodos en las vistas de `admin/exportaciones`/`docente/exportaciones`.【F:app/Http/Controllers/RankingController.php†L19-L137】【F:resources/views/admin/exportaciones/index.blade.php†L1-L16】
- **Reportes IRT y demostraciones:** Las vistas `admin/reportes_irt/index` y `docente/reportes_irt/index` son stubs diseñadas para incorporar gráficos o tablas provenientes de `IrtService`, `ItemSelectorService` y `MarkovService`. Use `DemostracionController` como referencia sobre cómo extraer datos y agrupar por nivel sin tocar las vistas principales.【F:resources/views/admin/reportes_irt/index.blade.php†L1-L18】【F:resources/views/docente/reportes_irt/index.blade.php†L1-L17】【F:app/Http/Controllers/DemostracionController.php†L12-L92】
- **Auditoría y Logs:** `admin/auditoria/index` ya define copy y contenedor. Para implementar el tracking real, cree un `AuditLog` model/controller y renderice en esta vista, manteniendo el layout `layouts.dashboard` para coherencia UI.【F:resources/views/admin/auditoria/index.blade.php†L1-L18】
- **Flujo de onboarding estudiantil:** `DocenteDashboard\EstudianteController` comparte validaciones con el admin. Para añadir importaciones masivas o filtros específicos de curso, extienda este controlador y reutilice el componente `user-fields` para no replicar formularios.【F:app/Http/Controllers/DocenteDashboard/EstudianteController.php†L17-L144】【F:resources/views/components/forms/user-fields.blade.php†L1-L54】
- **Integraciones externas:** `Api\DemoApiController` ya conecta evaluaciones, intentos y scoring. Nuevas APIs (por ejemplo, dashboards móviles) deben partir de este controlador o crear otros dentro de `App\Http\Controllers\Api` apoyándose en los mismos servicios adaptativos para mantener la fuente única de verdad.【F:app/Http/Controllers/Api/DemoApiController.php†L13-L134】

Siguiendo estas pautas, el equipo podrá agregar funcionalidades respetando la separación por rol, evitando duplicidad de vistas y manteniendo la lógica de negocio en los servicios y controladores existentes.
