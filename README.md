# Gestor de Productos

Aplicación web desarrollada con Laravel como parte de una prueba técnica de modernización y migración de un proyecto heredado (legacy) en PHP nativo hacia una arquitectura MVC moderna, segura y testeable.

El sistema permite gestionar un catálogo de productos y sus categorías, incluyendo autenticación de usuarios, validaciones en servidor y cliente, búsqueda en vivo mediante JavaScript, paginación y una suite de pruebas automatizadas.

---

## Tecnologías Utilizadas

- **Backend:** PHP 8.2+ / Laravel 11/12
- **Base de Datos:** MySQL / SQLite (entorno de pruebas)
- **Frontend:** Blade Templates, CSS3 puro y JavaScript Vanilla (Fetch API)
- **Testing:** Pest / PHPUnit
- **Control de Versiones:** Git & GitHub

---

## Funcionalidades Principales

### 1. Gestión de Productos (CRUD)
- **Listado y visualización:** Tabla detallada con nombre, categoría asociada, precio formateado, stock y estado.
- **Creación y edición:** Formularios estructurados con selección de categoría mediante relaciones de base de datos.
- **Borrado lógico (Soft Delete Custom):** La acción de eliminar desactiva el producto (`activo = false`) preservando la integridad histórica de los registros.
- **Paginación:** Paginación integrada con Eloquent (`paginate(10)`) optimizando el consumo de memoria.

### 2. Búsqueda Dinámica en Tiempo Real
- Búsqueda interactiva por nombre de producto consumiendo el endpoint `GET /productos/buscar`.
- Implementación en **JavaScript Vanilla** mediante `Fetch API` sin dependencias externas.
- Optimización con **Debounce (300ms)** para reducir la carga de peticiones al servidor.
- Protección contra inyecciones SQL mediante consultas parametrizadas con Eloquent (`LIKE %query%`).

### 3. Gestión de Categorías
- Listado y administración de categorías.
- Relación de uno a muchos (`1:N`) con productos (`Categoria hasMany Producto`).

### 4. Seguridad y Autenticación
- Sistema de Login y Logout seguro con regeneración de identificador de sesión y protección contra fijación de sesiones.
- Contraseñas encriptadas mediante `Hash::make()` (Bcrypt/Argon2).
- Rutas del dashboard protegidas mediante middleware de autenticación (`auth`).
- Protección transversal contra ataques **CSRF** en todos los formularios y peticiones asíncronas.

### 5. Validaciones Robustas
- **Capa Backend:** Implementadas mediante clases dedicadas `StoreProductoRequest` y `UpdateProductoRequest`:
  - `nombre`: Requerido, tipo string y longitud controlada.
  - `categoria_id`: Requerido y validado contra la existencia real en la tabla `categorias`.
  - `precio`: Numérico, mayor a 0 con precisión decimal.
  - `stock`: Entero, mayor o igual a 0.
  - `activo`: Booleano.
- **Capa Frontend:** Validación preventiva en cliente antes del envío de datos.

---

## Estructura de la Base de Datos

- **`users`:** Gestión de credenciales y acceso al panel administrativo.
- **`categorias`:** Maestro de categorías con campos `id`, `nombre` y marcas de tiempo (`timestamps`).
- **`productos`:** Catálogo principal con llave foránea `categoria_id`, campo indexado `nombre` para búsquedas eficientes, precio decimal `(10,2)`, stock no negativo y flag de estado booleano `activo`.

---

## Instalación y Configuración Local

Sigue estos pasos para desplegar el proyecto en un entorno local:

### 1. Clonar el repositorio
```bash
git clone [https://github.com/juliiex/Examen.git](https://github.com/juliiex/Examen.git)
cd Examen