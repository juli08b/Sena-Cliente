@extends('layouts.dashboard')

@section('title', 'Asignación')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('course-teachers.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver a asignaciones
                </a>
            </div>

            @include('includes.flash')

            @if (!$courseTeacher)
                <div class="panel-card p-4 text-center">
                    <div class="text-muted mb-2"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i></div>
                    <p class="mb-1 fw-semibold">No se pudo cargar este registro.</p>
                    <p class="mb-0 small text-muted">El registro solicitado no está disponible.</p>
                    <a href="{{ route('course-teachers.index') }}" class="btn btn-outline-success btn-sm mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Volver al listado
                    </a>
                </div>
            @else
                <div class="panel-card p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-link-45deg"></i></span>
                            <div>
                                <h1 class="panel-section-title mb-0">Asignación #{{ data_get($courseTeacher, 'id') }}</h1>
                                <span class="text-muted" style="font-size: 0.85rem;">Curso ↔ Instructor</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('course-teachers.edit', ['id' => data_get($courseTeacher, 'id')]) }}"
                               class="btn btn-outline-primary btn-sm fw-semibold">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <form action="{{ route('course-teachers.destroy', ['id' => data_get($courseTeacher, 'id')]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta asignación?')">
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
                                    <td>{{ data_get($courseTeacher, 'id', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Curso</td>
                                    <td>Ficha {{ data_get($courseTeacher, 'course.course_number', data_get($courseTeacher, 'course_id', '—')) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Instructor</td>
                                    <td>{{ data_get($courseTeacher, 'teacher.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Creado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($courseTeacher, 'created_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
