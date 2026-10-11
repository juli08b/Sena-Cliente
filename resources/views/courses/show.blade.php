@extends('layouts.dashboard')

@section('title', 'Curso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('courses.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver a cursos
                </a>
            </div>

            @include('includes.flash')

            @if (!$course)
                <div class="panel-card p-4 text-center">
                    <div class="text-muted mb-2"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i></div>
                    <p class="mb-1 fw-semibold">No se pudo cargar este registro.</p>
                    <p class="mb-0 small text-muted">El registro solicitado no está disponible.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-success btn-sm mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Volver al listado
                    </a>
                </div>
            @else
                <div class="panel-card p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-journal-bookmark"></i></span>
                            <div>
                                <h1 class="panel-section-title mb-0">Ficha {{ data_get($course, 'course_number', 'Sin número') }}</h1>
                                <span class="text-muted" style="font-size: 0.85rem;">Curso · ID {{ data_get($course, 'id') }}</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('courses.edit', ['id' => data_get($course, 'id')]) }}"
                               class="btn btn-outline-primary btn-sm fw-semibold">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <form action="{{ route('courses.destroy', ['id' => data_get($course, 'id')]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este curso?')">
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
                                    <td>{{ data_get($course, 'id', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Ficha / Número</td>
                                    <td>{{ data_get($course, 'course_number', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Día</td>
                                    <td>{{ data_get($course, 'day', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Área</td>
                                    <td>{{ data_get($course, 'area.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Ambiente de formación</td>
                                    <td>{{ data_get($course, 'training_center.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Creado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($course, 'created_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                @php
                    $teachers = data_get($course, 'teachers', []);
                    $apprentices = data_get($course, 'apprentices', []);
                @endphp

                @if (is_array($teachers) && count($teachers))
                    <div class="panel-card p-4 mt-4">
                        <div class="panel-section-head">
                            <h2 class="panel-section-title">Instructores del curso</h2>
                            <span class="badge bg-success-subtle text-success rounded-pill">{{ count($teachers) }}</span>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($teachers as $teacher)
                                <li>{{ data_get($teacher, 'name', 'Sin nombre') }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (is_array($apprentices) && count($apprentices))
                    <div class="panel-card p-4 mt-4">
                        <div class="panel-section-head">
                            <h2 class="panel-section-title">Aprendices del curso</h2>
                            <span class="badge bg-success-subtle text-success rounded-pill">{{ count($apprentices) }}</span>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($apprentices as $apprentice)
                                <li>
                                    {{ data_get($apprentice, 'name', 'Sin nombre') }}
                                    @if (data_get($apprentice, 'computer'))
                                        <span class="text-muted">· PC {{ data_get($apprentice, 'computer.number') }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
