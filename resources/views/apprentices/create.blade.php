@extends('layouts.dashboard')

@section('title', 'Nuevo aprendiz')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('apprentices.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al listado
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-people"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Nuevo aprendiz</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">Completa los datos para continuar.</span>
                    </div>
                </div>

                <form action="{{ route('apprentices.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" maxlength="255"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" placeholder="Ej. Laura Gómez" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-semibold">Correo <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" maxlength="255"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="Ej. laura@example.test" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="number" class="form-label fw-semibold">Número <span class="text-danger">*</span></label>
                            <input type="number" id="number" name="number" min="1"
                                   class="form-control @error('number') is-invalid @enderror"
                                   value="{{ old('number') }}" placeholder="Ej. 1001" required>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="course_id" class="form-label fw-semibold">Curso</label>
                            <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach (($courses ?? []) as $course)
                                    <option value="{{ data_get($course, 'id') }}" @selected(old('course_id') == data_get($course, 'id'))>
                                        Ficha {{ data_get($course, 'course_number', data_get($course, 'id')) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="computer_id" class="form-label fw-semibold">Computador</label>
                            <select id="computer_id" name="computer_id" class="form-select @error('computer_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach (($computers ?? []) as $computer)
                                    <option value="{{ data_get($computer, 'id') }}" @selected(old('computer_id') == data_get($computer, 'id'))>
                                        N.º {{ data_get($computer, 'number', data_get($computer, 'id')) }} · {{ data_get($computer, 'brand', 'Sin marca') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('computer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Guardar
                        </button>
                        <a href="{{ route('apprentices.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
