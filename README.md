# GambaStore - Gestión de Inventario de Botines

¡Bienvenido a **GambaStore**! Este es un sistema de gestión de inventario (CRUD) desarrollado con **Laravel 12** y **MongoDB**, diseñado específicamente para una tienda de calzado deportivo. El proyecto implementa una arquitectura moderna, manejo de imágenes en la nube y una estética visual **Neo-Brutalista**.

## 🚀 Características Principales

* **CRUD Completo**: Gestión total de productos (Crear, Leer, Actualizar y Eliminar).
* **Base de Datos NoSQL**: Integración nativa con **MongoDB Atlas** para un esquema flexible.
* **Imágenes en la Nube**: Almacenamiento y procesamiento de imágenes mediante la API de **Cloudinary**.
* **Arquitectura MVC**: Separación clara de responsabilidades (Modelos, Vistas y Controladores).
* **Validación de Datos**: Reglas estrictas para asegurar la integridad de la información.

## 🛠️ Tecnologías Utilizadas

* **Framework**: Laravel 12.x
* **Lenguaje**: PHP 8.5.x
* **Base de Datos**: MongoDB (vía `mongodb/laravel-mongodb`)
* **Almacenamiento**: Cloudinary (SDK de PHP)
* **Estilos**: CSS3 con diseño Brutalista (Tipografías pesadas, sombras planas, colores vibrantes).

## 💡 Buenas Prácticas Implementadas

### 1. Gestión de Variables de Entorno
Se utiliza el archivo `.env` para almacenar credenciales sensibles (Cloudinary, MongoDB). **Nunca** se hardcodean llaves de API en el código fuente, facilitando la portabilidad y seguridad del proyecto.

### 2. Procesamiento de Datos (Strings a Arrays)
Para los **talles** de los botines, el sistema recibe un String separado por comas desde el frontend y lo transforma en un **Array** antes de guardarlo en MongoDB. 
- **Ventaja**: Facilita futuras implementaciones de filtros de búsqueda por talle.

### 3. Carga Eficiente de Imágenes (Cloudinary)
En lugar de saturar el servidor local, las imágenes se envían directamente a Cloudinary.
- Se implementó una **instanciación manual del SDK** para evitar conflictos de carga en el Service Container.
- Se maneja la persistencia de la URL en la base de datos para asegurar una carga rápida vía CDN.

### 4. Seguridad y Validación
- **Validación del lado del servidor**: Se utiliza `$request->validate()` para asegurar que los precios sean numéricos, el stock sea entero y los archivos subidos sean realmente imágenes.
- **Bypass de SSL en Desarrollo**: Se configuró un manejo de contexto HTTP para evitar errores de certificados locales (`verify => false`) sin comprometer el entorno de producción.

### 5. Interfaz de Usuario (UX)
- Uso de `@method('PUT')` y `@method('DELETE')` para cumplir con los estándares de verbos HTTP.
- Implementación de `enctype="multipart/form-data"` indispensable para el envío de binarios.
- Mensajes de confirmación y vistas previas de imágenes en la edición.

## 📂 Estructura del Proyecto (Desarrollo)

1.  **Modelos**: `Product.php` configurado para extender de `MongoDB\Laravel\Eloquent\Model`.
2.  **Controladores**: `ProductController.php` centraliza la lógica de negocio y comunicación con APIs externas.
3.  **Vistas**: Localizadas en `resources/views/products/`, utilizando **Blade** como motor de plantillas.
4.  **Rutas**: Rutas protegidas bajo el prefijo `/admin` para la gestión administrativa.

## 📝 Notas de Desarrollo
Durante el desarrollo se superaron retos técnicos importantes, como la configuración de cURL en entornos Windows y la integración de proveedores de servicios en la nueva estructura minimalista de Laravel 12.

---
Desarrollado para el Laboratorio de **Aplicaciones Web**. 2026.
