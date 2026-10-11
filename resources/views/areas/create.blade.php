@extends('layouts.dashboard')

@section('title', 'Nuevo programa de formación')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('areas.index') }}" class="text-success text-decoration-none fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i>Volver al listado
                </a>
            </div>

            @include('includes.flash')

            <div class="panel-card p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="admin-sidebar-logo"><i class="bi bi-box-seam"></i></span>
                    <div>
                        <h1 class="panel-section-title mb-0">Nuevo programa de formación</h1>
                        <span class="text-muted" style="font-size: 0.85rem;">Completa los datos para continuar.</span>
                    </div>
                </div>

                <form action="{{ route('areas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre del programa <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" maxlength="255"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Ej. Análisis y desarrollo de software" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success fw-semibold">
                            <i class="bi bi-save me-1"></i>Guardar
                        </button>
                        <a href="{{ route('areas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
