<style>
    :root {
        --bg: #b8b8b8;
        --accent: #00ffff; /* Celeste potente para diferenciar secciones */
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

    .btn-edit { background: #ffde00; margin-right: 10px; color: black; }
    .btn-delete { background: #ff4545; color: white; }
</style>

<div class="container">
    <h1>PANEL DE CONTROL / USUARIOS</h1>
    <span class="subtitle">Gestión de credenciales para personal autorizado.</span>
    
    <div style="margin-bottom: 30px; display: flex; gap: 15px;">
        <a href="{{ route('admin.dashboard') }}" class="btn" style="background-color: #ffffff; font-size: 1.2rem; color: #000000;">
            ← VOLVER AL MENÚ
        </a>
        <a href="{{ route('users.create') }}" class="btn" style="background-color: #00ff00; font-size: 1.2rem; color: #000000;">
            AGREGAR NUEVO USUARIO +
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Firestore</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><code style="font-family: monospace;">{{ $user->id }}</code></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ strtoupper($user->rol) }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit">EDITAR</a>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">ELIMINAR</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>