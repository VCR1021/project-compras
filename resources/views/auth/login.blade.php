<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — Stratos Procurement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #0b224e 0%, #1a3a72 50%, #0d2d5e 100%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Panel izquierdo decorativo */
        .login-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            color: #fff;
        }
        .login-left .logo-area {
            margin-bottom: 60px;
        }
        .login-left .logo-area h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }
        .login-left .logo-area span {
            font-size: 0.75rem;
            letter-spacing: 3px;
            opacity: 0.6;
            text-transform: uppercase;
        }
        .login-left .hero-text h2 {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
        }
        .login-left .hero-text p {
            opacity: 0.7;
            font-size: 1rem;
            max-width: 400px;
            line-height: 1.7;
        }
        .feature-list {
            margin-top: 48px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            opacity: 0.85;
        }
        .feature-item .icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }
        .feature-item span {
            font-size: 0.9rem;
        }

        /* Panel derecho con el formulario */
        .login-right {
            width: 480px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
        }
        .login-card {
            width: 100%;
        }
        .login-card h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0b224e;
            margin-bottom: 6px;
        }
        .login-card .subtitle {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 32px;
        }
        .form-label {
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        .input-group-text {
            background: #fff;
            border-right: none;
            color: #adb5bd;
        }
        .form-control {
            border-left: none;
            padding: 11px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #0b224e;
        }
        .input-group:focus-within .input-group-text {
            border-color: #0b224e;
        }
        .btn-login {
            width: 100%;
            background: #0b224e;
            color: #fff;
            border: none;
            padding: 13px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 8px;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #081a3c;
            color: #fff;
        }
        .divider {
            text-align: center;
            color: #adb5bd;
            font-size: 0.85rem;
            margin: 24px 0 16px;
            position: relative;
        }
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e9ecef;
            z-index: 0;
        }
        .divider span {
            background: #f8f9fa;
            padding: 0 12px;
            position: relative;
            z-index: 1;
        }
        .demo-credentials {
            background: #eef2f7;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 0.82rem;
            color: #495057;
        }
        .demo-credentials strong {
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0b224e;
            margin-bottom: 8px;
        }
        .demo-credentials .cred-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }
        .demo-credentials code {
            background: rgba(11,34,78,0.08);
            border-radius: 4px;
            padding: 1px 6px;
            color: #0b224e;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .login-left { display: none; }
            .login-right { width: 100%; }
        }
    </style>
</head>
<body>

    <!-- Panel izquierdo decorativo -->
    <div class="login-left">
        <div class="logo-area">
            <h1>Stratos Procurement</h1>
            <span>Procurement Ledger</span>
        </div>
        <div class="hero-text">
            <h2>Gestiona tus órdenes de compra con precisión</h2>
            <p>Plataforma centralizada para administrar solicitudes de compra, proveedores y logística de entrega.</p>
        </div>
        <div class="feature-list">
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-cart-check"></i></div>
                <span>Registro y seguimiento de órdenes de compra</span>
            </div>
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-building"></i></div>
                <span>Gestión de proveedores y catálogo de productos</span>
            </div>
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-shield-check"></i></div>
                <span>Acceso seguro con autenticación de usuarios</span>
            </div>
        </div>
    </div>

    <!-- Panel derecho: formulario -->
    <div class="login-right">
        <div class="login-card">
            <h3>Bienvenido de vuelta</h3>
            <p class="subtitle">Inicia sesión para acceder al sistema</p>

            @if($errors->any())
                <div class="alert alert-danger py-2 mb-3" style="font-size: 0.88rem; border-radius: 8px;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $errors->first('email') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            class="form-control border-start-0"
                            placeholder="usuario@empresa.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            id="email"
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            class="form-control border-start-0"
                            placeholder="••••••••"
                            required
                            id="password"
                        >
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember" style="font-size: 0.88rem; color: #6c757d;">
                            Mantener sesión activa
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-login" id="btn-login">
                    Iniciar Sesión
                </button>
            </form>

            <div class="divider"><span>Cuentas de acceso de prueba</span></div>

            <div class="demo-credentials">
                <strong><i class="bi bi-info-circle me-1"></i> Credenciales disponibles</strong>
                <div class="cred-row">
                    <span>ana.garcia@empresa.com</span>
                    <code>password</code>
                </div>
                <div class="cred-row">
                    <span>carlos.lopez@empresa.com</span>
                    <code>password</code>
                </div>
                <div class="cred-row">
                    <span>elena.martinez@empresa.com</span>
                    <code>password</code>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
