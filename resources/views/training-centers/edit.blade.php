@extends('layouts.dashboard')

@section('title', 'Editar ambiente de formación')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('training-centers.show', ['id' => data_get($trainingCenter, 'id')]) }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al detalle
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-pencil-square"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Editar ambiente de formación</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">ID {{ data_get($trainingCenter, 'id') }}</span>
                    </div>
                </div>

                <form action="{{ route('training-centers.update', ['id' => data_get($trainingCenter, 'id')]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre del centro <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" maxlength="255"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', data_get($trainingCenter, 'name')) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label fw-semibold">Ubicación <span class="text-danger">*</span></label>
                        <input type="text" id="location" name="location" maxlength="255"
                               class="form-control @error('location') is-invalid @enderror"
                               value="{{ old('location', data_get($trainingCenter, 'location')) }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Actualizar
                        </button>
                        <a href="{{ route('training-centers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
