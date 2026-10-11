@extends('layouts.dashboard')

@section('title', 'Computadores')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="panel-section-title mb-1">Computadores</h1>
            <p class="text-muted mb-0" style="font-size: 0.86rem;">
                <i class="bi bi-pc-display me-1"></i>Computadores registrados: {{ $computers->count() }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('computers.index') }}" class="btn btn-outline-success fw-semibold">
                <i class="bi bi-house-door me-1"></i>Inicio
            </a>
            <a href="{{ route('computers.create') }}" class="btn btn-success fw-semibold">
                <i class="bi bi-plus-lg me-1"></i>Nuevo computador
            </a>
        </div>
    </div>

    @include('includes.flash')

    @if ($computers->isEmpty())
        <div class="panel-card p-4 text-center">
            <div class="text-muted mb-2"><i class="bi bi-inbox" style="font-size: 2rem;"></i></div>
            <p class="mb-1 fw-semibold">No hay computadores para mostrar por el momento.</p>
            <a href="{{ route('computers.create') }}" class="btn btn-success btn-sm fw-semibold">
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
                            <th>Número</th>
                            <th>Marca</th>
                            <th class="text-center">Creado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($computers as $computer)
                            <tr>
                                <td>{{ data_get($computer, 'id', '—') }}</td>
                                <td class="fw-semibold">{{ data_get($computer, 'number', '—') }}</td>
                                <td>{{ data_get($computer, 'brand', '—') }}</td>
                                <td class="text-center text-muted">
                                    {{ \Illuminate\Support\Str::before((string) data_get($computer, 'created_at', ''), 'T') ?: '—' }}
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('computers.show', ['id' => data_get($computer, 'id')]) }}"
                                           class="btn btn-outline-success btn-sm fw-semibold">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('computers.edit', ['id' => data_get($computer, 'id')]) }}"
                                           class="btn btn-outline-primary btn-sm fw-semibold">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form action="{{ route('computers.destroy', ['id' => data_get($computer, 'id')]) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este computador?')">
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
