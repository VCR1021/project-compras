@extends('layouts.app')

@section('page_title', 'Nueva Solicitud de Compra')

@section('content')
<form method="POST" action="{{ route('orders.store') }}">
    @csrf
    
    <!-- Card 1: Información del Proveedor -->
    <div class="card card-custom">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box me-3">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h5 class="mb-0">Información del Proveedor</h5>
                    <small class="text-muted">Seleccione la entidad comercial para esta orden</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">PROVEEDOR</label>
                    <select class="form-select" name="supplier_id" id="supplier_id" required>
                        <option value="" selected disabled>Seleccionar proveedor...</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" 
                                data-contact="{{ $supplier->contact_name }}"
                                data-email="{{ $supplier->email }}"
                                data-phone="{{ $supplier->phone }}">
                                {{ $supplier->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PUNTO DE CONTACTO</label>
                    <input type="text" class="form-control" id="contact_name" placeholder="Nombre del representante" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">CORREO ELECTRÓNICO</label>
                    <input type="text" class="form-control" id="contact_email" placeholder="contacto@proveedor.com" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">TELÉFONO CORPORATIVO</label>
                    <input type="text" class="form-control" id="contact_phone" placeholder="+54 (11) 4567-8900" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Detalle del Producto -->
    <div class="card card-custom">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box me-3">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div>
                    <h5 class="mb-0">Detalle del Producto</h5>
                    <small class="text-muted">Información técnica y financiera del ítem</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-5">
                    <label class="form-label">NOMBRE DEL PRODUCTO</label>
                    <select class="form-select" name="product_id" id="product_id" required disabled>
                        <option value="" selected disabled>Seleccione un proveedor primero...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SKU / CÓDIGO</label>
                    <input type="text" class="form-control" id="product_sku" placeholder="STR-09923-X" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">CANTIDAD</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" step="0.01" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">PRECIO UNITARIO</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">$</span>
                        <input type="number" class="form-control" name="unit_price" id="unit_price" value="0.00" step="0.01" readonly required>
                    </div>
                </div>
                <div class="col-md-7">
                    <label class="form-label">SUBTOTAL ESTIMADO</label>
                    <div class="p-2 bg-light rounded d-flex align-items-center" style="height: 44px;">
                        <span class="fw-bold fs-5 me-2 text-primary" id="subtotal_display">$ 0.00</span>
                        <small class="text-muted">IVA no incluido</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Logística de Entrega -->
    <div class="card card-custom">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                <div class="icon-box me-3">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <h5 class="mb-0">Logística de Entrega</h5>
                    <small class="text-muted">Defina cuándo y dónde se requiere el pedido</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">FECHA DE ENTREGA SOLICITADA</label>
                    <input type="date" class="form-control" name="expected_delivery_date" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PRIORIDAD DE ENVÍO</label>
                    <select class="form-select" name="shipping_priority">
                        <option value="Estándar (5-7 días)">Estándar (5-7 días)</option>
                        <option value="Express (2-3 días)">Express (2-3 días)</option>
                        <option value="Urgente (24 horas)">Urgente (24 horas)</option>
                    </select>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label">DIRECCIÓN DE ENTREGA</label>
                    <textarea class="form-control" name="delivery_address" rows="2" placeholder="Ingrese la dirección detallada de entrega..." required></textarea>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    Crear Solicitud de Compra
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const supplierSelect = document.getElementById('supplier_id');
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const priceInput = document.getElementById('unit_price');
        const subtotalDisplay = document.getElementById('subtotal_display');
        
        let productsData = [];

        // Cambiar Proveedor
        supplierSelect.addEventListener('change', function() {
            // Autocompletar datos de contacto
            const selectedOption = this.options[this.selectedIndex];
            document.getElementById('contact_name').value = selectedOption.dataset.contact || '';
            document.getElementById('contact_email').value = selectedOption.dataset.email || '';
            document.getElementById('contact_phone').value = selectedOption.dataset.phone || '';

            // Limpiar productos
            productSelect.innerHTML = '<option value="" selected disabled>Cargando productos...</option>';
            productSelect.disabled = true;
            resetProductFields();

            // Cargar productos del proveedor via API
            fetch(`/api/suppliers/${this.value}/products`)
                .then(response => response.json())
                .then(data => {
                    productsData = data;
                    productSelect.innerHTML = '<option value="" selected disabled>Ej: MacBook Pro M3 14-inch</option>';
                    data.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.id;
                        option.textContent = product.name;
                        productSelect.appendChild(option);
                    });
                    productSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    productSelect.innerHTML = '<option value="" selected disabled>Error al cargar productos</option>';
                });
        });

        // Cambiar Producto
        productSelect.addEventListener('change', function() {
            const selectedProduct = productsData.find(p => p.id == this.value);
            if (selectedProduct) {
                document.getElementById('product_sku').value = selectedProduct.sku;
                priceInput.value = parseFloat(selectedProduct.reference_price).toFixed(2);
                calculateSubtotal();
            }
        });

        // Cambiar Cantidad
        quantityInput.addEventListener('input', calculateSubtotal);

        function resetProductFields() {
            document.getElementById('product_sku').value = '';
            priceInput.value = '0.00';
            calculateSubtotal();
        }

        function calculateSubtotal() {
            const qty = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const subtotal = qty * price;
            subtotalDisplay.innerHTML = '$ ' + subtotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    });
</script>
@endsection
