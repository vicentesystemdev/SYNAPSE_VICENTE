@extends('layouts.dashboard')

@section('title', 'Nueva Evaluación')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-bold tracking-tight text-white/90">
            Nueva Evaluación
        </h1>
        <p class="text-sm text-gray-400">
            Crea un nuevo desafío CTF para los estudiantes.
        </p>
    </div>
@endsection

@section('content')
    <form action="{{ route('docente.evaluaciones.store') }}" method="POST" enctype="multipart/form-data">
        @include('docente.evaluaciones._form', ['evaluacion' => null])
    </form>
@endsection
