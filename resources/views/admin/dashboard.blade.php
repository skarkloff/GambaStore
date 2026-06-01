<style>
    :root {
        --bg: #b8b8b8;
        --text: #000000;
        --border: #000000;
        --yellow: #ffde00;
        --cyan: #00ffff;
    }

    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Arial Black', Gadget, sans-serif;
        padding: 40px;
        line-height: 1.2;
    }

    .container {
        max-width: 1000px;
        margin: 0 auto;
        text-align: center;
    }

    h1 {
        font-size: 3rem;
        text-transform: uppercase;
        background-color: white;
        display: inline-block;
        padding: 15px 40px;
        border: 6px solid var(--border);
        box-shadow: 12px 12px 0px var(--border);
        margin-bottom: 20px;
    }

    .subtitle {
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 50px;
        display: block;
        font-size: 1.1rem;
    }

    /* Contenedor de las opciones del menú */
    .menu-grid {
        display: flex;
        gap: 40px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    /* Tarjetas de Navegación */
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

    .menu-card:hover {
        transform: translate(-4px, -4px);
        box-shadow: 19px 19px 0px var(--border);
    }

    .menu-card:active {
        transform: translate(15px, 15px);
        box-shadow: 0px 0px 0px var(--border);
    }

    .card-title {
        font-size: 1.8rem;
        text-transform: uppercase;
        margin-bottom: 15px;
        display: block;
    }

    .card-desc {
        font-family: sans-serif;
        font-weight: bold;
        font-size: 1rem;
        color: #555;
    }

    .products-variant { background-color: var(--yellow); }
    .users-variant { background-color: var(--cyan); }

    .error-banner {
        background: #ff4545; color: white; border: 4px solid #000;
        padding: 12px 20px; font-weight: 900; text-transform: uppercase;
        box-shadow: 5px 5px 0 #000; margin-bottom: 20px; max-width: 700px;
        font-size: 0.9rem;
    }

</style>

@include('partials.topbar')

<div class="container">
    <h1>PANEL PRINCIPAL DE ADMINISTRACIÓN</h1>
    <span class="subtitle">Seleccioná un módulo para comenzar la gestión de datos.</span>

    @if(session('error'))
        <div class="error-banner">{{ session('error') }}</div>
    @endif

    <div class="menu-grid">
        <a href="{{ route('products.index') }}" class="menu-card products-variant">
            <span class="card-title">📦 STOCK</span>
            <span class="card-desc">Control de productos, marcas, precios y unidades disponibles.</span>
        </a>

        @if(session('auth_user.rol') === 'Administrador')
            <a href="{{ route('users.index') }}" class="menu-card users-variant">
                <span class="card-title">👥 USUARIOS</span>
                <span class="card-desc">Administración de credenciales, perfiles de acceso y roles de usuario.</span>
            </a>
        @endif
    </div>
</div>