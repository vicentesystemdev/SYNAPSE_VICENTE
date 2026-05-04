@extends('layouts.dashboard')

@section('title', 'Evaluaciones')

@section('sidebar_menu')
    @include('layouts.partials.sidebar_docente')
@endsection

@section('content_header')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <h1 class="text-3xl font-bold tracking-tight text-white/90">
                Gestión de Evaluaciones
            </h1>
            <p class="text-sm text-gray-400">
                Administra tus evaluaciones.
            </p>
        </div>

        <a href="{{ route('docente.evaluaciones.create') }}"
            class="inline-flex items-center justify-center rounded-lg bg-orange-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-orange-500/30 hover:bg-orange-500 transition border border-orange-500/50">
            <i class="fas fa-plus mr-2"></i> Nueva evaluación
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <!-- FILTROS -->
        <div class="rounded-xl border border-white/5 bg-gray-900/40 backdrop-blur-md px-4 py-4 shadow-xl space-y-4">
            <form method="GET" action="{{ route('docente.evaluaciones.index') }}" class="flex flex-wrap items-center gap-3">
                <select name="categoria_id" onchange="this.form.submit()"
                    class="rounded-lg border border-white/10 bg-gray-800/80 px-3 py-2 text-xs text-gray-300 focus:ring-1 focus:ring-orange-400 focus:border-orange-500/50 transition selection:bg-orange-500/20">
                    <option value="" class="bg-gray-800">Todas las áreas</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id_cat }}" {{ request('categoria_id') == $cat->id_cat ? 'selected' : '' }} class="bg-gray-800">
                            {{ $cat->nombre_cat }}
                        </option>
                    @endforeach
                </select>

                <select name="estado_eval" onchange="this.form.submit()"
                    class="rounded-lg border border-white/10 bg-gray-800/80 px-3 py-2 text-xs text-gray-300 focus:ring-1 focus:ring-orange-400 focus:border-orange-500/50 transition">
                    <option value="" class="bg-gray-800">Todos los estados</option>
                    <option value="2" {{ request('estado_eval') == '2' ? 'selected' : '' }} class="bg-gray-800">Publicada</option>
                    <option value="1" {{ request('estado_eval') == '1' ? 'selected' : '' }} class="bg-gray-800">Borrador</option>
                    <option value="0" {{ request('estado_eval') == '0' ? 'selected' : '' }} class="bg-gray-800">Archivada</option>
                </select>

                <a href="{{ route('docente.evaluaciones.index') }}" class="text-xs text-gray-500 hover:text-orange-400 underline transition">
                    Limpiar filtros
                </a>
            </form>
        </div>

        <!-- TABLA PRINCIPAL -->
        <div class="rounded-xl border border-white/5 bg-gray-900/60 backdrop-blur-md shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 text-xs">
                    <thead class="bg-white/5">
                        <tr class="text-gray-400 uppercase tracking-wider font-semibold text-[11px]">
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-left">Título</th>
                            <th class="px-4 py-3 text-left">Área</th>
                            <th class="px-4 py-3 text-left">Nivel</th>
                            <th class="px-4 py-3 text-left">Estado</th>
                            <th class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @forelse($evaluaciones as $evaluacion)
                            @php
                                $estado = $evaluacion->estado_eval;
                                $claseEstado = match ($estado) {
                                    2 => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                    1 => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                    0 => 'bg-gray-700/30 text-gray-400 border-gray-600/30',
                                    default => 'bg-gray-700/30 text-gray-400 border-gray-600/30',
                                };
                            @endphp
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-4 py-3 font-mono text-gray-500">
                                    #{{ str_pad($evaluacion->id_eval, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3 text-gray-200 font-medium">
                                    {{ $evaluacion->titulo_eval }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-md bg-white/10 px-2 py-1 text-[11px] font-medium text-gray-300 border border-white/5">
                                        {{ $evaluacion->categoria->nombre_cat ?? 'N/D' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-400">
                                    {{ $evaluacion->dificultad->nombre_dif ?? 'N/D' }}
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('docente.evaluaciones.toggle-status', $evaluacion) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="estado_eval" onchange="this.form.submit()"
                                            class="rounded-md border border-transparent px-2 py-1 text-[11px] font-medium focus:ring-1 focus:ring-orange-500 cursor-pointer {{ $claseEstado }} bg-transparent">
                                            <option value="1" {{ $estado == 1 ? 'selected' : '' }} class="bg-gray-800 text-gray-300">Borrador</option>
                                            <option value="2" {{ $estado == 2 ? 'selected' : '' }} class="bg-gray-800 text-gray-300">Publicada</option>
                                            <option value="0" {{ $estado == 0 ? 'selected' : '' }} class="bg-gray-800 text-gray-300">Archivada</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="{{ route('docente.evaluaciones.show', $evaluacion) }}"
                                        class="text-gray-500 hover:text-indigo-400 transition" title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('docente.evaluaciones.edit', $evaluacion) }}"
                                        class="text-gray-500 hover:text-amber-400 transition" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                                    No se encontraron evaluaciones con los filtros seleccionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINACION -->
            <div class="border-t border-white/5 px-4 py-3">
                {{ $evaluaciones->links() }}
            </div>
        </div>
    </div>
@endsection
