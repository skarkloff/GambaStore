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

<script>
    window._confirmForm = null;

    function openConfirmModal(btn, message) {
        window._confirmForm = btn.closest('form');

        var existing = document.getElementById('_confirm_modal');
        if (existing) existing.remove();

        var overlay = document.createElement('div');
        overlay.id = '_confirm_modal';
        overlay.style.cssText = [
            'position:fixed','top:0','left:0','right:0','bottom:0',
            'z-index:99999','background:rgba(0,0,0,0.65)',
            'display:flex','align-items:center','justify-content:center'
        ].join(';');

        var btnStyle = 'flex:1;padding:12px 20px;border:4px solid #000;font-weight:900;text-transform:uppercase;cursor:pointer;font-family:Arial Black,Gadget,sans-serif;font-size:1rem;box-shadow:5px 5px 0 #000;transition:all .1s;';

        overlay.innerHTML =
            '<div style="background:#fff;border:6px solid #000;box-shadow:12px 12px 0 #000;padding:40px;max-width:440px;width:90%;font-family:Arial Black,Gadget,sans-serif;">' +
                '<div style="font-size:1.5rem;text-transform:uppercase;font-weight:900;background:#ff4545;display:inline-block;padding:6px 18px;border:4px solid #000;box-shadow:6px 6px 0 #000;color:#fff;margin-bottom:16px;">¡ATENCIÓN!</div>' +
                '<p style="font-size:1rem;font-weight:900;text-transform:uppercase;margin:20px 0 30px;line-height:1.4;font-family:Arial Black,Gadget,sans-serif;">' + message + '</p>' +
                '<div style="display:flex;gap:15px;">' +
                    '<button id="_confirm_cancel" style="' + btnStyle + 'background:#00ff00;color:#000;">CANCELAR</button>' +
                    '<button id="_confirm_ok"     style="' + btnStyle + 'background:#ff4545;color:#fff;">ELIMINAR</button>' +
                '</div>' +
            '</div>';

        document.body.appendChild(overlay);

        document.getElementById('_confirm_cancel').onclick = function() { closeConfirmModal(); };
        document.getElementById('_confirm_ok').onclick = function() {
            var form = window._confirmForm;
            closeConfirmModal();
            if (form) form.submit();
        };
        overlay.onclick = function(e) { if (e.target === overlay) closeConfirmModal(); };
    }

    function closeConfirmModal() {
        var m = document.getElementById('_confirm_modal');
        if (m) m.remove();
        window._confirmForm = null;
    }
</script>

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
