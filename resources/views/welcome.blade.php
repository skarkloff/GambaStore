<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamba Store</title>
    <style>
        :root {
            --bg: #0a0a0a;
            --yellow: #ffde00;
            --white: #ffffff;
            --border: #ffde00;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--bg);
            color: var(--white);
            font-family: 'Arial Black', Gadget, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 40px;
        }

        /* HEADER */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 4px solid var(--border);
            padding: 16px 30px;
            margin-bottom: 40px;
            background-color: var(--bg);
            box-shadow: 8px 8px 0px var(--yellow);
        }

        .logo {
            font-size: 1.3rem;
            color: var(--yellow);
            text-transform: uppercase;
            letter-spacing: 6px;
        }

        .header-badge {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--yellow);
            border: 2px solid var(--yellow);
            padding: 6px 14px;
            opacity: 0.6;
        }

        /* HERO */
        .hero {
            border: 6px solid var(--yellow);
            box-shadow: 12px 12px 0px var(--yellow);
            background-color: var(--yellow);
            padding: 60px 50px;
            margin-bottom: 40px;
            text-align: center;
        }

        .hero h1 {
            font-size: clamp(3.5rem, 9vw, 8rem);
            text-transform: uppercase;
            line-height: 0.9;
            color: var(--bg);
            letter-spacing: -2px;
            margin-bottom: 16px;
        }

        .hero-divider {
            width: 80px;
            height: 6px;
            background: var(--bg);
            margin: 20px auto;
        }

        .hero-sub {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: var(--bg);
            font-family: Arial, sans-serif;
            font-weight: 700;
            opacity: 0.7;
        }

        /* FEATURES */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .feature-card {
            border: 4px solid var(--yellow);
            padding: 36px 30px;
            box-shadow: 8px 8px 0px var(--yellow);
            background-color: var(--bg);
            position: relative;
        }

        .feature-number {
            font-size: 0.65rem;
            letter-spacing: 4px;
            color: var(--yellow);
            text-transform: uppercase;
            margin-bottom: 16px;
            display: block;
            font-family: Arial, sans-serif;
            font-weight: 700;
        }

        .feature-card h3 {
            font-size: 1.2rem;
            text-transform: uppercase;
            color: var(--yellow);
            margin-bottom: 14px;
            line-height: 1.1;
        }

        .feature-card p {
            font-size: 0.85rem;
            font-family: Arial, sans-serif;
            line-height: 1.7;
            font-weight: 400;
            color: #aaa;
        }

        /* SCOREBOARD */
        .scoreboard {
            border: 4px solid var(--yellow);
            box-shadow: 10px 10px 0px var(--yellow);
            background-color: var(--bg);
            padding: 30px 40px;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .scoreboard-label {
            font-size: 0.65rem;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: var(--yellow);
            font-family: Arial, sans-serif;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .scoreboard-value {
            font-size: 3rem;
            color: var(--white);
            line-height: 1;
        }

        .scoreboard-divider {
            width: 4px;
            height: 60px;
            background: var(--yellow);
            opacity: 0.3;
        }

        /* FOOTER */
        footer {
            border: 3px solid #333;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .footer-brand {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: var(--yellow);
        }

        .footer-credits {
            font-size: 0.65rem;
            font-family: Arial, sans-serif;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>

    <header>
        <span class="logo">Gamba Store</span>
        <span class="header-badge">Botines de fútbol</span>
    </header>

    <section class="hero">
        <h1>Gamba<br>Store</h1>
        <div class="hero-divider"></div>
        <p class="hero-sub">Tu tienda de botines</p>
    </section>

    <div class="scoreboard">
        <div>
            <div class="scoreboard-label">Temporada</div>
            <div class="scoreboard-value">2026</div>
        </div>
        <div class="scoreboard-divider"></div>
        <div>
            <div class="scoreboard-label">Especialidad</div>
            <div class="scoreboard-value">BOTINES</div>
        </div>
        <div class="scoreboard-divider"></div>
        <div>
            <div class="scoreboard-label">Envíos</div>
            <div class="scoreboard-value">TODO ARG</div>
        </div>
    </div>

    <section class="features">
        <div class="feature-card">
            <span class="feature-number">— 01</span>
            <h3>Marcas top</h3>
            <p>Nike, Adidas, Puma y más. Solo lo que vale la pena pisar.</p>
        </div>
        <div class="feature-card">
            <span class="feature-number">— 02</span>
            <h3>Clásicos que no mueren</h3>
            <p>Modelos retro que marcaron épocas. El botín que usaba tu ídolo, ahora en tu pie.</p>
        </div>
        <div class="feature-card">
            <span class="feature-number">— 03</span>
            <h3>Precio directo</h3>
            <p>Sin intermediarios ni markups escondidos. Lo que ves, es lo que pagás.</p>
        </div>
    </section>

    <footer>
        <span class="footer-brand">Gamba Store</span>
        <span class="footer-credits">Lautaro Skarkloff &amp; Patricio Zappellini — 2026</span>
    </footer>

</body>
</html>
