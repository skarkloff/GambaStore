<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamba Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --yellow: #ffde00;
            --black: #000000;
            --gray-bg: #e0e0e0;
            --gray-dark: #2a2a2a;
            --white: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--gray-bg);
            font-family: 'Bebas Neue', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── HEADER ── */
        header {
            background-color: var(--black);
            border-bottom: 5px solid var(--black);
            padding: 0 40px;
            display: flex;
            align-items: stretch;
            height: 70px;
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
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
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(5rem, 10vw, 9rem);
            line-height: 0.9;
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
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
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
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1rem;
            letter-spacing: 3px;
            color: #bbb;
            display: block;
            margin-bottom: 16px;
        }

        .feature-card h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 1px;
            color: var(--black);
            line-height: 1;
            margin-bottom: 12px;
            background-color: var(--yellow);
            display: inline-block;
            padding: 2px 10px 0;
            box-shadow: 4px 4px 0px var(--black);
        }

        .feature-card p {
            font-family: 'Oswald', sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.7;
            color: #555;
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
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
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
    </style>
</head>
<body>

    <header>
        <span class="logo">Gamba Store</span>
        <span class="header-tag">Botines de fútbol</span>
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

    <footer>
        <span class="footer-brand">Gamba Store</span>
        <span class="footer-credits">Lautaro Skarkloff &amp; Patricio Zappellini — 2026</span>
    </footer>

</body>
</html>
