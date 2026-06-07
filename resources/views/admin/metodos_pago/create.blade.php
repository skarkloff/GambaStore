@include('partials.topbar')

<style>
    :root {
        --bg: #b8b8b8;
        --accent: #ff00ff;
        --text: #000000;
        --border: #000000;
    }

    body { background: var(--bg); font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: var(--accent); display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form.main-form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 500px; margin-top: 20px; display: flex; flex-direction: column; gap: 20px; background: var(--bg); }
    .field { display: flex; flex-direction: column; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    .required-mark { color: #000; font-weight: 900; }
    .required-note { font-size: 0.85rem; font-weight: bold; color: #333; font-family: Arial, sans-serif; }
    input[type=text] { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; background: white; }
    .error-msg { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
    .checkbox-row { display: flex; align-items: center; gap: 12px; }
    .checkbox-row input[type=checkbox] { width: 22px; height: 22px; cursor: pointer; accent-color: var(--accent); border: 3px solid #000; }
    .checkbox-row label { margin-bottom: 0; cursor: pointer; }
    .btn-group { display: flex; gap: 15px; margin-top: 10px; }
    .btn-save { flex: 1; background: #00ff00; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
</style>

<h1>NUEVO MÉTODO DE PAGO / GAMBASTORE</h1>

<form action="{{ route('metodos_pago.store') }}" method="POST" class="main-form">
    @csrf

    <div class="field">
        <label>Descripción <span class="required-mark">(*)</span></label>
        <input type="text" name="descripcion" value="{{ old('descripcion') }}" placeholder="Ej: MercadoPago" required>
        @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Estado</label>
        <div class="checkbox-row">
            <input type="checkbox" name="activo" id="activo" {{ old('activo', '1') ? 'checked' : '' }}>
            <label for="activo">Activo</label>
        </div>
    </div>

    <p class="required-note"><span class="required-mark">(*)</span> Campo obligatorio</p>

    <div class="btn-group">
        <button type="submit" class="btn-save">GUARDAR</button>
        <a href="{{ route('metodos_pago.index') }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>
