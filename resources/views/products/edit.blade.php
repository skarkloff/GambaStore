<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #ffde00; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 700px; margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .field { display: flex; flex-direction: column; }
    .full-width { grid-column: span 2; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    input, textarea { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; }
    .btn-save { grid-column: span 2; background: #00ffff; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; margin-top: 10px; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
</style>

<h1>EDITAR BOTÍN / {{ $product->nombre }}</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="field">
        <label>Nombre</label>
        <input type="text" name="nombre" value="{{ $product->nombre }}" required>
    </div>

    <div class="field">
        <label>Marca</label>
        <input type="text" name="marca" value="{{ $product->marca }}" required>
    </div>

    <div class="field">
        <label>Modelo</label>
        <input type="text" name="modelo" value="{{ $product->modelo }}" required>
    </div>

    <div class="field">
        <label>Precio</label>
        <input type="number" name="precio" value="{{ $product->precio }}" required>
    </div>

    <div class="field">
        <label>Stock</label>
        <input type="number" name="stock" value="{{ $product->stock }}" required>
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

    <button type="submit" class="btn-save">ACTUALIZAR DATOS</button>
</form>