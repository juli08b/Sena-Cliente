@extends('layouts.dashboard')

@section('title', 'Ambientes de formación')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="panel-section-title mb-1">Ambientes de formación</h1>
            <p class="text-muted mb-0" style="font-size: 0.86rem;">
                <i class="bi bi-building me-1"></i>Ambientes registrados: {{ $trainingCenters->count() }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('training-centers.index') }}" class="btn btn-outline-success fw-semibold">
                <i class="bi bi-house-door me-1"></i>Inicio
            </a>
            <a href="{{ route('training-centers.create') }}" class="btn btn-success fw-semibold">
                <i class="bi bi-plus-lg me-1"></i>Nuevo ambiente
            </a>
        </div>
    </div>

    @include('includes.flash')

    @if ($trainingCenters->isEmpty())
        <div class="panel-card p-4 text-center">
            <div class="text-muted mb-2"><i class="bi bi-inbox" style="font-size: 2rem;"></i></div>
            <p class="mb-1 fw-semibold">No hay ambientes para mostrar por el momento.</p>
            <a href="{{ route('training-centers.create') }}" class="btn btn-success btn-sm fw-semibold">
                <i class="bi bi-plus-lg me-1"></i>Crear el primero
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4" data-search-list>
            @foreach ($trainingCenters as $center)
            <div class="col" data-search-item>
                    <div class="panel-card h-100 p-4 d-flex flex-column">
                        <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-building"></i></span>
                            <span class="badge bg-success-subtle text-success rounded-pill">
                                ID {{ data_get($center, 'id', '—') }}
                            </span>
                        </div>

                        <h2 class="panel-section-title mb-1">{{ data_get($center, 'name', 'Sin nombre') }}</h2>
                        <p class="text-muted mb-3" style="font-size: 0.88rem;">
                            <i class="bi bi-geo-alt me-1"></i>{{ data_get($center, 'location', '—') }}
                        </p>

                        <div class="text-muted mb-3" style="font-size: 0.8rem;">
                            <i class="bi bi-calendar3 me-1"></i>
                            Creado: {{ \Illuminate\Support\Str::before((string) data_get($center, 'created_at', ''), 'T') ?: '—' }}
                        </div>

                        <div class="mt-auto d-flex flex-column gap-2">
                            <a href="{{ route('training-centers.show', ['id' => data_get($center, 'id')]) }}"
                               class="btn btn-outline-success btn-sm fw-semibold w-100">
                                <i class="bi bi-eye me-1"></i>Ver detalle
                            </a>
                            <div class="d-flex gap-1">
                                <a href="{{ route('training-centers.edit', ['id' => data_get($center, 'id')]) }}"
                                   class="btn btn-outline-primary btn-sm fw-semibold flex-fill">
                                    <i class="bi bi-pencil me-1"></i>Editar
                                </a>
                                <form action="{{ route('training-centers.destroy', ['id' => data_get($center, 'id')]) }}"
                                      method="POST" class="flex-fill"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este ambiente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold w-100">
                                        <i class="bi bi-trash me-1"></i>Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
