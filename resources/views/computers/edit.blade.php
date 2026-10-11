@extends('layouts.dashboard')

@section('title', 'Editar computador')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('computers.show', ['id' => data_get($computer, 'id')]) }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al detalle
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-pencil-square"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Editar computador</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">ID {{ data_get($computer, 'id') }}</span>
                    </div>
                </div>

                <form action="{{ route('computers.update', ['id' => data_get($computer, 'id')]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="number" class="form-label fw-semibold">Número <span class="text-danger">*</span></label>
                        <input type="number" id="number" name="number" min="1" step="1"
                               class="form-control @error('number') is-invalid @enderror"
                               value="{{ old('number', data_get($computer, 'number')) }}" required>
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                        <input type="text" id="brand" name="brand" maxlength="255"
                               class="form-control @error('brand') is-invalid @enderror"
                               value="{{ old('brand', data_get($computer, 'brand')) }}" required>
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Actualizar
                        </button>
                        <a href="{{ route('computers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
