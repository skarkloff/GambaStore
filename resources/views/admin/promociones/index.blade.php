@include('partials.topbar')

<style>
    :root {
        --bg: #b8b8b8;
        --accent: #00ff7f;
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

    .container { max-width: 1300px; margin: 0 auto; }

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

    .subtitle {
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 40px;
        display: block;
    }

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
        padding: 16px 20px;
        border: 3px solid var(--border);
        font-weight: 900;
        font-size: 1rem;
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
    .btn-edit   { background: #00ff00; color: black; margin-right: 8px; }
    .btn-delete { background: #ff4545; color: white; }

    .success-banner {
        background: #00ff00; border: 4px solid #000; padding: 12px 20px;
        font-weight: 900; text-transform: uppercase; box-shadow: 5px 5px 0 #000;
        margin-bottom: 20px;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border: 2px solid #000;
        font-size: 0.8rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .badge-on  { background: #00ff7f; }
    .badge-off { background: #ff4545; color: white; }
    .badge-vigente { background: #00ff7f; }
    .badge-vencida { background: #aaa; }
    .badge-futura  { background: #ffde00; }
</style>

<div class="container">
    <h1>PROMOCIONES / GAMBASTORE</h1>
    <span class="subtitle">Gestión de descuentos y promociones.</span>

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 30px; display: flex; gap: 15px;">
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background:#fff;">← VOLVER AL PANEL</a>
        <a href="{{ route('promociones.create') }}" class="btn" style="background:var(--accent);">NUEVA PROMOCIÓN +</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Código</th>
                <th>Vigencia</th>
                <th>Aplica a</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($promociones as $p)
            @php
                $hoy = now()->toDateString();
                if (!$p->activa) {
                    $estadoClass = 'badge-off';
                    $estadoLabel = 'INACTIVA';
                } elseif ($p->fecha_fin < $hoy) {
                    $estadoClass = 'badge-vencida';
                    $estadoLabel = 'VENCIDA';
                } elseif ($p->fecha_inicio > $hoy) {
                    $estadoClass = 'badge-futura';
                    $estadoLabel = 'FUTURA';
                } else {
                    $estadoClass = 'badge-vigente';
                    $estadoLabel = 'VIGENTE';
                }

                $aplicaLabel = match($p->aplica_a) {
                    'todo'     => 'Todo el sitio',
                    'marca'    => 'Marca: ' . ($marcas[$p->marca_id] ?? $p->marca_id),
                    'tipo'     => 'Tipo: ' . $p->tipo_producto,
                    'producto' => 'Producto específico',
                    default    => $p->aplica_a,
                };
            @endphp
            <tr>
                <td>{{ $p->nombre }}</td>
                <td>{{ $p->tipo === 'porcentaje' ? 'PORCENTAJE' : 'MONTO FIJO' }}</td>
                <td>{{ $p->tipo === 'porcentaje' ? $p->valor . '%' : '$' . number_format($p->valor, 2, ',', '.') }}</td>
                <td>{{ $p->codigo ?: '—' }}</td>
                <td style="font-size:0.9rem; font-family: sans-serif;">
                    {{ \Carbon\Carbon::parse($p->fecha_inicio)->format('d/m/Y') }}
                    →
                    {{ \Carbon\Carbon::parse($p->fecha_fin)->format('d/m/Y') }}
                </td>
                <td style="font-size:0.9rem; font-family: sans-serif; font-weight: bold;">{{ $aplicaLabel }}</td>
                <td><span class="badge {{ $estadoClass }}">{{ $estadoLabel }}</span></td>
                <td>
                    <a href="{{ route('promociones.edit', $p->id) }}" class="btn btn-edit">EDITAR</a>
                    <form action="{{ route('promociones.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"
                            onclick="return confirm('¿Eliminar la promoción «{{ $p->nombre }}»?')">
                            ELIMINAR
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; font-family: sans-serif; color:#555; padding: 40px;">
                    No hay promociones creadas todavía.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
