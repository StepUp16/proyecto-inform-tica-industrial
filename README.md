# WareStock V1

Sistema de gestión de inventario, ventas y producción para empresas de publicidad e impresión. Desarrollado con PHP y MySQL, basado en CoreUI v4.

## Módulos

### Imprescindibles
- **Productos** — Catálogo con código, precios, unidad, stock mínimo y tipo (materia prima / producto terminado)
- **Inventario** — Control de entradas y salidas con cálculo de stock en tiempo real
- **Ventas / POS** — Carrito, descuentos, selección de cliente y procesamiento de pedidos
- **Clientes** — Registro de clientes con datos de contacto e historial de compras
- **Dashboard** — KPIs: ventas vs meta, alertas de stock, órdenes activas
- **Caja** — Apertura, cierre y corte de caja

### Importantes
- **Usuarios** — Gestión de operadores con roles (admin / operador)
- **Categorías** — Clasificación de productos
- **Proveedores** — Registro de proveedores de insumos y materiales
- **Historial de Ventas** — Consulta de órdenes pasadas por fecha y producto
- **Alertas de Stock** — Notificaciones de inventario mínimo en dashboard
- **Reportes PDF** — Inventario, ventas, productos, clientes, proveedores, alertas

### Opcionales
- **Taller / Producción** — Cola de órdenes de producción con estados (Pendiente → En Prensa → Terminado → Listo para Instalación)
- **Recetas (BOM)** — Producto compuesto con desglose de materias primas
- **Materia Prima** — Distinción entre insumos y productos terminados
- **Prioridad y Fecha de Entrega** — Gestión de tiempos de producción
- **Diseño URL** — Enlace a diseño aprobado por el cliente
- **Auditoría / Bitácora** — Trazabilidad de acciones de usuarios
- **Corte de Caja** — Resumen contable por período

## Tecnología

| Capa | Tecnología |
|---|---|
| Servidor | Apache (XAMPP/LAMPP) |
| Backend | PHP 8.2+ |
| Base de datos | MySQL / MariaDB 10.4+ |
| Frontend | CoreUI v4 (Bootstrap 5) |
| JavaScript | jQuery, DataTables, Chart.js |
| PDF | FPDF |
| Alertas | SweetAlert2 |

## Instalación

Requiere Apache + PHP + MySQL (XAMPP o LAMPP recomendado).

1. Clona o descarga este repositorio en tu carpeta `htdocs` (XAMPP) o `/var/www/` (LAMP)
2. La base de datos `warestock` con todas las tablas y datos de ejemplo está incluida en el archivo `schema.sql`
3. Importa el schema: `mysql -u root warestock < schema.sql`
4. Configura la conexión en `core/controller/Database.php` si tus credenciales son distintas
5. Accede desde `http://localhost/[nombre-carpeta]/`
6. Usuario por defecto:
   - **Usuario:** admin
   - **Contraseña:** admin

> El archivo `schema.sql` incluye la estructura completa de la base de datos, un inventario inicial realista para una empresa de publicidad (34 materias primas, 17 productos terminados), 3 órdenes de producción de ejemplo, 3 clientes y 5 proveedores.
