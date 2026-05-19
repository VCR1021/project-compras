@extends('layouts.app')

@section('page_title', 'Historial de Solicitudes')

@section('content')
<div class="card card-custom">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nº Orden</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Solicitante</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>{{ $order->po_number }}</strong></td>
                            <td>{{ $order->issue_date ? $order->issue_date->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>
                                {{ $order->supplier->company_name ?? 'N/A' }}
                                <br>
                                <small class="text-muted">{{ $order->supplier->contact_name ?? '' }}</small>
                            </td>
                            <td>{{ $order->requester->first_name ?? '' }} {{ $order->requester->last_name ?? '' }}</td>
                            <td>$ {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if($order->status == 'APPROVED')
                                    <span class="badge bg-success">Aprobado</span>
                                @elseif($order->status == 'DRAFT')
                                    <span class="badge bg-secondary">Borrador</span>
                                @else
                                    <span class="badge bg-primary">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de que desea eliminar esta orden de compra? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar orden">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No hay órdenes de compra registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
