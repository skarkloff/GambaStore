@include('partials.topbar')

<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #ffde00; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form.main-form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 700px; margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .field { display: flex; flex-direction: column; }
    .full-width { grid-column: span 2; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    .required-mark { color: #000; font-weight: 900; }
    .required-note { grid-column: span 2; font-size: 0.85rem; font-weight: bold; color: #333; margin-top: -5px; }
    input, textarea, select { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; background: white; }
    .btn-group { grid-column: span 2; display: flex; gap: 15px; margin-top: 10px; }
    .btn-save { flex: 1; background: #00ffff; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-family: 'Arial Black', sans-serif; font-size: 1.4rem; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-family: 'Arial Black', sans-serif; font-size: 1.4rem; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
</style>

<h1>EDITAR BOTÍN / {{ $product->nombre }}</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="main-form">
    @csrf
    @method('PUT')

    <div class="field">
        <label>Nombre <span class="required-mark">(*)</span></label>
        <input type="text" name="nombre" value="{{ $product->nombre }}" required>
    </div>

    <div class="field">
        <label>Marca <span class="required-mark">(*)</span></label>
        <select name="marca_id" required>
            <option value="" disabled>— Seleccioná una marca —</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ $product->marca_id === $marca->id ? 'selected' : '' }}>
                    {{ $marca->descripcion }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field">
        <label>Modelo <span class="required-mark">(*)</span></label>
        <input type="text" name="modelo" value="{{ $product->modelo }}" required>
    </div>

    <div class="field">
        <label>Precio <span class="required-mark">(*)</span></label>
        <input type="number" name="precio" value="{{ $product->precio }}" required>
    </div>

    <div class="field">
        <label>Stock <span class="required-mark">(*)</span></label>
        <input type="number" name="stock" value="{{ $product->stock }}" required>
    </div>

    <div class="field">
        <label>Tipo <span class="required-mark">(*)</span></label>
        <select name="tipo" required>
            <option value="" disabled>— Seleccioná un tipo —</option>
            @foreach(\App\Models\Product::TIPOS as $tipo)
                <option value="{{ $tipo }}" {{ $product->tipo === $tipo ? 'selected' : '' }}>
                    {{ $tipo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="field full-width">
        <label>Talles</label>
        <input type="text" 
            name="talles" 
            value="{{ is_array($product->talles) ? implode(', ', $product->talles) : $product->talles }}" 
            placeholder="Ej: 38, 39, 40">
    </div>

    <div class="field full-width">
        <label>Actualizar Foto del Botín (Opcional)</label>
        <input type="file" name="imagen" accept="image/*">
        
        @if($product->imagen_url)
            <p style="font-size: 0.8rem; margin-top: 5px;">Imagen actual:</p>
            <img src="{{ $product->imagen_url }}" alt="Vista previa" style="width: 100px; border: 2px solid #000; margin-top: 5px;">
        @endif
    </div>

    <div class="field full-width">
        <label>Descripción</label>
        <textarea name="descripcion" rows="3">{{ $product->descripcion }}</textarea>
    </div>

    <p class="required-note"><span class="required-mark">(*)</span> Campo obligatorio</p>

    <div class="btn-group">
        <button type="submit" class="btn-save">ACTUALIZAR DATOS</button>
        <a href="{{ route('products.index') }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>