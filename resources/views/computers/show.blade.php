@extends('layouts.dashboard')

@section('title', 'Computador')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('computers.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver a computadores
                </a>
            </div>

            @include('includes.flash')

            @if (!$computer)
                <div class="panel-card p-4 text-center">
                    <div class="text-muted mb-2"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i></div>
                    <p class="mb-1 fw-semibold">No se pudo cargar este registro.</p>
                    <p class="mb-0 small text-muted">El registro solicitado no está disponible.</p>
                    <a href="{{ route('computers.index') }}" class="btn btn-outline-success btn-sm mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Volver al listado
                    </a>
                </div>
            @else
                <div class="panel-card p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-pc-display"></i></span>
                            <div>
                                <h1 class="panel-section-title mb-0">
                                    Computador {{ data_get($computer, 'number', '—') }}
                                </h1>
                                <span class="text-muted" style="font-size: 0.85rem;">
                                    {{ data_get($computer, 'brand', 'Sin marca') }} · ID {{ data_get($computer, 'id') }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
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
                    </div>

                    <div class="table-responsive">
                        <table class="table dash-table mb-0">
                            <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-semibold">ID</td>
                                    <td>{{ data_get($computer, 'id', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Número</td>
                                    <td>{{ data_get($computer, 'number', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Marca</td>
                                    <td>{{ data_get($computer, 'brand', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Creado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($computer, 'created_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Actualizado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($computer, 'updated_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @php
                    $apprentices = data_get($computer, 'apprentices', []);
                @endphp

                @if (is_array($apprentices) && count($apprentices))
                    <div class="panel-card p-0 mt-4">
                        <div class="panel-section-head p-4 pb-0">
                            <h2 class="panel-section-title">Aprendices asignados</h2>
                            <span class="badge bg-success-subtle text-success rounded-pill">{{ count($apprentices) }}</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table dash-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Aprendiz</th>
                                        <th>Ficha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($apprentices as $apprentice)
                                        <tr>
                                            <td>{{ data_get($apprentice, 'id', '—') }}</td>
                                            <td class="fw-semibold">
                                                {{ data_get($apprentice, 'name', data_get($apprentice, 'first_name', '—')) }}
                                            </td>
                                            <td>
                                                {{ data_get($apprentice, 'course.course_number', data_get($apprentice, 'course_id', '—')) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
