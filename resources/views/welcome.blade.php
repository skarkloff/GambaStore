<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamba Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Oswald:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --yellow: #ffde00;
            --black: #000000;
            --gray-bg: #b8b8b8;
            --gray-dark: #2a2a2a;
            --white: #c8c8c8;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--gray-bg);
            font-family: 'Press Start 2P', monospace;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: none;
            -moz-osx-font-smoothing: unset;
            font-smooth: never;
        }

        /* ── HEADER ── */
        header {
            background-color: var(--black);
            border-bottom: 5px solid var(--black);
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .btn-admin, .btn-panel {
            font-family: 'Press Start 2P', monospace;
            font-size: 13px;
            color: var(--black);
            background-color: var(--yellow);
            text-decoration: none;
            text-transform: uppercase;
            padding: 8px 14px;
            border: 4px solid var(--yellow);
            box-shadow: 5px 5px 0px var(--yellow);
            letter-spacing: 2px;
            -webkit-text-stroke: 0.5px var(--black);
            transition: all 0.1s;
            display: inline-block;
        }

        .btn-admin:active, .btn-panel:active {
            box-shadow: 0px 0px 0px var(--yellow);
            transform: translate(4px, 4px);
        }

        .logo {
            font-family: 'Press Start 2P', monospace;
            font-size: 24px;
            color: var(--yellow);
            letter-spacing: 4px;
            display: flex;
            align-items: center;
            padding-right: 30px;
            border-right: 3px solid #333;
        }

        .header-tag {
            font-family: 'Oswald', sans-serif;
            font-size: 0.7rem;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #666;
            display: flex;
            align-items: center;
            padding-left: 30px;
        }

        /* ── HERO ── */
        .hero {
            background-color: var(--yellow);
            border-bottom: 6px solid var(--black);
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .hero-left {
            padding: 60px 40px;
            border-right: 6px solid var(--black);
        }

        .hero-eyebrow {
            font-family: 'Oswald', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: #555;
            margin-bottom: 16px;
        }

        .hero-left h1 {
            font-family: 'Press Start 2P', monospace;
            font-size: 64px;
            line-height: 1.4;
            color: var(--black);
            letter-spacing: 2px;
        }

        .hero-right {
            background-color: var(--black);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
        }

        .stat-row {
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }

        .stat-row:last-child { border-bottom: none; padding-bottom: 0; }

        .stat-label {
            font-family: 'Oswald', sans-serif;
            font-size: 0.65rem;
            font-weight: 400;
            letter-spacing: 4px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .stat-value {
            font-family: 'Press Start 2P', monospace;
            font-size: 24px;
            color: var(--yellow);
            letter-spacing: 2px;
        }

        /* ── FEATURES ── */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border-bottom: 6px solid var(--black);
            flex: 1;
        }

        .feature-card {
            background-color: var(--white);
            padding: 40px 36px;
            border-right: 5px solid var(--black);
        }

        .feature-card:last-child { border-right: none; }

        .feature-num {
            font-family: 'Press Start 2P', monospace;
            font-size: 8px;
            letter-spacing: 3px;
            color: #888;
            display: block;
            margin-bottom: 16px;
        }

        .feature-card h3 {
            font-family: 'Press Start 2P', monospace;
            font-size: 24px;
            letter-spacing: 1px;
            color: var(--black);
            line-height: 1.6;
            margin-bottom: 12px;
            background-color: var(--yellow);
            display: inline-block;
            padding: 4px 12px;
            box-shadow: 4px 4px 0px var(--black);
        }

        .feature-card p {
            font-family: 'Oswald', sans-serif;
            font-size: 1.3rem;
            font-weight: 600;
            line-height: 1.6;
            color: #222;
            margin-top: 14px;
        }

        /* ── FOOTER ── */
        footer {
            background-color: var(--black);
            border-top: 5px solid var(--black);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand {
            font-family: 'Press Start 2P', monospace;
            font-size: 16px;
            letter-spacing: 4px;
            color: var(--yellow);
        }

        .footer-credits {
            font-family: 'Oswald', sans-serif;
            font-size: 0.6rem;
            font-weight: 400;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* ── LOGIN MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.75);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-box {
            background: #b8b8b8;
            border: 5px solid #000;
            box-shadow: 15px 15px 0px #000;
            padding: 35px;
            width: 100%;
            max-width: 480px;
            position: relative;
            font-family: 'Arial Black', sans-serif;
        }
        .modal-title {
            background: #ffde00;
            display: inline-block;
            padding: 8px 20px;
            border: 5px solid #000;
            box-shadow: 6px 6px 0px #000;
            text-transform: uppercase;
            font-size: 1.4rem;
            font-weight: 900;
            margin-bottom: 25px;
        }
        .modal-close {
            position: absolute;
            top: 12px; right: 14px;
            background: #ff4545; color: white;
            border: 3px solid #000; font-weight: 900;
            font-size: 1rem; cursor: pointer;
            padding: 4px 10px;
            font-family: 'Arial Black', sans-serif;
            box-shadow: 3px 3px 0 #000;
        }
        .modal-close:active { box-shadow: 0 0 0; transform: translate(3px,3px); }
        .modal-field { display: flex; flex-direction: column; margin-bottom: 18px; }
        .modal-field label { text-transform: uppercase; font-weight: 900; font-size: 0.85rem; margin-bottom: 6px; }
        .modal-field input { padding: 10px; border: 3px solid #000; font-family: sans-serif; font-weight: bold; font-size: 1rem; background: white; }
        .modal-error-field { color: #cc0000; font-size: 0.85rem; margin-top: 5px; font-family: Arial, sans-serif; font-weight: bold; }
        .modal-btn-group { display: flex; gap: 12px; margin-top: 10px; }
        .modal-btn-submit { flex: 1; background: #00ff00; padding: 14px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.2rem; font-family: 'Arial Black', sans-serif; transition: all 0.1s; }
        .modal-btn-submit:active { box-shadow: 0 0 0; transform: translate(5px,5px); }
        .modal-btn-cancel { flex: 1; background: #ff4545; color: white; padding: 14px; border: 4px solid #000; font-weight: 900; cursor: pointer; box-shadow: 5px 5px 0px #000; text-transform: uppercase; font-size: 1.2rem; font-family: 'Arial Black', sans-serif; transition: all 0.1s; }
        .modal-btn-cancel:active { box-shadow: 0 0 0; transform: translate(5px,5px); }
    </style>
</head>
<body>

    <header>
        <span class="header-tag">Botines de fútbol</span>
        @if(session('auth_user'))
            <a href="{{ route('admin.dashboard') }}" class="btn-panel">PANEL DE CONTROL</a>
        @else
            <button class="btn-panel" onclick="openLoginModal()">PANEL DE CONTROL</button>
        @endif
    </header>

    <section class="hero">
        <div class="hero-left">
            <p class="hero-eyebrow">Temporada 2026</p>
            <h1>GAMBA<br>STORE</h1>
        </div>
        <div class="hero-right">
            <div class="stat-row">
                <div class="stat-label">Especialidad</div>
                <div class="stat-value">Botines de fútbol</div>
            </div>
            <div class="stat-row">
                <div class="stat-label">Envíos</div>
                <div class="stat-value">Todo el país</div>
            </div>
            <div class="stat-row">
                <div class="stat-label">Stock</div>
                <div class="stat-value">Actualizado</div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="feature-card">
            <span class="feature-num">— 01</span>
            <h3>Marcas top</h3>
            <p>Nike, Adidas, Puma y más. Solo lo que vale la pena pisar.</p>
        </div>
        <div class="feature-card">
            <span class="feature-num">— 02</span>
            <h3>Clásicos que no mueren</h3>
            <p>Modelos retro que marcaron épocas. El botín que usaba tu ídolo, ahora en tu pie.</p>
        </div>
        <div class="feature-card">
            <span class="feature-num">— 03</span>
            <h3>Precio directo</h3>
            <p>Sin intermediarios ni markups escondidos. Lo que ves, es lo que pagás.</p>
        </div>
    </section>

    <!-- LOGIN MODAL -->
    <div class="modal-overlay" id="loginModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeLoginModal()">✕</button>
            <div class="modal-title">INICIAR SESIÓN</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="modal-field">
                    <label>Usuario o Correo</label>
                    <input type="text" name="login" value="{{ old('login') }}" autocomplete="username">
                    @error('login') <span class="modal-error-field">{{ $message }}</span> @enderror
                </div>
                <div class="modal-field">
                    <label>Contraseña</label>
                    <input type="password" name="password" autocomplete="current-password">
                    @error('password') <span class="modal-error-field">{{ $message }}</span> @enderror
                </div>
                <div class="modal-btn-group">
                    <button type="submit" class="modal-btn-submit">INGRESAR</button>
                    <button type="button" class="modal-btn-cancel" onclick="closeLoginModal()">CANCELAR</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openLoginModal()  { document.getElementById('loginModal').classList.add('active'); }
        function closeLoginModal() { document.getElementById('loginModal').classList.remove('active'); }

        // Auto-abrir si hay errores de login o redirect desde rutas protegidas
        @if($errors->any() || session('open_login'))
        document.addEventListener('DOMContentLoaded', openLoginModal);
        @endif

        // Cerrar al hacer click fuera del modal
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) closeLoginModal();
        });
    </script>

    <footer>
        <span class="footer-brand">Gamba Store</span>
        <span class="footer-credits">Lautaro Skarkloff &amp; Patricio Zappellini — 2026</span>
    </footer>

</body>
</html>
