# GambaStore — Guía de Estilos del Panel de Control

Estética **Neo-Brutalista**: bordes duros, sombras offset sin difuminado, tipografía en mayúsculas y colores planos saturados. Todo lo que se agregue al panel debe respetar este lenguaje visual.

---

## Paleta de colores

| Variable / Token | Valor     | Uso                                      |
|-----------------|-----------|------------------------------------------|
| `--bg`          | `#b8b8b8` | Fondo de todas las páginas               |
| `--text`        | `#000000` | Texto general y bordes                   |
| `--border`      | `#000000` | Bordes y sombras offset                  |
| `--yellow`      | `#ffde00` | Acento módulo Productos / h1 de forms    |
| `--cyan`        | `#00ffff` | Acento módulo Usuarios / botón primario  |
| verde acción    | `#00ff00` | Botón guardar/crear (en forms nuevos)    |
| rojo peligro    | `#ff4545` | Botón eliminar / logout / cancelar       |
| blanco          | `#ffffff` | Fondo de tablas y cards; botón volver    |
| negro           | `#000000` | Topbar, encabezados de tabla (`<th>`)    |

**Regla de módulos:** cada sección del panel tiene un color acento propio que se aplica al `h1` y a las cards del dashboard.
- Productos → `#ffde00`
- Usuarios → `#00ffff`
- Módulos futuros → elegir un color nuevo del espectro neón (ej. `#ff00ff`, `#ff8800`) sin repetir los existentes.

---

## Tipografía

```css
font-family: 'Arial Black', Gadget, sans-serif; /* principal — todo el panel */
font-family: sans-serif;                         /* secundaria — hints, descripciones */
```

- **Todo en mayúsculas** (`text-transform: uppercase`) en títulos, labels, botones y textos de navegación.
- `font-weight: 900` como mínimo en cualquier texto prominente.
- Textos de ayuda (`hint`, `card-desc`, mensajes de error) pueden ir en `font-family: sans-serif` sin `Arial Black`.

---

## Bordes y sombras (firma neo-brutalista)

No se usan sombras difuminadas (`blur`). La sombra es siempre un offset duro negro.

| Elemento          | Border                  | Box-shadow              |
|-------------------|-------------------------|-------------------------|
| Tablas / formularios grandes | `6px solid #000` | `15px 15px 0px #000` |
| Títulos h1 (index)| `6px solid #000`        | `10px 10px 0px #000`   |
| Títulos h1 (forms)| `5px solid #000`        | `8px 8px 0px #000`     |
| Cards de dashboard| `6px solid #000`        | `15px 15px 0px #000`   |
| Botones grandes   | `4px solid #000`        | `5px 5px 0px #000`     |
| Botones pequeños  | `4px solid #000`        | `4px 4px 0px #000`     |
| Celdas de tabla   | `3px solid #000`        | —                       |
| Inputs / selects  | `3px solid #000`        | —                       |

---

## Variables CSS base

Cada vista debe declarar estas variables (o incluir un layout que las provea):

```css
:root {
    --bg:     #b8b8b8;
    --text:   #000000;
    --border: #000000;
    --yellow: #ffde00;
    --cyan:   #00ffff;
}
```

---

## Componentes

### `body` y layout general

```css
body {
    background-color: var(--bg);
    color: var(--text);
    font-family: 'Arial Black', Gadget, sans-serif;
    padding: 40px;
    line-height: 1.2;
}

.container {
    max-width: 1200px; /* grillas */
    /* max-width: 700px  para formularios */
    /* max-width: 1000px para dashboard   */
    margin: 0 auto;
}
```

---

### Encabezado de sección (`h1`)

```css
h1 {
    font-size: 3rem;           /* index/grillas */
    /* font-size: inherit; */  /* forms — tamaño libre */
    text-transform: uppercase;
    background-color: var(--yellow); /* o --cyan según módulo */
    display: inline-block;
    padding: 10px 30px;
    border: 6px solid var(--border);
    box-shadow: 10px 10px 0px var(--border);
    margin-bottom: 10px;
}
```

Formato del texto: `MÓDULO / SUBSECCIÓN` (ej. `PANEL DE CONTROL / USUARIOS`, `EDITAR BOTÍN / PREDATOR`).

---

### Subtítulo de sección

```css
.subtitle {
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 40px;
    display: block;
}
```

---

### Topbar

Parcial en `resources/views/partials/topbar.blade.php`. **No duplicar estilos de topbar en las vistas.** Siempre incluir con `@include('partials.topbar')` como primera línea.

- Fondo negro, borde inferior `5px solid #ffde00`.
- Marca a la izquierda en amarillo, acciones a la derecha.
- Botón perfil: `#ffde00`. Botón logout: `#ff4545`.
- Estado `:active`: `transform: translate(3px, 3px); box-shadow: 0 0 0`.

---

### Tablas (grillas de listado)

```css
table {
    width: 100%;
    border-collapse: collapse;
    border: 6px solid var(--border);
    box-shadow: 15px 15px 0px var(--border);
    background: white;
}

th {
    background-color: var(--text); /* negro */
    color: white;
    text-transform: uppercase;
    padding: 20px;
    text-align: left;
    border-bottom: 6px solid var(--border);
}

td {
    padding: 20px;
    border: 3px solid var(--border);
    font-weight: 900;
    font-size: 1.1rem;
}

tr:hover { background-color: #f0f0f0; }
```

---

### Formularios

```css
form.main-form {
    border: 5px solid #000;
    padding: 30px;
    box-shadow: 15px 15px 0px #000;
    max-width: 700px;
    margin-top: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    background: var(--bg);
}

.field        { display: flex; flex-direction: column; }
.full-width   { grid-column: span 2; }

label {
    text-transform: uppercase;
    font-weight: 900;
    margin-bottom: 5px;
}

input,
select,
textarea {
    padding: 10px;
    border: 3px solid #000;
    font-family: sans-serif;
    font-weight: bold;
    font-size: 1rem;
}

.hint      { font-size: 0.8rem; font-family: Arial, sans-serif; color: #444; margin-top: 5px; }
.error-msg { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
```

**Estructura mínima de un campo:**
```blade
<div class="field">
    <label>Nombre del Campo</label>
    <input type="text" name="campo" value="{{ old('campo') }}" required>
    <span class="hint">Texto de ayuda opcional.</span>
    @error('campo') <span class="error-msg">{{ $message }}</span> @enderror
</div>
```

---

### Botones

#### Botones de formulario (grandes)

```css
.btn-group {
    grid-column: span 2;
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

.btn-save {
    flex: 1;
    background: #00ff00;       /* crear  */
    /* background: #00ffff; */ /* editar */
    padding: 15px;
    border: 4px solid #000;
    font-weight: 900;
    cursor: pointer;
    box-shadow: 5px 5px 0px #000;
    text-transform: uppercase;
    font-size: 1.4rem;
    font-family: 'Arial Black', sans-serif;
}
.btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }

.btn-cancel {
    flex: 1;
    background: #ff4545;
    color: white;
    padding: 15px;
    border: 4px solid #000;
    font-weight: 900;
    cursor: pointer;
    box-shadow: 5px 5px 0px #000;
    text-transform: uppercase;
    font-size: 1.4rem;
    font-family: 'Arial Black', sans-serif;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
```

#### Botones de tabla / navegación (pequeños)

```css
.btn {
    padding: 10px 20px;
    border: 4px solid var(--border);
    font-weight: 900;
    text-transform: uppercase;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    box-shadow: 4px 4px 0px var(--border);
    transition: all 0.1s;
    font-size: 0.9rem;
    font-family: 'Arial Black', sans-serif;
}
.btn:active { box-shadow: 0px 0px 0px var(--border); transform: translate(4px, 4px); }

.btn-edit   { background: #00ff00; color: black; margin-right: 10px; }
.btn-delete { background: #ff4545; color: white; }
```

Para botones de acción principal en la barra sobre la tabla:
```blade
<a href="{{ route('modulo.create') }}" class="btn" style="background-color: #00ffff; font-size: 1.2rem; color: #000;">
    AGREGAR NUEVO X +
</a>
<a href="{{ route('admin.dashboard') }}" class="btn" style="background-color: #ffffff; font-size: 1.2rem; color: #000;">
    ← VOLVER AL PANEL
</a>
```

---

### Cards del dashboard

```css
.menu-card {
    background: white;
    border: 6px solid var(--border);
    box-shadow: 15px 15px 0px var(--border);
    width: 320px;
    padding: 40px 20px;
    text-decoration: none;
    color: var(--text);
    transition: all 0.1s;
    box-sizing: border-box;
}
.menu-card:hover  { transform: translate(-4px, -4px); box-shadow: 19px 19px 0px var(--border); }
.menu-card:active { transform: translate(15px, 15px); box-shadow: 0px 0px 0px var(--border); }

.card-title { font-size: 1.8rem; text-transform: uppercase; margin-bottom: 15px; display: block; }
.card-desc  { font-family: sans-serif; font-weight: bold; font-size: 1rem; color: #555; }

/* Variantes por módulo */
.products-variant        { background-color: var(--yellow); }
.users-variant           { background-color: var(--cyan); }
.users-variant-disabled  { background-color: #ccc; opacity: 0.45; cursor: not-allowed; pointer-events: none; }
```

---

### Banner de error / alertas

```css
.error-banner {
    background: #ff4545;
    color: white;
    border: 4px solid #000;
    padding: 12px 20px;
    font-weight: 900;
    text-transform: uppercase;
    box-shadow: 5px 5px 0 #000;
    margin-bottom: 20px;
    max-width: 700px;
    font-size: 0.9rem;
}
```

```blade
@if(session('error'))
    <div class="error-banner">{{ session('error') }}</div>
@endif
```

---

## Checklist al agregar una nueva sección

- [ ] Incluye `@include('partials.topbar')` como primera línea
- [ ] Declara variables `:root` o usa las ya definidas
- [ ] `h1` con color acento del módulo, borde y sombra offset
- [ ] `body` con `background: #b8b8b8` y `font-family: 'Arial Black'`
- [ ] Si tiene tabla: usa `.container` con `max-width: 1200px`
- [ ] Si tiene formulario: grid 2 columnas, `max-width: 700px`, con `.full-width` para campos anchos
- [ ] Botón guardar en verde (`#00ff00`) para crear, en cyan (`#00ffff`) para editar
- [ ] Botón cancelar siempre en rojo (`#ff4545`) con `color: white`
- [ ] Estado `:active` en todos los botones (`translate + box-shadow: 0`)
- [ ] Textos en MAYÚSCULAS donde corresponda (labels, headers, botones)
- [ ] Mensajes de error con `.error-msg` (rojo oscuro, font-family sans-serif)
