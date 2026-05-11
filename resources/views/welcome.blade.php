<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamba Store</title>
    <style>
        :root {
            --black: #0a0a0a;
            --yellow: #ffde00;
            --white: #f5f5f5;
            --gray: #1c1c1c;
            --border: #ffde00;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background-color: var(--black);
            color: var(--white);
            font-family: 'Arial Black', Gadget, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        header {
            padding: 24px 60px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid #222;
        }

        .logo {
            font-size: 1.4rem;
            color: var(--yellow);
            text-transform: uppercase;
            letter-spacing: 4px;
        }

        .logo span {
            color: var(--white);
        }

        /* HERO */
        .hero {
            flex: 1;
            padding: 100px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-bottom: 2px solid #222;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: 'GS';
            position: absolute;
            right: -20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 30rem;
            font-weight: 900;
            color: #141414;
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        .hero-tag {
            font-size: 0.75rem;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--yellow);
            margin-bottom: 24px;
            font-family: Arial, sans-serif;
            font-weight: 700;
        }

        .hero h1 {
            font-size: clamp(3rem, 8vw, 7rem);
            text-transform: uppercase;
            line-height: 0.95;
            color: var(--white);
            margin-bottom: 32px;
        }

        .hero h1 em {
            font-style: normal;
            color: var(--yellow);
            border-bottom: 6px solid var(--yellow);
        }

        .hero-sub {
            font-size: 1rem;
            font-family: Arial, sans-serif;
            font-weight: 400;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 2px;
            max-width: 400px;
        }

        /* FEATURES */
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }

        .feature-card {
            padding: 50px 50px;
            border-right: 2px solid #222;
            border-bottom: 2px solid #222;
        }

        .feature-card:last-child { border-right: none; }

        .feature-number {
            font-size: 0.7rem;
            letter-spacing: 4px;
            color: var(--yellow);
            font-family: Arial, sans-serif;
            font-weight: 700;
            margin-bottom: 20px;
            display: block;
        }

        .feature-card h3 {
            font-size: 1.1rem;
            text-transform: uppercase;
            margin-bottom: 14px;
            color: var(--white);
        }

        .feature-card p {
            font-size: 0.9rem;
            font-family: Arial, sans-serif;
            line-height: 1.7;
            font-weight: 400;
            color: #777;
        }

        .feature-accent {
            display: inline-block;
            width: 30px;
            height: 4px;
            background: var(--yellow);
            margin-bottom: 20px;
        }

        /* FOOTER */
        footer {
            border-top: 2px solid #222;
            padding: 20px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-brand {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--yellow);
        }

        .footer-credits {
            font-size: 0.7rem;
            font-family: Arial, sans-serif;
            color: #444;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <header>
        <span class="logo">Gamba<span>Store</span></span>
    </header>

    <section class="hero">
        <p class="hero-tag">Botines de fútbol</p>
        <h1>El botín<br>que te hace<br><em>jugar mejor</em></h1>
        <p class="hero-sub">Stock actualizado — Envíos a todo el país</p>
    </section>

    <section class="features">
        <div class="feature-card">
            <span class="feature-accent"></span>
            <span class="feature-number">— 01</span>
            <h3>Marcas top</h3>
            <p>Nike, Adidas, Puma y más. Solo lo que vale la pena pisar.</p>
        </div>
        <div class="feature-card">
            <span class="feature-accent"></span>
            <span class="feature-number">— 02</span>
            <h3>Stock real</h3>
            <p>Talles y unidades actualizados en tiempo real. Sin vender lo que no hay.</p>
        </div>
        <div class="feature-card">
            <span class="feature-accent"></span>
            <span class="feature-number">— 03</span>
            <h3>Precio directo</h3>
            <p>Sin intermediarios ni markups escondidos. Lo que ves, es lo que pagás.</p>
        </div>
    </section>

    <footer>
        <span class="footer-brand">Gamba Store</span>
        <span class="footer-credits">Lautaro Skarkloff &amp; Patricio Zappellini — 2025</span>
    </footer>

</body>
</html>
