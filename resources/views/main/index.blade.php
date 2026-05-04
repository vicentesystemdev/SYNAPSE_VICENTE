<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Menú principal</h2>
                <p class="text-sm text-gray-500">Selecciona un módulo para continuar.</p>
            </div>
            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-100 px-3 py-1 text-sm font-semibold text-indigo-700">
                <span aria-hidden="true">👤</span>
                {{ $user?->name }} — {{ implode(', ', $roles) ?: 'Sin rol asignado' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            @forelse ($menuSections as $section)
                <section class="space-y-4">
                    <header class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 text-white">
                            <span class="text-lg" aria-hidden="true">{{ $section['icon'] }}</span>
                        </span>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $section['title'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $section['description'] }}</p>
                        </div>
                    </header>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($section['items'] as $item)
                            <a href="{{ $item['route'] ? route($item['route']) : '#' }}"
                               class="group relative flex flex-col justify-between rounded-2xl border border-transparent bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg">
                                <div class="space-y-2">
                                    <span class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600">
                                        <span aria-hidden="true">{{ $item['icon'] }}</span>
                                        <span>{{ $item['tag'] }}</span>
                                    </span>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $item['title'] }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item['description'] }}</p>
                                </div>
                                <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600">
                                    Ir al módulo
                                    <i class="fas fa-arrow-right transform transition group-hover:translate-x-1"></i>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center">
                    <h3 class="text-lg font-semibold text-gray-900">No hay módulos disponibles</h3>
                    <p class="mt-2 text-sm text-gray-600">Solicita a un administrador que asigne un rol válido a tu cuenta.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
