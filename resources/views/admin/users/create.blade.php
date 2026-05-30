<style>
    :root {
        --bg: #b8b8b8;
        --accent: #00ff00; /* Verde neo-brutalista para altas */
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

    .form-box {
        background: white;
        border: 6px solid var(--border);
        box-shadow: 15px 15px 0px var(--border);
        padding: 40px;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 25px;
    }

    label {
        display: block;
        text-transform: uppercase;
        margin-bottom: 10px;
        font-size: 1.1rem;
        font-weight: 900;
    }

    input, select {
        width: 100%;
        padding: 12px;
        border: 4px solid var(--border);
        font-family: 'Arial Black', sans-serif;
        font-size: 1rem;
        box-sizing: border-box;
    }

    input:focus, select:focus {
        outline: none;
        background-color: #f0f0f0;
    }

    .error-msg {
        color: #cc0000;
        font-size: 0.85rem;
        margin-top: 6px;
        display: block;
        font-family: Arial, sans-serif;
        font-weight: bold;
    }

    .btn {
        padding: 12px 25px;
        border: 4px solid var(--border);
        font-weight: 900;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        box-shadow: 4px 4px 0px var(--border);
        transition: all 0.1s;
    }

    .btn:active {
        box-shadow: 0px 0px 0px var(--border);
        transform: translate(4px, 4px);
    }
</style>

<div class="form-box">
    <h2 style="font-size: 2rem; margin-top: 0; text-transform: uppercase;">Nuevo Usuario</h2>
    <hr style="border: 3px solid var(--border); margin-bottom: 30px;">

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Usuario</label>
            <input type="text" name="usuario" value="{{ old('usuario') }}" required>
            @error('usuario') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
            <span style="font-size:0.8rem; font-family:Arial,sans-serif; color:#444; display:block; margin-top:5px;">
                Mínimo 8 caracteres, al menos una mayúscula y un número.
            </span>
            @error('password') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Rol de Acceso</label>
            <select name="rol" required>
                <option value="Cliente" selected>CLIENTE</option>
                <option value="Empleado">EMPLEADO</option>
                <option value="Administrador">ADMINISTRADOR</option>
            </select>
            @error('rol') <span class="error-msg">{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 40px;">
            <button type="submit" class="btn" style="background: var(--accent); margin-right: 15px;">GUARDAR +</button>
            <a href="{{ route('users.index') }}" class="btn" style="background: #ffffff; color: #000;">VOLVER</a>
        </div>
    </form>
</div>