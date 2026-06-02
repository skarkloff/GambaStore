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
    .btn-save { flex: 1; background: #00ff00; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .talles-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    .talles-table th { background: #000; color: #fff; padding: 8px 12px; text-align: left; font-size: 0.85rem; }
    .talles-table td { padding: 6px 6px; border-bottom: 2px solid #000; }
    .talles-table input { width: 100%; padding: 8px; border: 2px solid #000; font-weight: bold; font-size: 0.95rem; box-sizing: border-box; }
    .btn-remove-row { background: #ff4545; color: white; border: 2px solid #000; padding: 6px 10px; font-weight: 900; cursor: pointer; font-family: 'Arial Black', sans-serif; }
    .btn-add-row { margin-top: 10px; background: #ffde00; border: 3px solid #000; padding: 10px 20px; font-weight: 900; cursor: pointer; font-family: 'Arial Black', sans-serif; text-transform: uppercase; box-shadow: 4px 4px 0 #000; }
</style>

<h1>NUEVO BOTÍN / GAMBASTORE</h1>


<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="main-form">
    @csrf
    <div class="field">
        <label>Nombre <span class="required-mark">(*)</span></label>
        <input type="text" name="nombre" placeholder="Ej: Predator" required>
    </div>
    <div class="field">
        <label>Marca <span class="required-mark">(*)</span></label>
        <select name="marca_id" required>
            <option value="" disabled selected>— Seleccioná una marca —</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}">{{ $marca->descripcion }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Modelo <span class="required-mark">(*)</span></label>
        <input type="text" name="modelo" placeholder="Ej: 2026 Elite" required>
    </div>
    <div class="field">
        <label>Precio ($) <span class="required-mark">(*)</span></label>
        <input type="number" name="precio" min="0" required>
    </div>
    <div class="field">
        <label>Tipo <span class="required-mark">(*)</span></label>
        <select name="tipo" required>
            <option value="" disabled selected>— Seleccioná un tipo —</option>
            @foreach(\App\Models\Product::TIPOS as $tipo)
                <option value="{{ $tipo }}">{{ $tipo }}</option>
            @endforeach
        </select>
    </div>
    <div class="field full-width">
        <label>Foto del Botín (Subir a la nube) <span class="required-mark">(*)</span></label>
        <input type="file" name="imagen" accept="image/*" required>
    </div>
    <div class="field full-width">
        <label>Descripción del producto</label>
        <textarea name="descripcion" rows="3"></textarea>
    </div>
    <div class="field full-width">
        <label>Talles y Stock</label>
        <table class="talles-table">
            <thead>
                <tr>
                    <th>TALLE</th>
                    <th>STOCK</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="talles-body">
                <tr>
                    <td><input type="text" name="talles[0][talle]" placeholder="Ej: 40"></td>
                    <td><input type="number" name="talles[0][stock]" value="1" min="1"></td>
                    <td><button type="button" class="btn-remove-row" onclick="removeRow(this)">✕</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn-add-row" onclick="addRow()">+ AGREGAR TALLE</button>
    </div>

    <p class="required-note"><span class="required-mark">(*)</span> Campo obligatorio</p>

    <div class="btn-group">
        <button type="submit" class="btn-save">GUARDAR</button>
        <a href="{{ route('products.index') }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>

<script>
let talleIndex = 1;

function addRow() {
    const tbody = document.getElementById('talles-body');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="talles[${talleIndex}][talle]" placeholder="Ej: 40"></td>
        <td><input type="number" name="talles[${talleIndex}][stock]" value="1" min="1"></td>
        <td><button type="button" class="btn-remove-row" onclick="removeRow(this)">✕</button></td>
    `;
    tbody.appendChild(tr);
    talleIndex++;
}

function removeRow(btn) {
    const tbody = document.getElementById('talles-body');
    if (tbody.rows.length > 1) {
        btn.closest('tr').remove();
    }
}
</script>