<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #ffde00; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 700px; margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .field { display: flex; flex-direction: column; }
    .full-width { grid-column: span 2; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    input, textarea { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; }
    .btn-save { grid-column: span 2; background: #00ff00; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; margin-top: 10px; font-size: 1.4rem; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
</style>

<h1>NUEVO BOTÍN / GAMBASTORE</h1>


<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="field">
        <label>Nombre</label>
        <input type="text" name="nombre" placeholder="Ej: Predator" required>
    </div>
    <div class="field">
        <label>Marca</label>
        <input type="text" name="marca" placeholder="Ej: Adidas" required>
    </div>
    <div class="field">
        <label>Modelo</label>
        <input type="text" name="modelo" placeholder="Ej: 2026 Elite" required>
    </div>
    <div class="field">
        <label>Precio ($)</label>
        <input type="number" name="precio" required>
    </div>
    <div class="field">
        <label>Stock Inicial</label>
        <input type="number" name="stock" required>
    </div>
    <div class="field">
        <label>Talles (separados por coma)</label>
        <input type="text" name="talles" placeholder="Ej: 40, 41, 42">
    </div>
    <div class="field full-width">
        <label>Foto del Botín (Subir a la nube)</label>
        <input type="file" name="imagen" accept="image/*" required>
    </div>
    <div class="field full-width">
        <label>Descripción del producto</label>
        <textarea name="descripcion" rows="3"></textarea>
    </div>

    <button type="submit" class="btn-save">GUARDAR</button>
</form>