@extends('layouts.dashboard')

@section('title', 'Instructores')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="panel-section-title mb-1">Instructores</h1>
            <p class="text-muted mb-0" style="font-size: 0.86rem;">
                <i class="bi bi-person-badge me-1"></i>Instructores registrados: {{ $teachers->count() }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('teachers.index') }}" class="btn btn-outline-success fw-semibold">
                <i class="bi bi-house-door me-1"></i>Inicio
            </a>
            <a href="{{ route('teachers.create') }}" class="btn btn-success fw-semibold">
                <i class="bi bi-plus-lg me-1"></i>Nuevo instructor
            </a>
        </div>
    </div>

    @include('includes.flash')

    @if ($teachers->isEmpty())
        <div class="panel-card p-4 text-center">
            <div class="text-muted mb-2"><i class="bi bi-inbox" style="font-size: 2rem;"></i></div>
            <p class="mb-1 fw-semibold">No hay instructores para mostrar por el momento.</p>
            <a href="{{ route('teachers.create') }}" class="btn btn-success btn-sm fw-semibold">
                <i class="bi bi-plus-lg me-1"></i>Crear el primero
            </a>
        </div>
    @else
        <div class="panel-card p-0">
            <div class="table-responsive">
                <table class="table dash-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Área</th>
                            <th>Ambiente</th>
                            <th class="text-center">Creado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td>{{ data_get($teacher, 'id', '—') }}</td>
                                <td class="fw-semibold">{{ data_get($teacher, 'name', '—') }}</td>
                                <td>{{ data_get($teacher, 'location', '—') }}</td>
                                <td>{{ data_get($teacher, 'area.name', '—') }}</td>
                                <td>{{ data_get($teacher, 'training_center.name', '—') }}</td>
                                <td class="text-center text-muted">
                                    {{ \Illuminate\Support\Str::before((string) data_get($teacher, 'created_at', ''), 'T') ?: '—' }}
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('teachers.show', ['id' => data_get($teacher, 'id')]) }}"
                                           class="btn btn-outline-success btn-sm fw-semibold">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('teachers.edit', ['id' => data_get($teacher, 'id')]) }}"
                                           class="btn btn-outline-primary btn-sm fw-semibold">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form action="{{ route('teachers.destroy', ['id' => data_get($teacher, 'id')]) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este instructor?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold">
                                                <i class="bi bi-trash me-1"></i>Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
