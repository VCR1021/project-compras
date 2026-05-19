<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stratos Procurement</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 260px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background-color: #f8f9fa; /* Light sidebar as in mockup */
            border-right: 1px solid #e9ecef;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }
        .sidebar .brand {
            padding: 20px;
        }
        .sidebar .brand h5 {
            color: #0b224e;
            font-weight: 700;
            margin-bottom: 0;
        }
        .sidebar .brand small {
            color: #6c757d;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .sidebar-nav {
            flex-grow: 1;
            padding: 20px 0;
        }
        .nav-item {
            padding: 5px 20px;
        }
        .nav-link {
            color: #495057;
            font-weight: 500;
            display: flex;
            align-items: center;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        .nav-link i {
            margin-right: 15px;
            font-size: 1.2rem;
        }
        .nav-link:hover, .nav-link.active {
            color: #0b224e;
            background-color: #eef2f7;
        }
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #e9ecef;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .topbar {
            height: 70px;
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }
        .content-area {
            padding: 30px;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            margin-bottom: 25px;
        }
        .card-custom .card-body {
            padding: 25px;
        }
        .icon-box {
            width: 40px;
            height: 40px;
            background-color: #eef2f7;
            color: #0b224e;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .form-control, .form-select {
            border-radius: 6px;
            padding: 10px 15px;
            border: 1px solid #ced4da;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #0b224e;
        }
        .form-control[readonly] {
            background-color: #f8f9fa;
        }
        .btn-primary {
            background-color: #0b224e;
            border-color: #0b224e;
            padding: 10px 25px;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background-color: #081a3c;
            border-color: #081a3c;
        }
        .form-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 8px;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <h5>Stratos Procurement</h5>
            <small>PROCUREMENT LEDGER</small>
        </div>
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="{{ route('orders.create') }}" class="nav-link {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                    <i class="bi bi-cart-plus"></i> Nueva Solicitud
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Historial
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('suppliers.index') }}" class="nav-link {{ request()->routeIs('suppliers.index') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Proveedores
                </a>
            </div>
        </div>
        <div class="sidebar-footer">
            <a href="#" class="nav-link mb-2"><i class="bi bi-question-circle"></i> Ayuda</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h5 class="m-0 font-weight-bold">@yield('page_title', 'Stratos Procurement')</h5>
            <div class="d-flex align-items-center">
                <div class="input-group me-4" style="width: 250px;">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Buscar expedientes...">
                </div>
                <a href="#" class="text-secondary me-3"><i class="bi bi-bell fs-5"></i></a>
                <a href="#" class="text-secondary me-3"><i class="bi bi-gear fs-5"></i></a>
                @auth
                <div class="d-flex align-items-center gap-2">
                    <div class="text-end d-none d-md-block">
                        <div style="font-size: 0.88rem; font-weight: 600; color: #0b224e; line-height: 1;">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                        <div style="font-size: 0.75rem; color: #6c757d;">{{ ucfirst(strtolower(auth()->user()->role)) }}</div>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white" style="width: 35px; height: 35px; background: #0b224e; font-size: 0.9rem;">
                        {{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
                    </div>
                </div>
                @endauth
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
