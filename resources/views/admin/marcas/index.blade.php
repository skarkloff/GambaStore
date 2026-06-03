@include('partials.topbar')

<style>
    :root {
        --bg: #b8b8b8;
        --accent: #ff8c00;
        --text: #000000;
        --border: #000000;
    }

    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Arial Black', Gadget, sans-serif;
        padding: 40px;
        line-height: 1.2;
    }

    .container { max-width: 800px; margin: 0 auto; }

    h1 {
        font-size: 3rem;
        text-transform: uppercase;
        background-color: var(--accent);
        display: inline-block;
        padding: 10px 30px;
        border: 6px solid var(--border);
        box-shadow: 10px 10px 0px var(--border);
        margin-bottom: 10px;
    }

    .subtitle { font-weight: bold; text-transform: uppercase; margin-bottom: 40px; display: block; }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 6px solid var(--border);
        box-shadow: 15px 15px 0px var(--border);
        background: white;
    }

    th {
        background-color: var(--text);
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
    .btn-edit   { background: #00ff00; margin-right: 10px; color: black; }
    .btn-delete { background: #ff4545; color: white; }

    .success-banner {
        background: #00ff00; border: 4px solid #000; padding: 12px 20px;
        font-weight: 900; text-transform: uppercase; box-shadow: 5px 5px 0 #000;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h1>MARCAS / GAMBASTORE</h1>
    <span class="subtitle">Gestión del catálogo de marcas.</span>

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 30px; display: flex; gap: 15px;">
        <a href="{{ route('products.index') }}" class="btn" style="background: #fff; font-size: 1.1rem;">
            ← VOLVER A STOCK
        </a>
        <a href="{{ route('marcas.create') }}" class="btn" style="background: #ff8c00; font-size: 1.1rem; color: #000;">
            AGREGAR NUEVA MARCA +
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($marcas as $marca)
            <tr>
                <td>{{ $marca->descripcion }}</td>
                <td>
                    <a href="{{ route('marcas.edit', $marca->id) }}" class="btn btn-edit">EDITAR</a>
                    <form action="{{ route('marcas.destroy', $marca->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"
                            onclick="return confirm('¿Eliminar la marca {{ $marca->descripcion }}?')">
                            ELIMINAR
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align:center; color:#555;">No hay marcas cargadas todavía.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
