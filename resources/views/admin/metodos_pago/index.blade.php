@include('partials.topbar')

<style>
    :root {
        --bg: #b8b8b8;
        --accent: #ff00ff;
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

    .badge { display: inline-block; padding: 4px 10px; border: 2px solid #000; font-size: 0.85rem; font-weight: 900; text-transform: uppercase; }
    .badge-on  { background: #00ff7f; }
    .badge-off { background: #ff4545; color: white; }
</style>

<div class="container">
    <h1>MÉTODOS DE PAGO / GAMBASTORE</h1>
    <span class="subtitle">Gestión de métodos de pago disponibles.</span>

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 30px; display: flex; gap: 15px;">
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background: #fff; font-size: 1.1rem;">← VOLVER AL PANEL</a>
        <a href="{{ route('metodos_pago.create') }}" class="btn" style="background: var(--accent); font-size: 1.1rem; color: #000;">AGREGAR MÉTODO +</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($metodos as $metodo)
            <tr>
                <td>{{ $metodo->descripcion }}</td>
                <td>
                    <span class="badge {{ $metodo->activo ? 'badge-on' : 'badge-off' }}">
                        {{ $metodo->activo ? 'ACTIVO' : 'INACTIVO' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('metodos_pago.edit', $metodo->id) }}" class="btn btn-edit">EDITAR</a>
                    <form action="{{ route('metodos_pago.destroy', $metodo->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"
                            onclick="return confirm('¿Eliminar el método «{{ $metodo->descripcion }}»?')">
                            ELIMINAR
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center; font-family: sans-serif; color:#555; padding: 40px;">
                    No hay métodos de pago cargados todavía.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
