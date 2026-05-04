@extends('layouts.dashboard')

@section('title', 'Resultados de Búsqueda')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content_header')
    <h1>Resultados de Búsqueda para: "{{ $searchTerm }}"</h1>
@stop

@section('content')
    <div class="row">
        @if($estudiantes->isNotEmpty())
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Estudiantes Encontrados</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Correo Electrónico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudiantes as $estudiante)
                                    <tr>
                                        <td>{{ $estudiante->NOM_USU }}</td>
                                        <td>{{ $estudiante->APP_USU }}</td>
                                        <td>{{ $estudiante->APM_USU }}</td>
                                        <td>{{ $estudiante->COR_USU }}</td>
                                        <td>
                                            {{-- Aquí puedes añadir enlaces a la vista/edición del estudiante --}}
                                            <a href="#" class="btn btn-sm btn-info">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($docentes->isNotEmpty())
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Docentes Encontrados</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Correo Electrónico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($docentes as $docente)
                                    <tr>
                                        <td>{{ $docente->NOM_USU }}</td>
                                        <td>{{ $docente->APP_USU }}</td>
                                        <td>{{ $docente->APM_USU }}</td>
                                        <td>{{ $docente->COR_USU }}</td>
                                        <td>
                                            {{-- Aquí puedes añadir enlaces a la vista/edición del docente --}}
                                            <a href="#" class="btn btn-sm btn-info">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($superadmins->isNotEmpty())
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Super Administradores Encontrados</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Correo Electrónico</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($superadmins as $superadmin)
                                    <tr>
                                        <td>{{ $superadmin->NOM_USU }}</td>
                                        <td>{{ $superadmin->APP_USU }}</td>
                                        <td>{{ $superadmin->APM_USU }}</td>
                                        <td>{{ $superadmin->COR_USU }}</td>
                                        <td>
                                            {{-- Aquí puedes añadir enlaces a la vista/edición del super administrador --}}
                                            <a href="#" class="btn btn-sm btn-info">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($estudiantes->isEmpty() && $docentes->isEmpty() && $superadmins->isEmpty())
            <div class="col-md-12">
                <div class="alert alert-warning">
                    No se encontraron resultados para "{{ $searchTerm }}".
                </div>
            </div>
        @endif
    </div>
@stop

@section('css')
    {{-- Añade CSS adicional si es necesario --}}
@stop

@section('js')
    <script> console.log('Resultados de búsqueda cargados!'); </script>
@stop
