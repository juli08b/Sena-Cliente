@extends('layouts.dashboard')

@section('title', 'Programa de formación')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('areas.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver a programas
                </a>
            </div>

            @include('includes.flash')

            @if (!$area)
                <div class="panel-card p-4 text-center">
                    <div class="text-muted mb-2"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i></div>
                    <p class="mb-1 fw-semibold">No se pudo cargar este registro.</p>
                    <p class="mb-0 small text-muted">El registro solicitado no está disponible.</p>
                    <a href="{{ route('areas.index') }}" class="btn btn-outline-success btn-sm mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Volver al listado
                    </a>
                </div>
            @else
                <div class="panel-card p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-box-seam"></i></span>
                            <div>
                                <h1 class="panel-section-title mb-0">{{ data_get($area, 'name', 'Sin nombre') }}</h1>
                                <span class="text-muted" style="font-size: 0.85rem;">Programa de formación · ID {{ data_get($area, 'id') }}</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('areas.edit', ['id' => data_get($area, 'id')]) }}"
                               class="btn btn-outline-primary btn-sm fw-semibold">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <form action="{{ route('areas.destroy', ['id' => data_get($area, 'id')]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este programa?')">
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
                                    <td>{{ data_get($area, 'id', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nombre</td>
                                    <td>{{ data_get($area, 'name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Creado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($area, 'created_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Actualizado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($area, 'updated_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @php
                    $teachers = data_get($area, 'teachers', []);
                    $courses = data_get($area, 'courses', []);
                @endphp

                @if (is_array($teachers) && count($teachers))
                    <div class="panel-card p-4 mt-4">
                        <div class="panel-section-head">
                            <h2 class="panel-section-title">Instructores vinculados</h2>
                            <span class="badge bg-success-subtle text-success rounded-pill">{{ count($teachers) }}</span>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($teachers as $teacher)
                                <li>{{ data_get($teacher, 'name', 'Sin nombre') }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (is_array($courses) && count($courses))
                    <div class="panel-card p-4 mt-4">
                        <div class="panel-section-head">
                            <h2 class="panel-section-title">Fichas vinculadas</h2>
                            <span class="badge bg-success-subtle text-success rounded-circle">{{ count($courses) }}</span>
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
