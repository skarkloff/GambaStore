@include('partials.topbar')

<style>
    :root {
        --bg: #b8b8b8;
        --accent: #adff2f;
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

    .subtitle { font-weight: bold; text-transform: uppercase; margin-bottom: 30px; display: block; }

    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-btn {
        padding: 8px 18px;
        border: 3px solid #000;
        font-weight: 900;
        font-size: 0.85rem;
        text-transform: uppercase;
        text-decoration: none;
        font-family: 'Arial Black', sans-serif;
        box-shadow: 3px 3px 0 #000;
        transition: all 0.1s;
        display: inline-block;
    }

    .filter-btn:active { box-shadow: 0 0 0 #000; transform: translate(3px,3px); }
    .filter-btn.active { box-shadow: 0 0 0 #000; transform: translate(3px,3px); }

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
        font-size: 0.85rem;
        font-family: 'Arial Black', sans-serif;
    }

    .btn:active { box-shadow: 0 0 0 var(--border); transform: translate(4px,4px); }
    .btn-view   { background: #00ff00; color: black; margin-right: 8px; }
    .btn-delete { background: #ff4545; color: white; }

    .success-banner {
        background: #00ff00; border: 4px solid #000; padding: 12px 20px;
        font-weight: 900; text-transform: uppercase; box-shadow: 5px 5px 0 #000;
        margin-bottom: 20px;
    }

    .badge {
        display: inline-block; padding: 5px 12px;
        border: 2px solid #000; font-size: 0.8rem;
        font-weight: 900; text-transform: uppercase;
    }

    .badge-pendiente  { background: #ffde00; }
    .badge-confirmado { background: #00ffff; }
    .badge-enviado    { background: #4499ff; color: white; }
    .badge-entregado  { background: #00ff7f; }
    .badge-cancelado  { background: #ff4545; color: white; }
</style>

<div class="container">
    <h1>PEDIDOS / GAMBASTORE</h1>
    <span class="subtitle">Gestión y seguimiento de pedidos.</span>

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background:#fff; font-size:1.1rem;">← VOLVER AL PANEL</a>
    </div>

    {{-- Filtro por estado --}}
    <div class="filter-bar">
        <span style="font-size:0.9rem;">FILTRAR:</span>
        <a href="{{ route('pedidos.index') }}"
           class="filter-btn {{ !$estado ? 'active' : '' }}"
           style="background: #fff;">TODOS</a>
        @foreach(\App\Models\Pedido::ESTADOS as $e)
            <a href="{{ route('pedidos.index', ['estado' => $e]) }}"
               class="filter-btn {{ $estado === $e ? 'active' : '' }} badge-{{ $e }}">
               {{ strtoupper($e) }}
            </a>
        @endforeach
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Método de pago</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pedidos as $pedido)
            <tr>
                <td style="font-size:0.8rem; font-family:monospace; font-weight:900;">{{ substr($pedido->id, 0, 8) }}…</td>
                <td>
                    {{ $pedido->cliente_nombre }}<br>
                    <span style="font-family:sans-serif; font-size:0.85rem; font-weight:bold; color:#555;">{{ $pedido->cliente_email }}</span>
                </td>
                <td style="font-family:sans-serif; font-size:0.9rem;">
                    {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '—' }}
                </td>
                <td style="font-family:sans-serif;">{{ $metodos[$pedido->metodo_pago_id] ?? '—' }}</td>
                <td>${{ number_format($pedido->total, 2, ',', '.') }}</td>
                <td><span class="badge badge-{{ $pedido->estado }}">{{ strtoupper($pedido->estado) }}</span></td>
                <td>
                    <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-view">VER</a>
                    <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete"
                            onclick="return confirm('¿Eliminar este pedido?')">ELIMINAR</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; font-family:sans-serif; color:#555; padding:40px;">
                    No hay pedidos{{ $estado ? ' con estado "' . $estado . '"' : '' }}.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
