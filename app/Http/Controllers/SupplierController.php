<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers      = Supplier::withCount('products')->orderBy('company_name')->get();
        $totalSuppliers = $suppliers->where('is_active', true)->count();
        $totalProducts  = Product::where('is_active', true)->count();
        $totalOrders    = PurchaseOrder::count();

        return view('suppliers.index', compact('suppliers', 'totalSuppliers', 'totalProducts', 'totalOrders'));
    }
}
