# Guía de Buenas Prácticas de Desarrollo - GambaStore

Este documento detalla las convenciones y estándares de calidad adoptados durante el desarrollo de **GambaStore**. El objetivo es garantizar un código limpio, mantenible y profesional.

## 1. Convenciones de Nomenclatura (Naming Conventions)

Se adoptó un enfoque híbrido para equilibrar la profesionalidad técnica con la claridad del dominio del negocio:

* **Funciones y Métodos en Inglés**: Se utilizan verbos de acción en inglés para los métodos de los controladores y modelos (ej: `store()`, `update()`, `uploadImage()`, `destroy()`). Esto alinea el proyecto con los estándares de Laravel y las librerías internacionales.
* **Variables y Datos de Dominio en Español**: Para que cualquier stakeholder o desarrollador local entienda el negocio, los campos de la base de datos y variables de vista están en español (ej: `precio`, `talles`, `marca`).
* **CamelCase vs snake_case**:
    * `CamelCase` para nombres de Clases y Controladores (`ProductController`).
    * `snake_case` para nombres de columnas en la base de datos y variables de ruta (`imagen_url`).

## 2. Manejo de Datos Sensibles (Security First)

* **Uso estricto de `.env`**: Nunca se incluyeron credenciales de **Cloudinary** o **MongoDB Atlas** directamente en el código. Se utiliza el archivo de configuración de entorno para proteger la privacidad y facilitar el despliegue en diferentes servidores.
* **Validación del Servidor**: No se confía en los datos del frontend. Todas las entradas se procesan mediante `$request->validate()`, asegurando que los tipos de datos (numeric, integer, image) coincidan con lo esperado antes de tocar la base de datos.

## 3. Arquitectura y Patrones

* **Principio de Responsabilidad Única (SRP)**: Cada función del controlador tiene una sola misión (ej: `store` solo valida y guarda, no muestra vistas).
* **Inyección de Configuración Dinámica**: Para evitar errores de carga en el Service Provider, se implementó la carga de configuración "On-the-fly". Esto permite que la aplicación sea resiliente incluso si el entorno local tiene configuraciones de SSL restrictivas.
* **Uso de Facades y SDKs**: Se combinó el uso de Facades de Laravel para limpieza sintáctica y el SDK directo de Cloudinary para robustez técnica en la comunicación con APIs externas.

## 4. Optimización de Base de Datos (NoSQL Best Practices)

* **Tipado de Datos Dinámico**: Aprovechando la flexibilidad de MongoDB, se transformaron campos de texto plano (talles separados por comas) en **Arrays** indexables.
* **Persistencia de Recursos Externos**: En lugar de procesar imágenes en cada carga, se almacena la **Secure URL** definitiva, reduciendo la latencia y el consumo de ancho de banda.

## 5. Clean Code en Vistas (Blade)

* **Directivas de Laravel**: Uso de `@csrf` para protección contra ataques de falsificación de peticiones y `@method()` para cumplir con los estándares de verbos RESTful (`PUT`, `DELETE`).
* **Lógica en Controladores, no en Vistas**: Las vistas (`.blade.php`) se mantienen limpias, limitándose a mostrar datos procesados previamente por el controlador.
* **Operadores Ternarios para UX**: Uso de lógica condicional simple en los atributos `value` para mejorar la experiencia de edición del usuario.

## 6. Manejo de Errores y Logs

* **Bypass de SSL en Desarrollo**: Implementación controlada de `verify => false` en contextos de desarrollo para evitar bloqueos por certificados locales, documentando claramente que es una práctica exclusiva para el entorno local.
* **Feedback al Usuario**: Redirecciones con mensajes de estado para confirmar el éxito de las operaciones CRUD.

---
*GambaStore: Código desarrollado bajo estándares de legibilidad y escalabilidad.*
