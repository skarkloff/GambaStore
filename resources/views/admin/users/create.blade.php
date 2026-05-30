@include('partials.topbar')

<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #ffde00; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; }
    form.main-form { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 700px; margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; background: #b8b8b8; }
    .field { display: flex; flex-direction: column; }
    .full-width { grid-column: span 2; }
    label { text-transform: uppercase; font-weight: 900; margin-bottom: 5px; }
    input, select { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; }
    .hint { font-size: 0.8rem; font-family: Arial, sans-serif; color: #444; margin-top: 5px; }
    .error-msg { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
    .btn-group { grid-column: span 2; display: flex; gap: 15px; margin-top: 10px; }
    .btn-save { flex: 1; background: #00ff00; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; }
    .btn-save:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
    .btn-cancel { flex: 1; background: #ff4545; color: white; padding: 15px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.4rem; font-family: 'Arial Black', sans-serif; text-decoration: none; display: flex; align-items: center; justify-content: center; }
    .btn-cancel:active { transform: translate(5px, 5px); box-shadow: 0px 0px 0px #000; }
</style>

<h1>NUEVO USUARIO / GAMBASTORE</h1>

<form action="{{ route('users.store') }}" method="POST" class="main-form">
    @csrf

    <div class="field">
        <label>Nombre Completo</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Usuario</label>
        <input type="text" name="usuario" value="{{ old('usuario') }}" required>
        @error('usuario') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Correo Electrónico</label>
        <input type="email" name="email" value="{{ old('email') }}" required>
        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field">
        <label>Contraseña</label>
        <input type="password" name="password" required>
        <span class="hint">Mínimo 8 caracteres, al menos una mayúscula y un número.</span>
        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="field full-width">
        <label>Rol de Acceso</label>
        <select name="rol" required>
            <option value="Cliente" selected>CLIENTE</option>
            <option value="Empleado">EMPLEADO</option>
            <option value="Administrador">ADMINISTRADOR</option>
        </select>
        @error('rol') <span class="error-msg">{{ $message }}</span> @enderror
    </div>

    <div class="btn-group">
        <button type="submit" class="btn-save">GUARDAR</button>
        <a href="{{ route('users.index') }}" class="btn-cancel">CANCELAR</a>
    </div>
</form>
