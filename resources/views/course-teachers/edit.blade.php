@extends('layouts.dashboard')

@section('title', 'Editar asignación')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('course-teachers.show', ['id' => data_get($courseTeacher, 'id')]) }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al detalle
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-pencil-square"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Editar asignación</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">ID {{ data_get($courseTeacher, 'id') }}</span>
                    </div>
                </div>

                <form action="{{ route('course-teachers.update', ['id' => data_get($courseTeacher, 'id')]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="course_id" class="form-label fw-semibold">Curso <span class="text-danger">*</span></label>
                            <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                                <option value="">Selecciona un curso</option>
                                @foreach (($courses ?? []) as $course)
                                    <option value="{{ data_get($course, 'id') }}" @selected(old('course_id', data_get($courseTeacher, 'course_id')) == data_get($course, 'id'))>
                                        Ficha {{ data_get($course, 'course_number', data_get($course, 'id')) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="teacher_id" class="form-label fw-semibold">Instructor <span class="text-danger">*</span></label>
                            <select id="teacher_id" name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror" required>
                                <option value="">Selecciona un instructor</option>
                                @foreach (($teachers ?? []) as $teacher)
                                    <option value="{{ data_get($teacher, 'id') }}" @selected(old('teacher_id', data_get($courseTeacher, 'teacher_id')) == data_get($teacher, 'id'))>
                                        {{ data_get($teacher, 'name', 'Sin nombre') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Actualizar
                        </button>
                        <a href="{{ route('course-teachers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
