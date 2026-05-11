<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamba Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        :root {
            --black: #111111;
            --yellow: #ffde00;
            --gray-light: #d6d6d6;
            --gray-mid: #aaaaaa;
            --white: #f0f0f0;
            --shadow: #000000;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--black);
            color: var(--white);
            font-family: 'Press Start 2P', monospace;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 30px;
        }

        /* HEADER */
        header {
            background-color: var(--black);
            border: 4px solid var(--yellow);
            box-shadow: 6px 6px 0px var(--yellow);
            padding: 18px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 1rem;
            color: var(--yellow);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header-badge {
            font-size: 0.45rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gray-mid);
            border: 2px solid #333;
            padding: 6px 12px;
        }

        /* HERO */
        .hero {
            background-color: var(--yellow);
            border: 6px solid var(--shadow);
            box-shadow: 12px 12px 0px var(--shadow);
            padding: 50px 40px;
            margin-bottom: 30px;
            text-align: center;
        }

        .hero h1 {
            font-family: 'Press Start 2P', monospace;
            font-size: clamp(2rem, 5vw, 4.5rem);
            text-transform: uppercase;
            color: var(--shadow);
            line-height: 1.3;
            margin-bottom: 20px;
        }

        .hero-line {
            width: 60px;
            height: 5px;
            background: var(--shadow);
            margin: 0 auto 20px;
        }

        .hero-sub {
            font-size: 0.45rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: #333;
            line-height: 2;
        }

        /* FEATURES */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 30px;
        }

        .feature-card {
            background-color: var(--gray-light);
            border: 4px solid var(--shadow);
            box-shadow: 7px 7px 0px var(--shadow);
            padding: 30px 24px;
            color: var(--shadow);
        }

        .feature-number {
            font-size: 0.45rem;
            letter-spacing: 3px;
            color: #555;
            text-transform: uppercase;
            margin-bottom: 14px;
            display: block;
        }

        .feature-card h3 {
            font-size: 0.6rem;
            text-transform: uppercase;
            color: var(--shadow);
            margin-bottom: 14px;
            line-height: 1.6;
            border-left: 4px solid var(--yellow);
            padding-left: 10px;
        }

        .feature-card p {
            font-size: 0.5rem;
            font-family: Arial, sans-serif;
            font-weight: 700;
            line-height: 1.8;
            color: #444;
        }

        /* SCOREBOARD */
        .scoreboard {
            background-color: var(--gray-light);
            border: 4px solid var(--shadow);
            box-shadow: 8px 8px 0px var(--shadow);
            padding: 24px 30px;
            margin-bottom: 30px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
        }

        .score-item {
            padding: 16px 24px;
            border-right: 3px solid #aaa;
            color: var(--shadow);
        }

        .score-item:last-child { border-right: none; }

        .score-label {
            font-size: 0.4rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 10px;
            display: block;
        }

        .score-value {
            font-size: 1rem;
            color: var(--shadow);
            line-height: 1;
            background-color: var(--yellow);
            display: inline-block;
            padding: 6px 12px;
            border: 3px solid var(--shadow);
            box-shadow: 4px 4px 0px var(--shadow);
        }

        /* FOOTER */
        footer {
            border: 3px solid #2a2a2a;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .footer-brand {
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--yellow);
        }

        .footer-credits {
            font-size: 0.35rem;
            font-family: Arial, sans-serif;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <header>
        <span class="logo">Gamba Store</span>
        <span class="header-badge">Est. 2025 — Botines de fútbol</span>
    </header>

    <section class="hero">
        <h1>GAMBA<br>STORE</h1>
        <div class="hero-line"></div>
        <p class="hero-sub">Tu tienda de botines — Envíos a todo el país</p>
    </section>

    <div class="scoreboard">
        <div class="score-item">
            <span class="score-label">Temporada</span>
            <span class="score-value">2026</span>
        </div>
        <div class="score-item">
            <span class="score-label">Especialidad</span>
            <span class="score-value">BOTINES</span>
        </div>
        <div class="score-item">
            <span class="score-label">Cobertura</span>
            <span class="score-value">ARG</span>
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
