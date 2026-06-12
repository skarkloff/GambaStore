@include('partials.topbar')

<style>
    :root {
        --bg: #b8b8b8;
        --accent: #adff2f;
        --text: #000000;
        --border: #000000;
    }

    body { background: var(--bg); font-family: 'Arial Black', sans-serif; padding: 40px; }

    h1 { background: var(--accent); display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }

    .resumen {
        border: 4px solid #000;
        background: white;
        padding: 20px 25px;
        max-width: 500px;
        margin: 20px 0;
        box-shadow: 6px 6px 0 #000;
        font-family: sans-serif;
        font-weight: bold;
        font-size: 0.95rem;
    }

    .resumen span { display: block; margin-bottom: 6px; }
    .resumen strong { font-family: 'Arial Black', sans-serif; }

    form.main-form {
        border: 5px solid #000;
        padding: 30px;
        box-shadow: 15px 15px 0px #000;
        max-width: 500px;
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        background: var(--bg);
    }

    .field { display: flex; flex-direction: column; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    .required-mark { font-weight: 900; }
    select, input[type=text] { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; background: white; }
    .error-msg { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
    .hint { font-size: 0.8rem; font-family: Arial, sans-serif; color: #444; margin-top: 5px; }
    .hidden { display: none; }

    .btn-group { display: flex; gap: 15px; margin-top: 10px; }
    .btn-save { flex: 1; background: #00ffff; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; }
    .btn-save:active { transform: translate(5px,5px); box-shadow: 0 0 0 #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px,5px); box-shadow: 0 0 0 #000; }
</style>

<h1>GESTIONAR PEDIDO / {{ substr($pedido->id, 0, 8) }}…</h1>

<div class="resumen">
    <span><strong>Cliente:</strong> {{ $pedido->cliente_nombre }} ({{ $pedido->cliente_email }})</span>
    <span><strong>Fecha:</strong> {{ $pedido->fecha ? \Carbon\Carbon::parse($pedido->fecha)->format('d/m/Y H:i') : '—' }}</span>
    <span><strong>Total:</strong> ${{ number_format($pedido->total, 2, ',', '.') }}</span>
    <span><strong>Ítems:</strong> {{ count($pedido->items) }} producto(s)</span>
</div>

<form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" class="main-form">
    @csrf
    @method('PUT')

    <div class="field">
        <label>Estado <span class="required-mark">(*)</span></label>
        <select name="estado" id="estado" required onchange="toggleTracking(this.value)">
            @foreach(\App\Models\Pedido::ESTADOS as $e)
                <option value="{{ $e }}" {{ old('estado', $pedido->estado) === $e ? 'selected' : '' }}>
                    {{ strtoupper($e) }}
                </option>
            @endforeach
        </select>
        @error('estado') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field" id="field-tracking">
        <label>Número de tracking</label>
        <input type="text" name="numero_tracking"
               value="{{ old('numero_tracking', $pedido->numero_tracking) }}"
               placeholder="Ej: OCA-123456789">
        <span class="hint">Completar al marcar como ENVIADO.</span>
        @error('numero_tracking') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="btn-group">
        <button type="submit" class="btn-save">ACTUALIZAR DATOS</button>
        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>

<script>
function toggleTracking(estado) {
    const field = document.getElementById('field-tracking');
    field.classList.toggle('hidden', estado !== 'enviado' && estado !== 'entregado');
}

toggleTracking(document.getElementById('estado').value);
</script>
