# Sistema de Roles y Permisos - Gimnasio

## Configuración completada ✅

Se ha implementado un sistema completo de roles y permisos para el gimnasio:

### 1. ADMIN (Administrador)
- **Control total del sistema**
- Puede crear, editar, eliminar usuarios
- Gestiona clases, membresías, pagos
- Accede a los reportes
- Acceso: `/admin/dashboard`
- Gestión de usuarios: `/admin/users`

### 2. STAFF (Empleado / Recepcionista / Entrenador)
- **Acceso limitado**
- Puede ver socios
- Registrar entradas al gimnasio
- Registrar pagos
- Administrar clases
- **NO puede modificar roles ni usuarios del sistema**
- Acceso: `/staff/dashboard`

### 3. CLIENT (Cliente / Socio del gimnasio)
- **Acceso muy limitado**
- Solo ve su membresía
- Su historial de pagos
- Su asistencia
- Su perfil
- Acceso: `/client/dashboard`

## Cómo funciona

1. Cuando un usuario inicia sesión, automáticamente es redirigido a su dashboard según su rol:
   - Admin → `/admin/dashboard`
   - Staff → `/staff/dashboard`
   - Client → `/client/dashboard`

2. Las rutas están protegidas con middleware `role:` que verifica el rol del usuario
3. Si alguien intenta acceder a una ruta sin permiso, recibe un error 403

## Archivos modificados/creados

### Middleware
- `app/Http/Middleware/CheckRole.php` - Valida los permisos por rol

### Controladores
- `app/Http/Controllers/Admin/AdminDashboardController.php`
- `app/Http/Controllers/Staff/StaffDashboardController.php`
- `app/Http/Controllers/Client/ClientDashboardController.php`

### Rutas
- `routes/web.php` - Rutas protegidas por rol con redireccionamiento automático

### Vistas
- `resources/views/admin/dashboard.blade.php`
- `resources/views/staff/dashboard.blade.php`
- `resources/views/client/dashboard.blade.php`

### Configuración
- `bootstrap/app.php` - Registro del middleware de roles

## Para agregar más funcionalidades

En el archivo `routes/web.php`, verás comentarios `// TODO:` donde puedes agregar:
- Gestión de Clases
- Gestión de Membresías
- Gestión de Pagos
- Reportes
- Y más...
