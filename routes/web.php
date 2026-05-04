<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{DashboardController, EvaluacionController, IntentoController, RankingController, ExportController, DemostracionController, AdminDashboardController, InfoPageController};
use App\Http\Controllers\Estudiante\EvaluacionEstudianteController;
use App\Http\Controllers\AdminDashboard\{AdminController, EstudianteController, DocenteController, AdminIrtReportesController, RoleController, IntentoController as AdminIntentoController, AuditoriaController};
use App\Http\Controllers\DocenteDashboard\{DocenteDashboardController, EstudianteController as DocenteEstudianteController};
use App\Http\Controllers\ProfileController;

Route::get('/', fn () => redirect()->route('login'));

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas para la gestión del perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para el panel de administración
    Route::middleware(['role:admin'])->prefix('reportes-irt')->name('admin.reportes_irt.')->group(function () {
        Route::get('/', [DemostracionController::class, 'index'])->name('index');
        Route::get('/get-student-data', [DemostracionController::class, 'getStudentData'])->name('getStudentData');
        Route::get('/get-markov-matrix', [DemostracionController::class, 'getMarkovMatrix'])->name('getMarkovMatrix');
        Route::get('/get-global-habilidad-distribution', [DemostracionController::class, 'getGlobalHabilidadDistribution'])->name('getGlobalHabilidadDistribution');
        Route::get('/get-growth-decay-history', [DemostracionController::class, 'getGrowthDecayHistory'])->name('getGrowthDecayHistory');
        Route::get('/search-students', [DemostracionController::class, 'searchStudents'])->name('searchStudents');
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Roles
        // Roles
        Route::resource('roles', RoleController::class)->names('roles');
        Route::put('roles/{role}/toggle-status', [RoleController::class, 'toggleStatus'])->name('roles.toggle-status');

        // Vistas directas
        Route::view('/panel/usuarios', 'admin.usuarios.index')->name('usuarios.index');
        Route::view('/panel/usuarios/nuevo', 'admin.usuarios.create')->name('usuarios.create');
        Route::view('/panel/usuarios/{usuario}', 'admin.usuarios.show')->name('usuarios.show');
        Route::view('/panel/usuarios/{usuario}/editar', 'admin.usuarios.edit')->name('usuarios.edit');
        Route::view('/configuracion', 'admin.configuracion.index')->name('configuracion.index');
        Route::view('/plantillas', 'admin.plantillas.index')->name('plantillas.index');
        Route::view('/plantillas/crear', 'admin.plantillas.create')->name('plantillas.create');
        Route::view('/plantillas/{plantilla}/editar', 'admin.plantillas.edit')->name('plantillas.edit');
        Route::view('/exportaciones', 'admin.exportaciones.index')->name('exportaciones.index');
        
        // Auditoría
        Route::get('/auditoria', [AuditoriaController::class, 'index'])->name('auditoria.index');

        // Intentos
        Route::get('/intentos', [AdminIntentoController::class, 'index'])->name('intentos.index');
        Route::get('/intentos/{intento}', [AdminIntentoController::class, 'show'])->name('intentos.show');
        Route::get('/intentos/export/pdf', [AdminIntentoController::class, 'exportPdf'])->name('intentos.exportPdf');

        // Rutas CRUD para Administradores
        Route::resource('admins', AdminController::class);
        Route::put('admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggle-status');
        Route::get('admins/export/pdf', [AdminController::class, 'exportPdf'])->name('admins.exportPdf');
        Route::get('admins/export/excel', [AdminController::class, 'exportExcel'])->name('admins.exportExcel');

        // Rutas CRUD para Estudiantes
        Route::resource('estudiantes', EstudianteController::class);
        Route::put('estudiantes/{estudiante}/toggle-status', [EstudianteController::class, 'toggleStatus'])->name('estudiantes.toggle-status');
        Route::get('estudiantes/export/pdf', [EstudianteController::class, 'exportPdf'])->name('estudiantes.exportPdf');
        Route::get('estudiantes/export/excel', [EstudianteController::class, 'exportExcel'])->name('estudiantes.exportExcel');

        // Rutas CRUD para Docentes
        Route::resource('docentes', DocenteController::class);
        Route::put('docentes/{docente}/toggle-status', [DocenteController::class, 'toggleStatus'])->name('docentes.toggle-status');
        Route::get('docentes/export/pdf', [DocenteController::class, 'exportPdf'])->name('docentes.exportPdf');
        Route::get('docentes/export/excel', [DocenteController::class, 'exportExcel'])->name('docentes.exportExcel');

        // Rutas CRUD para Intentos (gestionados por el administrador)
        Route::prefix('intentos')->name('intentos.')->group(function () {
            Route::get('/', [AdminIntentoController::class, 'index'])->name('index');
            Route::get('/{intento}', [AdminIntentoController::class, 'show'])->name('show');
            Route::get('/{intento}/export-pdf-show', [AdminIntentoController::class, 'exportPdfShow'])->name('exportPdfShow');
            Route::get('/export-pdf', [AdminIntentoController::class, 'exportPdf'])->name('exportPdf');
            Route::get('/{intento}/toggle-status', [AdminIntentoController::class, 'toggleStatus'])->name('toggleStatus');
        });
    });

    // Rutas para el panel del Docente
    Route::middleware(['role:docente'])->prefix('docente-dashboard')->name('docente.')->group(function () {
        Route::get('/', [DocenteDashboardController::class, 'index'])->name('dashboard');

        Route::get('/intentos', [DocenteDashboardController::class, 'intentos'])->name('intentos.index');
        Route::get('/intentos/export/pdf', [DocenteDashboardController::class, 'exportPdf'])->name('intentos.exportPdf');
        Route::get('/intentos/{intento}', [DocenteDashboardController::class, 'showIntento'])->name('intentos.show');
        Route::get('/intentos/{intento}/pdf', [DocenteDashboardController::class, 'exportPdfShow'])->name('intentos.exportPdfShow');
        // Route::view('/plantillas', 'docente.plantillas.index')->name('plantillas.index');
        // Route::view('/plantillas/crear', 'docente.plantillas.create')->name('plantillas.create');
        // Route::view('/plantillas/{plantilla}/editar', 'docente.plantillas.edit')->name('plantillas.edit');
        Route::get('/reportes-irt', [DocenteDashboardController::class, 'reportesIrt'])->name('reportes_irt.index');
        Route::get('/exportaciones', [DocenteDashboardController::class, 'exportaciones'])->name('exportaciones.index');

        // Resource for Docente Evaluaciones with distinct name prefix
        Route::resource('evaluaciones', EvaluacionController::class)
            ->names('evaluaciones')
            ->parameters(['evaluaciones' => 'evaluacion']);
        Route::patch('evaluaciones/{evaluacion}/toggle-status', [EvaluacionController::class, 'toggleStatus'])->name('evaluaciones.toggle-status');

        // Rutas AJAX para Reportes IRT (Reutilizando DemostracionController)
        Route::prefix('reportes-irt-data')->name('reportes_irt.')->group(function () {
            Route::get('/get-student-data', [DemostracionController::class, 'getStudentData'])->name('getStudentData');
            Route::get('/get-markov-matrix', [DemostracionController::class, 'getMarkovMatrix'])->name('getMarkovMatrix');
            Route::get('/get-global-habilidad-distribution', [DemostracionController::class, 'getGlobalHabilidadDistribution'])->name('getGlobalHabilidadDistribution');
            Route::get('/get-growth-decay-history', [DemostracionController::class, 'getGrowthDecayHistory'])->name('getGrowthDecayHistory');
            Route::get('/search-students', [DemostracionController::class, 'searchStudents'])->name('searchStudents');
        });

        // Rutas CRUD para Estudiantes (gestionados por el docente)
        Route::resource('estudiantes', DocenteEstudianteController::class);
        Route::put('estudiantes/{estudiante}/toggle-status', [DocenteEstudianteController::class, 'toggleStatus'])->name('estudiantes.toggle-status');
    });

    // Rutas para el panel del Estudiante
    Route::middleware(['role:estudiante', 'calibration'])->prefix('estudiante')->name('estudiante.')->group(function () {
        // Rutas de Calibración (Excepciones del Middleware)
        Route::prefix('calibracion')->name('calibracion.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Estudiante\CalibrationController::class, 'index'])->name('index');
            Route::post('/start', [\App\Http\Controllers\Estudiante\CalibrationController::class, 'start'])->name('start');
            Route::post('/skip', [\App\Http\Controllers\Estudiante\CalibrationController::class, 'skip'])->name('skip');
        });
        // Info Pages
        Route::get('/web-info', [InfoPageController::class, 'webInfo'])->name('web.info');
        Route::get('/crypto-info', [InfoPageController::class, 'cryptoInfo'])->name('crypto.info');
        Route::get('/stego-info', [InfoPageController::class, 'stegoInfo'])->name('stego.info');
        Route::get('/forens-info', [InfoPageController::class, 'forensInfo'])->name('forens.info');
        
        // New Info Pages Routes
        Route::get('/informacion/documentacion', [InfoPageController::class, 'documentacionInfo'])->name('informacion.documentacion');
        Route::get('/informacion/manual-estudiante', [InfoPageController::class, 'manualEstudianteInfo'])->name('informacion.manual_estudiante');
        Route::get('/informacion/manual-docente', [InfoPageController::class, 'manualDocenteInfo'])->name('informacion.manual_docente');
        Route::get('/informacion/politicas-evaluacion', [InfoPageController::class, 'politicasEvaluacionInfo'])->name('informacion.politicas_evaluacion');
        Route::get('/informacion/preguntas-frecuentes', [InfoPageController::class, 'preguntasFrecuentesInfo'])->name('informacion.preguntas_frecuentes');
        Route::get('/informacion/sobre-proyecto', [InfoPageController::class, 'sobreProyectoInfo'])->name('informacion.sobre_proyecto');
        Route::get('/informacion/proposito-academico', [InfoPageController::class, 'propositoAcademicoInfo'])->name('informacion.proposito_academico');
        Route::get('/informacion/modelo-evaluacion-adaptativa', [InfoPageController::class, 'modeloEvaluacionAdaptativaInfo'])->name('informacion.modelo_evaluacion_adaptativa');
        Route::get('/informacion/metodologia-referencias', [InfoPageController::class, 'metodologiaReferenciasInfo'])->name('informacion.metodologia_referencias');

        Route::prefix('evaluaciones')->name('evaluaciones.')->group(function () {
            Route::get('/', [EvaluacionEstudianteController::class, 'index'])->name('index');
            Route::get('/categorias', [EvaluacionEstudianteController::class, 'categorias'])->name('categorias');
            Route::get('/adaptativa/siguiente', [EvaluacionEstudianteController::class, 'siguienteAdaptativa'])->name('adaptativa.siguiente');
            Route::get('/categoria/{categoria}', [EvaluacionEstudianteController::class, 'porCategoria'])->name('por_categoria');
            Route::get('/{evaluacion}', [EvaluacionEstudianteController::class, 'show'])->name('show');
            Route::get('/{evaluacion}/realizar', [EvaluacionEstudianteController::class, 'realizar'])->name('realizar');
            Route::get('/{evaluacion}/recursos/{indice}', [EvaluacionEstudianteController::class, 'descargarRecurso'])->name('descargar_recurso');
        });

        Route::prefix('intentos')->name('intentos.')->group(function () {
            Route::get('/', [IntentoController::class, 'historial'])->name('index');
            Route::post('/{evaluacion}', [IntentoController::class, 'storeDesdeEstudiante'])->name('store');
        });

        Route::get('rankings', [RankingController::class, 'index'])->name('rankings.index');
        Route::get('rankings/export/csv', [ExportController::class, 'rankingsCsv'])->name('rankings.csv');
        Route::get('rankings/export/pdf', [ExportController::class, 'rankingsPdf'])->name('rankings.pdf');
    });

    // Rutas de evaluaciones - CRUD requiere rol admin|docente
    Route::middleware(['role:admin|docente'])->group(function () {
        Route::get('evaluaciones/create', [EvaluacionController::class, 'create'])->name('evaluaciones.create');
        Route::post('evaluaciones', [EvaluacionController::class, 'store'])->name('evaluaciones.store');
        Route::get('evaluaciones/{evaluacion}/edit', [EvaluacionController::class, 'edit'])->name('evaluaciones.edit');
        Route::patch('evaluaciones/{evaluacion}', [EvaluacionController::class, 'update'])->name('evaluaciones.update');
        Route::patch('evaluaciones/{evaluacion}/toggle-status', [EvaluacionController::class, 'toggleStatus'])->name('evaluaciones.toggle-status');
        Route::delete('evaluaciones/{evaluacion}', [EvaluacionController::class, 'destroy'])->name('evaluaciones.destroy');
    });
    
    // Rutas públicas para autenticados (sin restricción de rol)
    Route::get('evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    // Route::get('evaluaciones/{evaluacion}/realizar', [EvaluacionController::class, 'realizar'])->name('evaluaciones.realizar'); // Movida al grupo de estudiante
    Route::get('evaluaciones/{evaluacion}', [EvaluacionController::class, 'show'])->name('evaluaciones.show');
    
    Route::post('evaluaciones/{evaluacion}/entregar', [IntentoController::class, 'store'])
        ->name('evaluaciones.entregar');

    Route::get('rankings', [RankingController::class, 'index'])->name('rankings.index');
    Route::get('rankings/export/csv', [ExportController::class, 'rankingsCsv'])->name('rankings.csv');
    Route::get('rankings/export/pdf', [ExportController::class, 'rankingsPdf'])->name('rankings.pdf');
});
