@extends('layouts.dashboard')

@section('title', 'Registrar Nuevo Docente')

@section('content_header')
    <h1>Registrar Nuevo Docente</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@stop

@section('content')
    

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro de Docente</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.docentes.store') }}" method="POST">
                @csrf

                @include('components.forms.user-fields', ['emailPrefix' => 'doc', 'requiredApp' => false])

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar Docente</button>
                <a href="{{ route('admin.docentes.index') }}" class="btn btn-secondary"><i class="fas fa-ban"></i> Cancelar</a>
            </form>

            <div class="mt-4 p-3 border rounded" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24;">
                <p class="font-weight-bold">NOTA:</p>
                <p>SE PROPORCIONARÁ UNA CONTRASEÑA SIMPLE A CADA NUEVO USUARIO QUE SEA REGISTRADO POR UN ADMINISTRADOR, SI EL USUARIO DESEA PUEDE CAMBIAR SU CONTRASEÑA DESDE SU PERFIL.</p>
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('components.scripts.email-validation', ['emailPrefix' => 'doc'])
    @include('components.scripts.password-validation')
@stop
