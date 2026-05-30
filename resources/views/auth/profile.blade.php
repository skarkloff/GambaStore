<style>
    body { background: #b8b8b8; font-family: 'Arial Black', sans-serif; padding: 40px; }
    h1 { background: #ffde00; display: inline-block; padding: 10px 20px; border: 5px solid #000; box-shadow: 8px 8px 0px #000; text-transform: uppercase; margin-bottom: 25px; }
    .profile-card { border: 5px solid #000; padding: 30px; box-shadow: 15px 15px 0px #000; max-width: 500px; background: #b8b8b8; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .field { display: flex; flex-direction: column; }
    .full-width { grid-column: span 2; }
    label { text-transform: uppercase; font-weight: 900; font-size: 0.8rem; margin-bottom: 5px; color: #444; }
    .value { padding: 10px; border: 3px solid #000; background: white; font-family: sans-serif; font-weight: bold; font-size: 1rem; }
    .rol-badge { display: inline-block; padding: 8px 16px; border: 3px solid #000; font-weight: 900; font-size: 0.9rem; text-transform: uppercase; }
    .rol-admin { background: #00ffff; }
    .rol-empleado { background: #ffde00; }
    .btn-back { display: inline-block; margin-top: 30px; padding: 12px 25px; background: #fff; border: 4px solid #000; font-weight: 900; text-transform: uppercase; text-decoration: none; color: #000; box-shadow: 5px 5px 0px #000; font-size: 1rem; transition: all 0.1s; }
    .btn-back:active { box-shadow: 0 0 0; transform: translate(5px,5px); }
</style>

@include('partials.topbar')

<h1>MI PERFIL</h1>

<div class="profile-card">
    <div class="field">
        <label>Nombre</label>
        <span class="value">{{ $user['name'] }}</span>
    </div>
    <div class="field">
        <label>Usuario</label>
        <span class="value">{{ $user['usuario'] }}</span>
    </div>
    <div class="field full-width">
        <label>Correo Electrónico</label>
        <span class="value">{{ $user['email'] }}</span>
    </div>
    <div class="field full-width">
        <label>Rol de Acceso</label>
        <span class="rol-badge {{ $user['rol'] === 'Administrador' ? 'rol-admin' : 'rol-empleado' }}">
            {{ strtoupper($user['rol']) }}
        </span>
    </div>
</div>

<a href="{{ route('admin.dashboard') }}" class="btn-back">← VOLVER AL PANEL</a>
