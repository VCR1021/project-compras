@extends('layouts.app')

@section('page_title', 'Proveedores')

@section('content')

{{-- Tarjetas de estadísticas --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-custom h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: #eef2f7; color: #0b224e;">
                    <i class="bi bi-building fs-4"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalSuppliers }}</div>
                    <div class="stat-label">Proveedores Activos</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: #e8f5e9; color: #2e7d32;">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-label">Productos en Catálogo</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background: #fff3e0; color: #e65100;">
                    <i class="bi bi-cart-check fs-4"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $totalOrders }}</div>
                    <div class="stat-label">Órdenes Emitidas</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabla de proveedores --}}
<div class="card card-custom">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="icon-box">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h5 class="mb-0">Directorio de Proveedores</h5>
                    <small class="text-muted">Todas las entidades comerciales registradas</small>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Empresa</th>
                        <th>Punto de Contacto</th>
                        <th>Correo Electrónico</th>
                        <th>Teléfono</th>
                        <th class="text-center">Productos</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td class="text-muted">{{ $supplier->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="supplier-avatar">
                                    {{ strtoupper(substr($supplier->company_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $supplier->company_name }}</div>
                                    @if($supplier->tax_id)
                                        <small class="text-muted">RFC: {{ $supplier->tax_id }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $supplier->contact_name ?? '—' }}</td>
                        <td>
                            @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" class="text-decoration-none text-primary">
                                    {{ $supplier->email }}
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $supplier->phone ?? '—' }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill" style="background: #eef2f7; color: #0b224e; font-size: 0.85rem; padding: 5px 12px;">
                                {{ $supplier->products_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($supplier->is_active)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-building-x fs-2 d-block mb-2"></i>
                            No hay proveedores registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #0b224e;
        line-height: 1;
    }
    .stat-label {
        font-size: 0.82rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }
    .supplier-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #eef2f7;
        color: #0b224e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }
</style>
@endsection
