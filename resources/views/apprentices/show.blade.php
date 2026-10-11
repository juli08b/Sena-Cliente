@extends('layouts.dashboard')

@section('title', 'Aprendiz')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('apprentices.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver a aprendices
                </a>
            </div>

            @include('includes.flash')

            @if (!$apprentice)
                <div class="panel-card p-4 text-center">
                    <div class="text-muted mb-2"><i class="bi bi-exclamation-triangle" style="font-size: 2rem;"></i></div>
                    <p class="mb-1 fw-semibold">No se pudo cargar este registro.</p>
                    <p class="mb-0 small text-muted">El registro solicitado no está disponible.</p>
                    <a href="{{ route('apprentices.index') }}" class="btn btn-outline-success btn-sm mt-3 fw-semibold">
                        <i class="bi bi-arrow-left me-1"></i>Volver al listado
                    </a>
                </div>
            @else
                <div class="panel-card p-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="admin-sidebar-logo"><i class="bi bi-people"></i></span>
                            <div>
                                <h1 class="panel-section-title mb-0">{{ data_get($apprentice, 'name', 'Sin nombre') }}</h1>
                                <span class="text-muted" style="font-size: 0.85rem;">Aprendiz · ID {{ data_get($apprentice, 'id') }}</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('apprentices.edit', ['id' => data_get($apprentice, 'id')]) }}"
                               class="btn btn-outline-primary btn-sm fw-semibold">
                                <i class="bi bi-pencil me-1"></i>Editar
                            </a>
                            <form action="{{ route('apprentices.destroy', ['id' => data_get($apprentice, 'id')]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este aprendiz?')">
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
                                    <td>{{ data_get($apprentice, 'id', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Nombre</td>
                                    <td>{{ data_get($apprentice, 'name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Correo</td>
                                    <td>{{ data_get($apprentice, 'email', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Número</td>
                                    <td>{{ data_get($apprentice, 'number', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Curso</td>
                                    <td>{{ data_get($apprentice, 'course.course_number', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Área del curso</td>
                                    <td>{{ data_get($apprentice, 'course.area.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Ambiente del curso</td>
                                    <td>{{ data_get($apprentice, 'course.training_center.name', '—') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Computador</td>
                                    <td>
                                        @if (data_get($apprentice, 'computer'))
                                            N.º {{ data_get($apprentice, 'computer.number') }} · {{ data_get($apprentice, 'computer.brand', 'Sin marca') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Creado</td>
                                    <td>{{ \Illuminate\Support\Str::before((string) data_get($apprentice, 'created_at', ''), 'T') ?: '—' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
