@include('partials.topbar')

<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #ff8c00; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form.main-form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 500px; margin-top: 20px; display: flex; flex-direction: column; gap: 20px; }
    .field { display: flex; flex-direction: column; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    .required-mark { color: #000; font-weight: 900; }
    .required-note { font-size: 0.85rem; font-weight: bold; color: #333; }
    input { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; }
    .error-msg { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
    .btn-group { display: flex; gap: 15px; margin-top: 10px; }
    .btn-save { flex: 1; background: #00ffff; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
</style>

<h1>EDITAR MARCA / {{ $marca->descripcion }}</h1>

<form action="{{ route('marcas.update', $marca->id) }}" method="POST" class="main-form">
    @csrf
    @method('PUT')

    <div class="field">
        <label>Descripción <span class="required-mark">(*)</span></label>
        <input type="text" name="descripcion" value="{{ old('descripcion', $marca->descripcion) }}" required>
        @error('descripcion') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <p class="required-note"><span class="required-mark">(*)</span> Campo obligatorio</p>

    <div class="btn-group">
        <button type="submit" class="btn-save">ACTUALIZAR DATOS</button>
        <a href="{{ route('marcas.index') }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>
