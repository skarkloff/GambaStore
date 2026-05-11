# GambaStore - Tienda de Botines de Futbol

**GambaStore** es una aplicacion web de gestion de inventario de botines desarrollada con **Laravel 12**, **Google Cloud Firestore** y desplegada en **Vercel**. Implementa una estetica visual retro inspirada en los videojuegos de futbol de los 2000.

## Tecnologias

| Capa | Tecnologia |
|---|---|
| Framework | Laravel 12 / PHP 8.2 |
| Base de datos | Google Cloud Firestore (NoSQL) |
| Almacenamiento de imagenes | Cloudinary |
| Deploy | Vercel (serverless PHP) |
| Frontend | Blade + Tailwind CSS + Vite |
| Tipografia | Press Start 2P / Oswald (Google Fonts) |

## Arquitectura

El proyecto sigue el patron **MVC** de Laravel con una particularidad: en lugar del ORM Eloquent (que trabaja con SQL), usa un **modelo custom** que se comunica directamente con Firestore via el SDK de Google Cloud.

```
Request HTTP
    -> routes/web.php          (URLs)
    -> ProductController       (logica)
    -> Product::all/create/... (modelo custom)
    -> FirestoreService        (wrapper SDK Google)
    -> Firestore (Google Cloud) (base de datos)
```

### Estructura de archivos relevante

```
app/
├── Http/Controllers/
│   └── ProductController.php   # CRUD de productos
├── Models/
│   └── Product.php             # Modelo sin Eloquent, habla con Firestore
└── Services/
    └── FirestoreService.php    # Conexion con Google Cloud Firestore

resources/views/
├── welcome.blade.php           # Landing page (/)
└── products/
    ├── index.blade.php         # Listado /admin/productos
    ├── create.blade.php        # Formulario nuevo producto
    └── edit.blade.php          # Formulario edicion

database/seeders/
└── ProductSeeder.php           # 8 botines de prueba

api/
├── index.php                   # Entry point para Vercel
└── php.ini                     # Extensiones PHP para produccion
```

## Decisiones de arquitectura

### Firestore en lugar de SQL
El modelo `Product` no extiende de `Eloquent\Model`. Implementa sus propios metodos estaticos (`all`, `create`, `findOrFail`) que interactuan directamente con la coleccion `products` de Firestore. Esto elimina la necesidad de migraciones y permite un esquema flexible.

### Credenciales en dos entornos
- **Local**: `GOOGLE_APPLICATION_CREDENTIALS` apunta al archivo `.json` de la service account.
- **Vercel**: `FIREBASE_CREDENTIALS` contiene el JSON inline como variable de entorno. `FirestoreService` detecta cual usar automaticamente.

### Imagenes con Cloudinary
Las imagenes no se almacenan en el servidor. El controller sube el archivo a Cloudinary y persiste solo la URL en Firestore. Esto es compatible con el modelo serverless de Vercel, que no tiene sistema de archivos persistente.

### Deploy serverless en Vercel
`vercel.json` define que todo request que no sea un asset estatico se redirige a `api/index.php`, que bootstrapea Laravel. Las vistas compiladas, caches y archivos temporales (incluyendo las credenciales de Firebase) van a `/tmp`.

## Instalacion local

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install && npm run build
```

Configurar en `.env`:

```
GOOGLE_APPLICATION_CREDENTIALS=/ruta/a/firebase-credentials.json
FIREBASE_PROJECT_ID=tu-project-id
CLOUDINARY_CLOUD_NAME=...
CLOUDINARY_API_KEY=...
CLOUDINARY_API_SECRET=...
```

Levantar el servidor:

```bash
composer run dev
```

Cargar datos de prueba:

```bash
php artisan db:seed --class=ProductSeeder
```

## Rutas

| Metodo | URL | Descripcion |
|---|---|---|
| GET | `/` | Landing page |
| GET | `/admin/productos` | Listado de productos |
| GET | `/admin/productos/nuevo` | Formulario nuevo producto |
| POST | `/admin/productos/guardar` | Guardar producto |
| GET | `/admin/productos/{id}/editar` | Formulario edicion |
| PUT | `/admin/productos/{id}` | Actualizar producto |
| DELETE | `/admin/productos/{id}` | Eliminar producto |

---
Desarrollado para el Laboratorio de **Aplicaciones Web** -- 2026.
Lautaro Skarkloff & Patricio Zappellini.
