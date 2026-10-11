@extends('layouts.dashboard')

@section('title', 'Editar instructor')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('teachers.show', ['id' => data_get($teacher, 'id')]) }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al detalle
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-pencil-square"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Editar instructor</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">ID {{ data_get($teacher, 'id') }}</span>
                    </div>
                </div>

                <form action="{{ route('teachers.update', ['id' => data_get($teacher, 'id')]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" maxlength="255"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', data_get($teacher, 'name')) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location" class="form-label fw-semibold">Ubicación <span class="text-danger">*</span></label>
                            <input type="text" id="location" name="location" maxlength="255"
                                   class="form-control @error('location') is-invalid @enderror"
                                   value="{{ old('location', data_get($teacher, 'location')) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="area_id" class="form-label fw-semibold">Área</label>
                            <select id="area_id" name="area_id" class="form-select @error('area_id') is-invalid @enderror">
                                <option value="">Sin asignar</option>
                                @foreach (($areas ?? []) as $area)
                                    <option value="{{ data_get($area, 'id') }}" @selected(old('area_id', data_get($teacher, 'area_id')) == data_get($area, 'id'))>
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
                                    <option value="{{ data_get($trainingCenter, 'id') }}" @selected(old('training_center_id', data_get($teacher, 'training_center_id')) == data_get($trainingCenter, 'id'))>
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
                            <i class="bi bi-save me-1"></i>Actualizar
                        </button>
                        <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
