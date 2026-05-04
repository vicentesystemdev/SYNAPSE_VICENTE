@extends('layouts.dashboard')

@section('title', 'Plantillas de evaluaciones')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_admin')
@endsection

@section('content_header')
    Gestión de plantillas
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h1 class="h4">Vista index</h1>
            <p class="text-muted">Plantilla inicial para administrar plantillas de evaluaciones.</p>
        </div>
    </div>
@endsection
