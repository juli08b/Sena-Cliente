@extends('layouts.dashboard')

@section('title', 'Nuevo curso')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('courses.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al listado
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-journal-bookmark"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Nuevo curso</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">Completa los datos para continuar.</span>
                    </div>
                </div>

                <form action="{{ route('courses.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course_number" class="form-label fw-semibold">Ficha / Número de curso <span class="text-danger">*</span></label>
                            <input type="text" id="course_number" name="course_number" maxlength="255"
                                   class="form-control @error('course_number') is-invalid @enderror"
                                   value="{{ old('course_number') }}" placeholder="Ej. SENA-2026-001" required>
                            @error('course_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="day" class="form-label fw-semibold">Día <span class="text-danger">*</span></label>
                            <input type="text" id="day" name="day" maxlength="255"
                                   class="form-control @error('day') is-invalid @enderror"
                                   value="{{ old('day') }}" placeholder="Ej. Lunes" required>
                            @error('day')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="area_id" class="form-label fw-semibold">Área</label>
                            <select id="area_id" name="area_id" class="form-select @error('area_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach (($areas ?? []) as $area)
                                    <option value="{{ data_get($area, 'id') }}" @selected(old('area_id') == data_get($area, 'id'))>
                                        {{ data_get($area, 'name', 'Sin nombre') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('area_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="training_center_id" class="form-label fw-semibold">Ambiente de formación</label>
                            <select id="training_center_id" name="training_center_id" class="form-select @error('training_center_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach (($trainingCenters ?? []) as $trainingCenter)
                                    <option value="{{ data_get($trainingCenter, 'id') }}" @selected(old('training_center_id') == data_get($trainingCenter, 'id'))>
                                        {{ data_get($trainingCenter, 'name', 'Sin nombre') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('training_center_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Guardar
                        </button>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
