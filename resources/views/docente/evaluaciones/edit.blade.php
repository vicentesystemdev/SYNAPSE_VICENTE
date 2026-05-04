@extends('layouts.dashboard')

@section('title', 'Editar Evaluación')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl font-bold tracking-tight text-white/90">
            Editar Evaluación
        </h1>
        <p class="text-sm text-gray-400">
            Modificando: <span class="font-mono text-orange-400">{{ $evaluacion->titulo_eval }}</span>
        </p>
    </div>
@endsection

@section('content')
    <form action="{{ route('docente.evaluaciones.update', $evaluacion) }}" method="POST" enctype="multipart/form-data">
        @method('PATCH')
        @include('docente.evaluaciones._form', ['evaluacion' => $evaluacion])
    </form>
@endsection
