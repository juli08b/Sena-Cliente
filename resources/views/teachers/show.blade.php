@extends('layouts.dashboard')

@section('title', 'Instructor')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('teachers.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver a instructores
                </a>
            </div>

            @include('includes.flash')

            @if (!$teacher)
                <div class="panel-card p-4 text-center">
                    <div class="text-muted mb-2"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i></div>
                    <p class="mb-1 fw-semibold">No se pudo cargar este registro.</p>
                    <p class="mb-0 small text-muted">El registro solicitado no está disponible.</p>
                    <a href="{{ route('teachers.index') }}" class="btn btn-outline-success btn-sm mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Volver al listado
                    </a>
                </div>
            @else
                <div class="panel-card p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-person-badge"></i></span>
                            <div>
                                <h1 class="panel-section-title mb-0">{{ data_get($teacher, 'name', 'Sin nombre') }}</h1>
                                <span class="text-muted" style="font-size: 0.85rem;">Instructor · ID {{ data_get($teacher, 'id') }}</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
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
                                    <td>{{ data_get($teacher, 'id', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nombre</td>
                                    <td>{{ data_get($teacher, 'name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Ubicación</td>
                                    <td>{{ data_get($teacher, 'location', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Área</td>
                                    <td>{{ data_get($teacher, 'area.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Ambiente de formación</td>
                                    <td>{{ data_get($teacher, 'training_center.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Creado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($teacher, 'created_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Actualizado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($teacher, 'updated_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @php
                    $courses = data_get($teacher, 'courses', []);
                @endphp

                @if (is_array($courses) && count($courses))
                    <div class="panel-card p-4 mt-4">
                        <div class="panel-section-head">
                            <h2 class="panel-section-title">Cursos asignados</h2>
                            <span class="badge bg-success-subtle text-success rounded-pill">{{ count($courses) }}</span>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($courses as $course)
                                <li>Ficha {{ data_get($course, 'course_number', data_get($course, 'id', '—')) }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
