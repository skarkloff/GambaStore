<style>
    .topbar {
        background: #000;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 40px;
        border-bottom: 5px solid #ffde00;
        margin: -40px -40px 30px -40px;
        font-family: 'Arial Black', sans-serif;
    }
    .topbar-brand {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #ffde00;
        font-weight: 900;
        text-decoration: none;
    }
    .topbar-brand:hover { text-decoration: underline; }
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .topbar-user {
        font-size: 0.85rem;
        font-weight: 900;
        text-transform: uppercase;
        color: #fff;
        padding-right: 12px;
        border-right: 2px solid #444;
    }
    .topbar-btn {
        padding: 7px 14px;
        border: 3px solid;
        font-weight: 900;
        font-size: 0.75rem;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        font-family: 'Arial Black', sans-serif;
        transition: all 0.1s;
        box-shadow: 3px 3px 0px;
        display: inline-block;
        background: none;
    }
    .topbar-btn:active { box-shadow: 0 0 0; transform: translate(3px,3px); }
    .topbar-btn-profile { background: #ffde00; color: #000; border-color: #ffde00; box-shadow: 3px 3px 0px #ffde00; }
    .topbar-btn-logout  { background: #ff4545; color: #fff; border-color: #ff4545; box-shadow: 3px 3px 0px #ff4545; }
</style>

<div class="topbar">
    <a href="{{ url('/') }}" class="topbar-brand">← GAMBASTORE / ADMIN</a>
    <div class="topbar-right">
        <span class="topbar-user">👤 {{ session('auth_user.usuario') }}</span>
        <a href="{{ route('admin.profile') }}" class="topbar-btn topbar-btn-profile">PERFIL</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline; margin:0;">
            @csrf
            <button type="submit" class="topbar-btn topbar-btn-logout">CERRAR SESIÓN</button>
        </form>
    </div>
</div>
