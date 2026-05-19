<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderLine;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with(['supplier', 'requester', 'lines.product'])
            ->orderBy('id', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();
        // Cargar productos en JSON si es necesario, o cargarlos dinámicamente vía API
        $products = Product::where('is_active', true)->get();

        return view('orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_price' => 'required|numeric|min:0',
            'expected_delivery_date' => 'nullable|date',
            'delivery_address' => 'nullable|string',
            'shipping_priority' => 'nullable|string', // Se podría usar en 'notes' u otra columna, lo añadiré a notes si no existe
        ]);

        // Obtener el ID del usuario autenticado
        $requesterId = auth()->id();

        // Generar número de PO
        $count = PurchaseOrder::count() + 1;
        $poNumber = 'PO-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $subtotal = $validated['quantity'] * $validated['unit_price'];
        $taxAmount = $subtotal * 0.16; // Asumimos un 16% de IVA por defecto, o 0 según aplique
        $total = $subtotal + $taxAmount;

        $notes = $request->input('shipping_priority') 
            ? 'Priority: ' . $request->input('shipping_priority') 
            : null;

        $order = PurchaseOrder::create([
            'po_number' => $poNumber,
            'requester_id' => $requesterId,
            'supplier_id' => $validated['supplier_id'],
            'status' => 'DRAFT',
            'subtotal_amount' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $total,
            'issue_date' => now(),
            'expected_delivery_date' => $validated['expected_delivery_date'],
            'delivery_address' => $validated['delivery_address'],
            'notes' => $notes,
        ]);

        PurchaseOrderLine::create([
            'purchase_order_id' => $order->id,
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'unit_price' => $validated['unit_price'],
        ]);

        return redirect()->route('orders.index')->with('success', 'Orden de compra registrada exitosamente.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete(); // Elimina también las líneas por CASCADE
        return redirect()->route('orders.index')->with('success', 'Orden de compra eliminada exitosamente.');
    }
}
