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

    .container { max-width: 900px; margin: 0 auto; }

    h1 {
        font-size: 2.2rem;
        text-transform: uppercase;
        background-color: var(--accent);
        display: inline-block;
        padding: 10px 30px;
        border: 6px solid var(--border);
        box-shadow: 10px 10px 0px var(--border);
        margin-bottom: 30px;
    }

    .section {
        border: 5px solid #000;
        box-shadow: 8px 8px 0 #000;
        background: white;
        padding: 25px 30px;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1rem;
        text-transform: uppercase;
        font-weight: 900;
        border-bottom: 3px solid #000;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px 30px;
    }

    .info-item { display: flex; flex-direction: column; }
    .info-label { font-size: 0.75rem; text-transform: uppercase; color: #555; font-family: sans-serif; font-weight: bold; margin-bottom: 3px; }
    .info-value { font-size: 1rem; font-weight: 900; }

    table.items-table {
        width: 100%;
        border-collapse: collapse;
    }

    table.items-table th {
        background: #000;
        color: white;
        text-transform: uppercase;
        padding: 10px 15px;
        text-align: left;
        font-size: 0.85rem;
    }

    table.items-table td {
        padding: 12px 15px;
        border-bottom: 2px solid #000;
        font-weight: 900;
        font-size: 0.95rem;
    }

    .totals { text-align: right; margin-top: 15px; }
    .totals div { margin-bottom: 5px; font-family: sans-serif; font-weight: bold; }
    .totals .total-final { font-family: 'Arial Black', sans-serif; font-size: 1.4rem; font-weight: 900; border-top: 3px solid #000; padding-top: 8px; margin-top: 8px; }

    .badge {
        display: inline-block; padding: 6px 14px;
        border: 2px solid #000; font-size: 0.9rem;
        font-weight: 900; text-transform: uppercase;
    }

    .badge-pendiente  { background: #ffde00; }
    .badge-confirmado { background: #00ffff; }
    .badge-enviado    { background: #4499ff; color: white; }
    .badge-entregado  { background: #00ff7f; }
    .badge-cancelado  { background: #ff4545; color: white; }

    .btn {
        padding: 12px 24px;
        border: 4px solid #000;
        font-weight: 900;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        box-shadow: 4px 4px 0 #000;
        transition: all 0.1s;
        font-family: 'Arial Black', sans-serif;
        font-size: 1rem;
    }

    .btn:active { box-shadow: 0 0 0 #000; transform: translate(4px,4px); }

    .success-banner {
        background: #00ff00; border: 4px solid #000; padding: 12px 20px;
        font-weight: 900; text-transform: uppercase; box-shadow: 5px 5px 0 #000;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h1>PEDIDO / {{ substr($pedido->id, 0, 8) }}…</h1>

    @if(session('success'))
        <div class="success-banner">{{ session('success') }}</div>
    @endif

    <div style="display:flex; gap:15px; margin-bottom:30px;">
        <a href="{{ route('pedidos.index') }}" class="btn" style="background:#fff;">← VOLVER</a>
        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn" style="background:var(--accent);">GESTIONAR PEDIDO</a>
    </div>

    {{-- Info del cliente --}}
    <div class="section">
        <div class="section-title">Cliente</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Nombre</span>
                <span class="info-value">{{ $pedido->cliente_nombre }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value" style="font-family:sans-serif;">{{ $pedido->cliente_email }}</span>
            </div>
        </div>
    </div>

    {{-- Info del pedido --}}
    <div class="section">
        <div class="section-title">Datos del pedido</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Fecha</span>
                <span class="info-value" style="font-family:sans-serif;">
                    {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '—' }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Estado</span>
                <span class="badge badge-{{ $pedido->estado }}">{{ strtoupper($pedido->estado) }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Método de pago</span>
                <span class="info-value">{{ $metodos[$pedido->metodo_pago_id] ?? '—' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Cupón aplicado</span>
                <span class="info-value">{{ $pedido->promocion_codigo ?: '—' }}</span>
            </div>
            @if($pedido->numero_tracking)
            <div class="info-item">
                <span class="info-label">Número de tracking</span>
                <span class="info-value" style="font-family:monospace;">{{ $pedido->numero_tracking }}</span>
            </div>
            @endif
            @if($pedido->notas)
            <div class="info-item" style="grid-column:span 2;">
                <span class="info-label">Notas del cliente</span>
                <span class="info-value" style="font-family:sans-serif; font-weight:bold;">{{ $pedido->notas }}</span>
            </div>
            @endif
        </div>
    </div>

    {{-- Dirección --}}
    @if(!empty($pedido->direccion))
    <div class="section">
        <div class="section-title">Dirección de envío</div>
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Calle y número</span>
                <span class="info-value" style="font-family:sans-serif;">
                    {{ ($pedido->direccion['calle'] ?? '') }} {{ ($pedido->direccion['numero'] ?? '') }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Ciudad</span>
                <span class="info-value" style="font-family:sans-serif;">{{ $pedido->direccion['ciudad'] ?? '—' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Provincia</span>
                <span class="info-value" style="font-family:sans-serif;">{{ $pedido->direccion['provincia'] ?? '—' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Código postal</span>
                <span class="info-value" style="font-family:sans-serif;">{{ $pedido->direccion['cp'] ?? '—' }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Ítems --}}
    <div class="section">
        <div class="section-title">Productos</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Talle</th>
                    <th>Cantidad</th>
                    <th>Precio unit.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->items as $item)
                <tr>
                    <td>
                        {{ $item['nombre'] ?? '—' }}
                        <span style="font-family:sans-serif; font-weight:bold; color:#555; font-size:0.85rem;">
                            — {{ $item['marca'] ?? '' }} {{ $item['modelo'] ?? '' }}
                        </span>
                    </td>
                    <td>{{ $item['talle'] ?? '—' }}</td>
                    <td>{{ $item['cantidad'] ?? 0 }}</td>
                    <td>${{ number_format($item['precio_unitario'] ?? 0, 2, ',', '.') }}</td>
                    <td>${{ number_format(($item['precio_unitario'] ?? 0) * ($item['cantidad'] ?? 0), 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div>SUBTOTAL: ${{ number_format($pedido->subtotal, 2, ',', '.') }}</div>
            @if($pedido->descuento > 0)
            <div style="color:#cc0000;">DESCUENTO: -${{ number_format($pedido->descuento, 2, ',', '.') }}</div>
            @endif
            <div class="total-final">TOTAL: ${{ number_format($pedido->total, 2, ',', '.') }}</div>
        </div>
    </div>
</div>
