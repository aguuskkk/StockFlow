<<<<<<< HEAD
# StockFlow
### Sistema de gestión de stock, ventas y gastos

> Administrá tu inventario, registrá ventas, controlá gastos y consultá reportes desde un solo lugar.

**Equipo:** Victoria Peñalba · Agustin Smith · Kamil Zawrzykraj
**Institución:** Polo Tecnológico del Cerro — Ingeniería en Software
**Docente:** Mag. Lic. Eduardo Olivera Pina
**Repositorio:** https://github.com/aguuskkk/StockFlow

## Descripción

StockFlow nació para reemplazar el control en papel y planillas por un sistema único donde todo queda registrado. Cuando entra mercadería, se genera un movimiento de entrada. Cuando se vende, se descuenta el stock. Si la venta se anula, el stock vuelve. Si un producto baja del mínimo, aparece en el dashboard para reponerlo.

El sistema trabaja con tres roles: el **administrador** ve todo, el **vendedor** se concentra en el punto de venta y el **repositor** en el inventario y la reposición. Cada cambio de stock queda guardado con fecha, usuario y motivo, para poder auditar entradas, salidas, ajustes y bajas.

---

## Tecnologías

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge)
![PDO](https://img.shields.io/badge/PDO-Prepared%20Statements-orange?style=for-the-badge)

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge)

![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge)
![Font%20Awesome](https://img.shields.io/badge/Font%20Awesome-528DD7?style=for-the-badge)
![Laragon](https://img.shields.io/badge/Laragon-00ADEF?style=for-the-badge)

</div>

| Capa | Tecnología | Para qué se usa |
|---|---|---|
| **Backend** | PHP 8 | Lógica del servidor, sesiones y control de roles |
| **Base de datos** | MySQL + PDO | Consultas preparadas, transacciones y bloqueo de filas |
| **De acceso a datos** | Patrón DAO | Cada tabla tiene su DAO (`ProductoDAO`, `VentasDAO`, `GastosDAO`, `MovimientosDAO`...) |
| **Frontend** | HTML5 + CSS3 | Vistas responsive con diseño propio por módulo |
| **Interactividad** | JavaScript (Fetch) | Buscadores con desplegable, carrito, reposición y reportes sin recargar la página |
| **Gráficos** | Chart.js | Ventas de los últimos 7 días y estado del stock en el dashboard |
| **Iconos** | Font Awesome | Iconografía de menús, botones y notificaciones |
| **Servidor local** | Laragon / XAMPP | Entorno de desarrollo y presentación |


## Funcionalidades

| Módulo | Qué hace |
|---|---|
| Dashboard | Resumen por rol, gráficos de ventas (7 días) y estado de stock, tabla de stock bajo con botón Reponer |
| Inventario | Alta, edición y baja lógica de productos, búsqueda con desplegable, paginación, stock mínimo |
| Ventas | Carrito, buscador en vivo, IVA 22%, historial y anulación con devolución automática de stock |
| Gastos | Alta y edición por categoría de gastos, estados pagado / pendiente / cancelado, totales del mes, promedio y categoría top |
| Usuarios | Alta de usuarios con contraseña hasheada y roles, búsqueda y eliminación (sin poder borrar tu propia cuenta) |
| Reportes | Ventas, gastos y movimientos de stock unificados por rango de fechas, total neto y descarga por impresión/PDF |
| Ayuda | Desplegables por sección filtrados según el rol: Dashboard, Inventario, Ventas, Gastos, Reportes, Usuarios |
| Errores | Páginas propias 403 / 404 / 500 |

## Roles

| Rol | Acceso |
|---|---|
| Administrador | Dashboard, Inventario, Ventas, Gastos, Reportes, Usuarios y Ayuda completa |
| Vendedor | Dashboard (ventas), Ventas y Ayuda de ventas |
| Repositor | Dashboard (stock), Inventario y Ayuda de inventario |

Las vistas y las APIs validan el rol en el servidor. Si intentás entrar a una sección sin permiso, ves la página de error 403.
=======
# StockFlow
>>>>>>> a51af37f8c2b59107383f7782ac2c70d6e6a0eec
