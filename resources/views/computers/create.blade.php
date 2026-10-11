@extends('layouts.dashboard')

@section('title', 'Nuevo computador')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('computers.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al listado
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-pc-display"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Nuevo computador</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">Completa los datos para continuar.</span>
                    </div>
                </div>

                <form action="{{ route('computers.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="number" class="form-label fw-semibold">Número <span class="text-danger">*</span></label>
                        <input type="number" id="number" name="number" min="1" step="1"
                               class="form-control @error('number') is-invalid @enderror"
                               value="{{ old('number') }}" placeholder="Ej. 1256" required>
                        @error('number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="brand" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                        <input type="text" id="brand" name="brand" maxlength="255"
                               class="form-control @error('brand') is-invalid @enderror"
                               value="{{ old('brand') }}" placeholder="Ej. Lenovo" required>
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Guardar
                        </button>
                        <a href="{{ route('computers.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
