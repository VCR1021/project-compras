<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;

// ─── Rutas públicas de Autenticación ────────────────────────────────────────
Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Rutas protegidas (requieren sesión activa) ──────────────────────────────
Route::middleware('auth')->group(function () {

    Route::get('/', fn() => redirect()->route('orders.create'));

    // Órdenes de compra
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/',                   [PurchaseOrderController::class, 'index'])  ->name('index');
        Route::get('/create',             [PurchaseOrderController::class, 'create']) ->name('create');
        Route::post('/',                  [PurchaseOrderController::class, 'store'])  ->name('store');
        Route::delete('/{purchaseOrder}', [PurchaseOrderController::class, 'destroy'])->name('destroy');
    });

    // Proveedores
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');

    // API interna: productos por proveedor (llamada AJAX del formulario)
    Route::get('/api/suppliers/{supplier}/products', function (Supplier $supplier) {
        return response()->json($supplier->products()->where('is_active', true)->get());
    })->name('api.supplier.products');
});

