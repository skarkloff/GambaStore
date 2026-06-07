@include('partials.topbar')

<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #00ff7f; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form.main-form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 700px; margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: var(--bg); }
    .field { display: flex; flex-direction: column; }
    .error-msg { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
    .full-width { grid-column: span 2; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    .required-mark { color: #000; font-weight: 900; }
    .required-note { grid-column: span 2; font-size: 0.85rem; font-weight: bold; color: #333; margin-top: -5px; font-family: Arial, sans-serif; }
    input, textarea, select { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; background: white; }
    .btn-group { grid-column: span 2; display: flex; gap: 15px; margin-top: 10px; }
    .btn-save   { flex: 1; background: #00ff7f; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; }
    .btn-save:active   { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .section-divider { grid-column: span 2; border-top: 3px solid #000; padding-top: 10px; margin-top: 5px; }
    .section-divider span { font-size: 0.85rem; text-transform: uppercase; font-weight: 900; color: #555; }
    .checkbox-row { display: flex; align-items: center; gap: 12px; }
    .checkbox-row input[type=checkbox] { width: 22px; height: 22px; border: 3px solid #000; cursor: pointer; accent-color: #00ff7f; }
    .hidden { display: none; }
</style>

<h1>NUEVA PROMOCIÓN / GAMBASTORE</h1>

<form action="{{ route('promociones.store') }}" method="POST" class="main-form">
    @csrf

    {{-- NOMBRE --}}
    <div class="field full-width">
        <label>Nombre <span class="required-mark">(*)</span></label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Descuento verano 2026" required>
        @error('nombre') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    {{-- TIPO + VALOR --}}
    <div class="field">
        <label>Tipo de descuento <span class="required-mark">(*)</span></label>
        <select name="tipo" required>
            <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>— Seleccioná —</option>
            <option value="porcentaje"  {{ old('tipo') === 'porcentaje'  ? 'selected' : '' }}>Porcentaje (%)</option>
            <option value="monto_fijo"  {{ old('tipo') === 'monto_fijo'  ? 'selected' : '' }}>Monto fijo ($)</option>
        </select>
        @error('tipo') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Valor <span class="required-mark">(*)</span></label>
        <input type="text" inputmode="decimal" name="valor" value="{{ old('valor') }}" placeholder="Ej: 20 (para 20%) o 1500">
        @error('valor') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    {{-- FECHAS --}}
    <div class="field">
        <label>Fecha inicio <span class="required-mark">(*)</span></label>
        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
        @error('fecha_inicio') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Fecha fin <span class="required-mark">(*)</span></label>
        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
        @error('fecha_fin') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    {{-- CÓDIGO + MÍNIMO --}}
    <div class="field">
        <label>Código de cupón (opcional)</label>
        <input type="text" name="codigo" value="{{ old('codigo') }}" placeholder="Ej: VERANO25" style="text-transform:uppercase;">
        @error('codigo') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Compra mínima ($)</label>
        <input type="text" inputmode="decimal" name="minimo_compra" value="{{ old('minimo_compra') }}" placeholder="Ej: 5000 (dejar vacío = sin mínimo)">
        @error('minimo_compra') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    {{-- ACTIVA --}}
    <div class="field" style="justify-content: flex-end; padding-bottom: 4px;">
        <label>Activa</label>
        <div class="checkbox-row">
            <input type="checkbox" name="activa" id="activa" {{ old('activa', '1') ? 'checked' : '' }}>
            <label for="activa" style="margin-bottom:0; cursor:pointer;">Habilitada</label>
        </div>
    </div>

    {{-- APLICA A --}}
    <div class="section-divider"><span>Alcance del descuento</span></div>

    <div class="field full-width">
        <label>Aplica a <span class="required-mark">(*)</span></label>
        <select name="aplica_a" id="aplica_a" required onchange="toggleAplicaA(this.value)">
            <option value="todo"     {{ old('aplica_a', 'todo') === 'todo'     ? 'selected' : '' }}>Todo el catálogo</option>
            <option value="marca"    {{ old('aplica_a') === 'marca'    ? 'selected' : '' }}>Una marca específica</option>
            <option value="tipo"     {{ old('aplica_a') === 'tipo'     ? 'selected' : '' }}>Un tipo de botín</option>
            <option value="producto" {{ old('aplica_a') === 'producto' ? 'selected' : '' }}>Un producto específico</option>
        </select>
        @error('aplica_a') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field full-width hidden" id="field-marca">
        <label>Marca <span class="required-mark">(*)</span></label>
        <select name="marca_id">
            <option value="" disabled selected>— Seleccioná una marca —</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ old('marca_id') === $marca->id ? 'selected' : '' }}>
                    {{ $marca->descripcion }}
                </option>
            @endforeach
        </select>
        @error('marca_id') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field full-width hidden" id="field-tipo">
        <label>Tipo de botín <span class="required-mark">(*)</span></label>
        <select name="tipo_producto">
            <option value="" disabled selected>— Seleccioná un tipo —</option>
            @foreach(\App\Models\Product::TIPOS as $tipo)
                <option value="{{ $tipo }}" {{ old('tipo_producto') === $tipo ? 'selected' : '' }}>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>
        @error('tipo_producto') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field full-width hidden" id="field-producto">
        <label>Producto <span class="required-mark">(*)</span></label>
        <select name="producto_id">
            <option value="" disabled selected>— Seleccioná un producto —</option>
            @foreach($productos as $producto)
                <option value="{{ $producto->id }}" {{ old('producto_id') === $producto->id ? 'selected' : '' }}>
                    {{ $producto->nombre }} — {{ $producto->modelo }}
                </option>
            @endforeach
        </select>
        @error('producto_id') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <p class="required-note"><span class="required-mark">(*)</span> Campo obligatorio</p>

    <div class="btn-group">
        <button type="submit" class="btn-save">GUARDAR</button>
        <a href="{{ route('promociones.index') }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>

<script>
function toggleAplicaA(val) {
    document.getElementById('field-marca').classList.toggle('hidden', val !== 'marca');
    document.getElementById('field-tipo').classList.toggle('hidden', val !== 'tipo');
    document.getElementById('field-producto').classList.toggle('hidden', val !== 'producto');
}

// Aplicar al cargar si hay old() de una validación fallida
toggleAplicaA(document.getElementById('aplica_a').value);
</script>
