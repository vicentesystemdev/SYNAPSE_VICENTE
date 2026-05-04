@extends('layouts.dashboard')

@section('title', 'Bienvenida SuperAdmin')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content_header')
    <h1>Bienvenido al Panel de SuperAdministrador</h1>
@stop

@section('content')
    <div class="jumbotron jumbotron-fluid bg-info text-white text-center py-5 shadow-sm">
        <div class="container">
            <h1 class="display-4">Bienvenido al Panel de SuperAdministrador</h1>
            <p class="lead">Es un placer tenerte de vuelta. Desde aquí tienes el control total del sistema.</p>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">¡Hola, SuperAdministrador!</h3>
                    </div>
                    <div class="card-body">
                        <p>Utiliza el menú lateral para navegar por las diferentes secciones y gestionar:</p>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="info-box bg-gradient-success">
                                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Estudiantes Registrados</span>
                                        <span class="info-box-number">Gestionar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-gradient-info">
                                    <span class="info-box-icon"><i class="fas fa-user-graduate"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Docentes Registrados</span>
                                        <span class="info-box-number">Gestionar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-gradient-warning">
                                    <span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Super Administradores Registrados</span>
                                        <span class="info-box-number">Gestionar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Aquí puedes añadir CSS adicional si es necesario --}}
@stop

@section('js')
    <script> console.log('¡Bienvenido SuperAdmin!'); </script>
@stop

