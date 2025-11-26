# Sistema de Gestión de Gimnasio 🏋️

Una aplicación web completa para administrar un gimnasio, desarrollada con **Laravel 11** y **Blade + Tailwind CSS**.

---

## 📋 Características Principales

### 🔐 Sistema de Roles y Autenticación

La aplicación utiliza tres roles principales con accesos diferenciados:

1. **Administrador (Admin)**
   - Control total del sistema
   - Gestión de usuarios (crear, editar, eliminar, desactivar)
   - Gestión de clases (crear, editar, desactivar)
   - Gestión de membresías
   - Gestión de pagos
   - Protección contra eliminación de cuenta de admin

2. **Personal (Staff)**
   - Registrar entradas/salidas de clientes
   - Ver lista de socios
   - Registrar pagos manuales
   - Consultar clases disponibles

3. **Cliente (Client)**
   - Ver perfil y membresía activa
   - Consultar historial de asistencia
   - Ver historial de pagos
   - Ver clases a las que se ha anotado

---

## 🎯 Funcionalidades Detalladas

### 👥 Gestión de Usuarios

**Admin:**
- Crear nuevos usuarios con rol asignado (Admin, Staff, Cliente)
- Editar información de usuarios
- Desactivar/Reactivar usuarios
- Eliminar usuarios (excepto el propio admin)
- Visualizar estado activo/inactivo

**Características:**
- Campo `is_active` para controlar acceso sin eliminar datos
- Validación de roles en rutas con middleware `CheckRole`
- SweetAlert2 para confirmaciones de acciones destructivas

---

### 📚 Gestión de Clases

**Admin:**
- Crear clases con capacidad máxima
- Asignar entrenador a cada clase
- Definir horarios (días y bloques horarios)
- Activar/desactivar clases
- Tabla `class_schedules` con información de horarios por día

**Staff:**
- Consultar clases disponibles (lectura)

**Cliente:**
- Ver clases a las que se ha anotado
- Ver horarios y próximas sesiones
- Visualizar última asistencia registrada

---

### 💳 Gestión de Membresías

**Admin:**
- Crear membresías asignadas a clientes
- Definir plan, precio, vigencia (fecha inicio/fin)
- Editar membresías existentes
- Eliminar membresías
- **Nota:** Cuando se crea una membresía con precio, automáticamente se registra un pago en el sistema

**Cliente:**
- Ver membresía activa actual
- Consultar vigencia del plan
- Visualizar detalles del plan

---

### 💰 Gestión de Pagos

**Admin:**
- Crear/editar/eliminar pagos manuales
- Registrar método de pago (efectivo, tarjeta, transferencia, manual)
- Asignar estado (completado, pendiente, fallido)
- Vincular pagos a membresías

**Staff:**
- Registrar pagos manuales de clientes

**Cliente:**
- Ver historial de pagos
- Estadísticas mensuales y totales
- Detalles de cada transacción (fecha, concepto, monto, estado)

---

### 📍 Registrar Asistencia (Check-in/Check-out)

**Staff - Registrar Entrada:**
1. Seleccionar socio (cliente)
2. Seleccionar clase
3. Seleccionar fecha (sin restricciones)
4. Seleccionar bloque horario (6:00-21:00 en intervalos de 1 hora)
5. Registrar entrada

**Validaciones:**
- Verificación de capacidad: si la clase llega al cupo máximo en esa fecha, se muestra error
- Mensaje: "Cupo completo para esa clase en la fecha seleccionada. Por favor selecciona otra actividad."

**Staff - Registrar Salida:**
- Desde el historial reciente, registrar salida de un cliente "En clase"

**Cliente:**
- Ver historial de asistencias
- Estadísticas: visitas este mes y total de visitas
- Visualizar fecha y hora de cada entrada/salida

---

## 🏗️ Arquitectura y Estructura de Base de Datos

### Tablas Principales

```
users
├── id, name, email, password, role_id, is_active, created_at, updated_at

roles
├── id, name (admin, staff, client)

classes
├── id, name, description, capacity, schedule, trainer_id, is_active

class_schedules
├── id, class_id, day_of_week (0-6), day_name, start_time, end_time

attendance
├── id, user_id, class_id, check_in, check_out

memberships
├── id, user_id, plan_name, price, description, start_date, end_date, is_active

payments
├── id, user_id, membership_id, concept, amount, payment_method, status, payment_date, notes
```

### Relaciones Clave

- **User → Role** (belongsTo) / **Role → User** (hasMany)
- **User → Attendance** (hasMany)
- **User → Membership** (hasMany)
- **User → Payment** (hasMany)
- **GymClass → ClassSchedule** (hasMany)
- **GymClass → Attendance** (hasMany)
- **Membership → Payment** (hasMany)

---

## 🛠️ Stack Tecnológico

- **Backend:** Laravel 11
- **Frontend:** Blade Templates + Tailwind CSS
- **Base de Datos:** MySQL
- **Autenticación:** Laravel Breeze
- **Alertas:** SweetAlert2 (CDN)
- **Validación:** Laravel Request Validation
- **Middleware:** Custom role-based access control

---

## 📦 Instalación

### Requisitos
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js 18+ (para assets)

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone <repository-url>
   cd gym-project
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   npm install
   ```

3. **Configurar archivo .env**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Configurar variables de base de datos:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gym_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Ejecutar migraciones**
   ```bash
   php artisan migrate
   ```

5. **Ejecutar seeders (datos de prueba)**
   ```bash
   php artisan db:seed
   ```

6. **Compilar assets**
   ```bash
   npm run build
   ```

7. **Iniciar servidor**
   ```bash
   php artisan serve
   ```

---

## 👤 Usuarios de Prueba (Seeder)

Después de ejecutar `php artisan db:seed`:

| Email | Contraseña | Rol |
|-------|-----------|-----|
| admin@gimnasio.com | password | Admin |
| staff@example.com | password | Staff |
| cliente@example.com | password | Cliente |

---

## 🔒 Sistema de Alertas y Confirmaciones

Se integró **SweetAlert2** (CDN) para todas las acciones destructivas:

- **Crear**: Toast de éxito con sesión
- **Editar**: Toast de confirmación
- **Eliminar/Desactivar**: Modal de confirmación con SweetAlert
- **Errores**: Toast de error en rojo

Formularios con clase `swal-form` automáticamente muestran confirmación antes de enviar.

---

## 🚀 Rutas Principales

### Admin (`/admin`)
- `GET /dashboard` - Panel de control
- `GET|POST /users` - Gestión de usuarios
- `GET|POST /classes` - Gestión de clases
- `GET|POST /memberships` - Gestión de membresías
- `GET|POST /payments` - Gestión de pagos

### Staff (`/staff`)
- `GET /dashboard` - Panel de control
- `GET /members` - Ver socios
- `GET|POST /attendance` - Registrar entradas/salidas
- `GET|POST /payments` - Registrar pagos
- `GET /classes` - Ver clases (lectura)

### Cliente (`/client`)
- `GET /dashboard` - Panel personal
- `GET /memberships` - Ver membresías
- `GET /attendance` - Historial de asistencia
- `GET /payments` - Historial de pagos
- `GET /classes` - Clases anotadas

---

## 🎨 Interfaz de Usuario

### Componentes Tailwind
- Botones, inputs, selects personalizados
- Tablas con paginación
- Cards con gradientes
- Badges de estado
- Modales y confirmaciones

### Temas por Rol
- **Admin:** Rojo/Indigo
- **Staff:** Azul/Verde
- **Client:** Púrpura/Naranja

---

## 🔐 Middleware y Seguridad

### Middleware Personalizado
- **CheckRole:** Valida que el usuario tenga el rol requerido
- **Verificación de autenticación:** Todas las rutas protegidas requieren login

### Protecciones Implementadas
- No se puede eliminar/desactivar el usuario admin
- Validación de capacidad en check-in
- Validación de datos en server-side
- CSRF protection en todos los formularios

---

## 📊 Funcionalidades Avanzadas

### 1. Restricción de Capacidad en Asistencia
- Cuando un cliente llega al cupo máximo en una clase para una fecha, el sistema rechaza nuevos check-ins
- El staff recibe un mensaje claro para seleccionar otra clase

### 2. Generación Automática de Pagos
- Al crear una membresía desde admin con precio > 0, se genera automáticamente un registro de pago
- El pago aparece inmediatamente en el historial del cliente

### 3. Visualización de Clases por Cliente
- Los clientes ven todas las clases a las que se han anotado (basado en asistencias)
- Incluye horarios, entrenador y última asistencia

### 4. Control de Activo/Inactivo
- Los usuarios pueden ser desactivados sin perder datos históricos
- Las clases pueden ser desactivadas pero siguen siendo referenciadas en asistencias

---

## 🐛 Troubleshooting

### Error de permisos en archivos
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Migraciones no se ejecutan
```bash
php artisan migrate:fresh --seed
```

### SweetAlert2 no funciona
- Verificar que `resources/views/layouts/navigation.blade.php` incluye el CDN
- Asegurar que la vista es `x-app-layout`

### Clase/Membresía no aparece
- Verificar que `is_active = 1` en la base de datos
- Confirmar que el usuario tiene el rol correcto

---

## 📝 Próximos Pasos / Mejoras Futuras

- [ ] Reportes PDF de asistencia
- [ ] Sistema de notificaciones por email
- [ ] Integración de pasarelas de pago (Stripe, PayPal)
- [ ] App móvil (React Native)
- [ ] Análisis y estadísticas avanzadas
- [ ] Sistema de promociones y descuentos
- [ ] QR para check-in rápido

---

## 👨‍💻 Desarrollo y Contribuciones

Para contribuir al proyecto:
1. Fork el repositorio
2. Crear una rama: `git checkout -b feature/nueva-funcionalidad`
3. Commit cambios: `git commit -m 'Add feature'`
4. Push a la rama: `git push origin feature/nueva-funcionalidad`
5. Abrir un Pull Request

---

## 📞 Soporte

Para reportar bugs o solicitar funcionalidades, abre un issue en el repositorio.

---

## 📄 Licencia

Este proyecto está bajo licencia MIT. Ver archivo `LICENSE` para más detalles.

---

**Versión:** 1.0.0  
**Última actualización:** Noviembre 26, 2025  
**Desarrollado con ❤️ usando Laravel 11**
