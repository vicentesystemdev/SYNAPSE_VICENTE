@extends('layouts.dashboard')

@section('title', 'Editar Estudiante')

@section('content_header')
    <h1>Editar Estudiante: {{ $estudiante->name }}</h1>
@stop

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('docente.estudiantes.update', $estudiante->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('docente_dashbord.estudiantes.partials.form')
                <button type="submit" class="btn btn-primary">Actualizar Estudiante</button>
                <a href="{{ route('docente.estudiantes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop

@section('js')
    @include('components.scripts.email-validation', ['emailPrefix' => 'lpze'])
@stop
