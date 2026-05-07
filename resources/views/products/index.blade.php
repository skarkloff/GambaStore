<style>
    :root {
        --bg: #ffffff;
        --accent: #ffde00; /* Amarillo potente */
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

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

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

    .subtitle {
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 40px;
        display: block;
    }

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
        padding: 20px;
        border: 3px solid var(--border);
        font-weight: 900;
        font-size: 1.1rem;
    }

    tr:hover {
        background-color: #f0f0f0;
    }

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
        font-size: 0.9rem;
    }

    .btn:active {
        box-shadow: 0px 0px 0px var(--border);
        transform: translate(4px, 4px);
    }

    .btn-edit { background: #00ff00; margin-right: 10px; color: black; }
    .btn-delete { background: #ff4545; color: white; }

    .img-container {
        width: 80px;
        height: 80px;
        border: 3px solid var(--border);
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container">
    <h1>PANEL DE CONTROL / GAMBASTORE</h1>
    <span class="subtitle">Gestión de stock para personal autorizado.</span>
    <div style="margin-bottom: 30px;">
    <a href="{{ route('products.create') }}" class="btn" style="background-color: #00ffff; font-size: 1.2rem;">
        AGREGAR NUEVO PRODUCTO +
    </a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Botín</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    <div class="img-container">
                        <img src="{{ $product->imagen_url }}" width="100%" alt="FOTO">
                    </div>
                </td>
                <td>{{ $product->nombre }}</td>
                <td>{{ $product->marca }}</td>
                <td>${{ number_format($product->precio, 0, ',', '.') }}</td>
                <td>{{ $product->stock }} UNIDADES</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit">EDITAR</a>
                    <form action = "{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?')">ELIMINAR</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>