# CONTEXTO DEL PROYECTO — Stratos Procurement
> Archivo generado el 19/05/2026 · Última sesión de trabajo
> Retomar la próxima semana a partir de este documento.

---

## 🗂️ Estado General del Proyecto

| Elemento | Detalle |
|---|---|
| Framework | Laravel 13.11.0 + PHP 8.5 |
| Base de Datos | MySQL → `procurement_db` en `127.0.0.1:3306` |
| CSS Framework | Bootstrap 5.3.2 (via CDN) |
| Servidor local | `php artisan serve` → `http://localhost:8000` |
| Directorio fuente | `project-compras/` |

---

## ✅ Lo que está COMPLETADO y funcionando

### Fase 1 — Core del sistema (Modelos, Controlador, Rutas, Vistas)
- [x] **4 Modelos Eloquent** creados y verificados contra el esquema SQL:
  - `Supplier`, `Product`, `PurchaseOrder`, `PurchaseOrderLine`
  - Relaciones `hasMany` / `belongsTo` correctamente declaradas
  - `$fillable` y `$timestamps` alineados con cada tabla
  - `line_total` excluido del `$fillable` (columna GENERATED en MySQL)
- [x] **`PurchaseOrderController`** con:
  - `index()` → historial con eager loading `with(['supplier', 'requester', 'lines.product'])`
  - `create()` → carga proveedores y productos activos desde BD
  - `store()` → genera `po_number` automático, calcula subtotal (IVA 16%), inserta en `purchase_orders` y `purchase_order_lines`
  - `destroy()` → elimina la orden (líneas se borran por CASCADE en la FK de MySQL)
- [x] **Rutas** en `web.php`: todas las rutas de negocio protegidas con `middleware('auth')`
- [x] **API interna** `GET /api/suppliers/{id}/products` → endpoint AJAX para el formulario

### Fase 2 — Autenticación + Módulo Proveedores
- [x] **`AuthController`** con `showLoginForm()`, `login()` (usa `Auth::attempt()`), `logout()`
- [x] **Login page** (`/login`) — diseño de dos paneles (decorativo + formulario)
- [x] **`SupplierController`** con `index()` → stats (total proveedores, productos, órdenes) + tabla
- [x] **Layout `app.blade.php`** actualizado:
  - Topbar muestra nombre completo + rol + inicial del usuario autenticado (`auth()->user()->...`)
  - "Cerrar Sesión" hace POST al route `logout` (invalidación segura de sesión)
  - Enlace "Proveedores" en sidebar apunta a `route('suppliers.index')`

### Vistas Blade
- [x] `layouts/app.blade.php` — Layout maestro con sidebar + topbar
- [x] `auth/login.blade.php` — Página de inicio de sesión
- [x] `orders/create.blade.php` — Formulario de nueva solicitud (3 Cards: Proveedor, Producto, Logística)
- [x] `orders/index.blade.php` — Historial con tabla y botón eliminar
- [x] `suppliers/index.blade.php` — Directorio con KPI cards y tabla detallada

---

## 🗺️ Mapa de Archivos del Proyecto

```
project-compras/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php          ← Login / Logout
│   │   ├── PurchaseOrderController.php ← CRUD órdenes de compra
│   │   └── SupplierController.php      ← Vista de proveedores + stats
│   └── Models/
│       ├── User.php                    ← Tabla: users (first_name, last_name, role...)
│       ├── Supplier.php                ← Tabla: suppliers
│       ├── Product.php                 ← Tabla: products
│       ├── PurchaseOrder.php           ← Tabla: purchase_orders
│       └── PurchaseOrderLine.php       ← Tabla: purchase_order_lines
├── routes/
│   └── web.php                         ← Rutas públicas (login) + protegidas (auth)
└── resources/views/
    ├── layouts/
    │   └── app.blade.php               ← Layout maestro (sidebar + topbar)
    ├── auth/
    │   └── login.blade.php             ← Página de login
    ├── orders/
    │   ├── create.blade.php            ← Formulario nueva solicitud
    │   └── index.blade.php             ← Historial de órdenes
    └── suppliers/
        └── index.blade.php             ← Directorio de proveedores
```

---

## 🔐 Credenciales de Acceso (Base de Datos)

| Email | Contraseña | Rol |
|---|---|---|
| ana.garcia@empresa.com | `password` | REQUESTER |
| carlos.lopez@empresa.com | `password` | APPROVER |
| elena.martinez@empresa.com | `password` | ADMIN |

> Hash bcrypt compatible con Laravel. Todos los usuarios están en la tabla `users` de `procurement_db`.

---

## 🚧 MEJORAS PENDIENTES (Retomar próxima semana)

### Mejora 1 — Dinamizar el panel de credenciales del Login ⭐ PRIORIDAD BAJA
**Identificada el: 19/05/2026**
**Esfuerzo estimado: 5 minutos — 2 archivos, ~6 líneas**

**Problema actual:**
En `resources/views/auth/login.blade.php` (líneas 301–315), la sección
"Credenciales disponibles" tiene los emails de los usuarios escritos de forma
**estática en el HTML**. Si se agrega o modifica un usuario en la BD, esa sección
no se actualiza automáticamente.

**Solución diseñada (Escenario A — ya analizada):**

*Cambio 1 — `app/Http/Controllers/AuthController.php` método `showLoginForm()`:*
```php
// ANTES (línea 16):
return view('auth.login');

// DESPUÉS:
$users = \App\Models\User::where('is_active', true)->get(['first_name', 'last_name', 'email', 'role']);
return view('auth.login', compact('users'));
```

*Cambio 2 — `resources/views/auth/login.blade.php` (reemplazar líneas 301–315):*
```blade
<div class="demo-credentials">
    <strong><i class="bi bi-info-circle me-1"></i> Credenciales disponibles</strong>
    @foreach($users as $user)
        <div class="cred-row">
            <span>{{ $user->email }}</span>
            <code>password</code>
        </div>
    @endforeach
</div>
```

**Resultado:** Si en el futuro se agrega un usuario nuevo a la tabla `users`,
aparecerá automáticamente en el panel de login sin tocar el código.

---

### Mejora 2 — CRUD completo de Usuarios (Gestión desde la interfaz) ⭐ PRIORIDAD MEDIA
**Identificada el: 19/05/2026**
**Esfuerzo estimado: 30–45 minutos — 4 archivos nuevos/modificados**

**Problema actual:**
Los usuarios solo pueden ser creados/editados directamente en la base de datos
(via Workbench o SQL). No existe una interfaz en la aplicación para gestionar usuarios.

**Solución diseñada (Escenario B — ya analizada):**

Archivos a crear:
- `app/Http/Controllers/UserController.php` — métodos: `index`, `create`, `store`, `edit`, `update`, `destroy`
- `resources/views/users/index.blade.php` — tabla de usuarios con acciones
- `resources/views/users/create.blade.php` — formulario nuevo usuario (y edición)

Modificaciones necesarias:
- `routes/web.php` — agregar `Route::resource('users', UserController::class)`
- `resources/views/layouts/app.blade.php` — agregar enlace "Usuarios" en sidebar (solo visible para rol ADMIN)

Consideraciones técnicas ya analizadas:
- La tabla `users` ya tiene todos los campos necesarios (`role`, `is_active`) → **NO requiere migración**
- El password debe guardarse con `Hash::make($request->password)` al crear
- Al editar: validación `unique:users,email,{id}` para no conflictuar el email propio
- Protección por rol: solo `role = ADMIN` debería acceder → usar un middleware o `Gate`

---

## 📋 Rutas Registradas (Estado actual)

```
GET|HEAD  /login                          → AuthController@showLoginForm   [login]
POST      /login                          → AuthController@login
POST      /logout                         → AuthController@logout          [logout]
GET|HEAD  /                               → redirect orders.create
GET|HEAD  /orders                         → PurchaseOrderController@index   [orders.index]
POST      /orders                         → PurchaseOrderController@store   [orders.store]
GET|HEAD  /orders/create                  → PurchaseOrderController@create  [orders.create]
DELETE    /orders/{purchaseOrder}         → PurchaseOrderController@destroy [orders.destroy]
GET|HEAD  /suppliers                      → SupplierController@index        [suppliers.index]
GET|HEAD  /api/suppliers/{supplier}/products → (closure AJAX)              [api.supplier.products]
```

---

## 💡 Notas Técnicas Importantes

1. **`SESSION_DRIVER=database`** → La tabla `sessions` ya existe (creada en la migración base). Las sesiones se persisten en MySQL, no en archivos.

2. **`line_total` en `purchase_order_lines`** → Es una columna `GENERATED ALWAYS AS (quantity * unit_price) STORED` en MySQL. **Nunca debe incluirse en un INSERT desde PHP**. Laravel la leerá como solo lectura.

3. **`$timestamps = false`** está declarado en los modelos `Supplier`, `Product` y `PurchaseOrderLine` porque esas tablas no tienen la columna `updated_at`.

4. **Route Model Binding** está activo en `destroy()` → Laravel resuelve el `PurchaseOrder` automáticamente por el `{purchaseOrder}` en la URL, sin necesitar `findOrFail()` manual.

5. **Eager Loading** en `PurchaseOrderController@index` usa `with(['supplier', 'requester', 'lines.product'])` para evitar el problema N+1 en el historial.
