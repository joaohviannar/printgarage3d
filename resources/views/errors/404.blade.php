{{--
    Página 404 — "peça não impressa"
    Implementação do handoff "design_handoff_404".

    O Laravel resolve esta view automaticamente para NotFoundHttpException e
    responde com status HTTP 404 (não 200, não redirect).

    Página standalone: o design tem header, footer e paleta próprios
    (chumbo/vermelho-tijolo), diferentes do tema do site.
--}}
@php
    $waNumero   = \App\Services\ConfiguracaoService::whatsappNumero();
    $waExibicao = \App\Services\ConfiguracaoService::whatsappExibicao();
    $waLink     = 'https://wa.me/' . $waNumero;
    $instagram  = \App\Services\ConfiguracaoService::get('instagram_url', 'https://instagram.com/printgarage_3d');
    $instaHandle= \App\Services\ConfiguracaoService::get('instagram_handle', '@printgarage_3d');

    // Progresso da "impressão" do 404 (10–100). Fixado conforme o handoff.
    $printProgress = 68;
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">

    <title>Página não encontrada · Print Garage 3D</title>
    <meta name="description" content="A página que você procurou não existe. Volte para o início ou fale com a Print Garage 3D no WhatsApp.">
    <meta name="theme-color" content="#0D0C0C">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@500;700;900&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand:       #8E1512;
            --brand-hover: #A81B17;
            --head-glow:   #E0433E;
            --eyebrow:     #E08C89;
            --focus:       #F2B4B2;
            --txt:         #E8DFDA;
            --txt-strong:  #F6F1ED;
            --lockup:      #F3EDE9;
            --line:        rgba(255, 255, 255, 0.07);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body { margin: 0; padding: 0; background: #0D0C0C; }

        body {
            position: relative;
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            flex-direction: column;
            background: radial-gradient(120% 90% at 50% -10%, #241a19 0%, #141212 45%, #0D0C0C 100%);
            color: var(--txt);
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        a { color: var(--txt); text-decoration: none; }
        a:hover { color: #fff; }

        :focus-visible { outline: 2px solid var(--focus); outline-offset: 3px; border-radius: 2px; }

        @keyframes pg-print {
            from { clip-path: inset(100% 0 0 0); }
            to   { clip-path: inset(0 0 0 0); }
        }
        @keyframes pg-pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(142, 21, 18, 0.55); }
            50%      { box-shadow: 0 0 0 12px rgba(142, 21, 18, 0); }
        }

        /* Grid de filamento (decorativo) */
        .filament-grid {
            position: absolute;
            inset: 0;
            pointer-events: none;
            opacity: 0.5;
            background-image:
                repeating-linear-gradient(0deg,  rgba(255,255,255,0.045) 0 1px, transparent 1px 44px),
                repeating-linear-gradient(90deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 44px);
            -webkit-mask-image: radial-gradient(80% 70% at 50% 40%, #000 0%, transparent 100%);
                    mask-image: radial-gradient(80% 70% at 50% 40%, #000 0%, transparent 100%);
        }

        /* ---------- Header ---------- */

        .site-header {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--line);
        }
        .lockup { display: flex; align-items: center; gap: 12px; }
        .lockup img { width: 34px; height: 34px; flex: none; object-fit: contain; display: block; }
        .lockup .lines { display: flex; flex-direction: column; gap: 2px; }
        .lockup .name {
            font-family: Archivo, sans-serif;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--lockup);
        }
        .lockup .sub {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(232, 223, 218, 0.5);
        }
        .err-code {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.14em;
            color: rgba(232, 223, 218, 0.42);
        }

        /* ---------- Main ---------- */

        main {
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 28px;
            padding: 56px 24px 48px;
            text-align: center;
        }

        /* Número 404 em duas camadas */
        .piece {
            position: relative;
            width: 100%;
            max-width: 620px;
            height: clamp(150px, 36vw, 300px);
        }
        .piece .digits {
            font-family: Archivo, sans-serif;
            font-weight: 900;
            font-size: clamp(130px, 32vw, 280px);
            line-height: 1;
            letter-spacing: -0.05em;
            display: grid;
            place-items: center;
        }
        /* Camada base: a parte ainda não impressa */
        .piece .unprinted {
            position: absolute;
            inset: 0;
            color: rgba(255, 255, 255, 0.055);
        }
        /* Camada impressa: recortada na altura do progresso */
        .piece .printed {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            height: {{ $printProgress }}%;
            animation: pg-print 2.4s cubic-bezier(.2, .7, .2, 1) both;
        }
        .piece .printed .digits {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: clamp(150px, 36vw, 300px);
            /* Linhas de camada de impressão preenchendo o texto */
            background-image: repeating-linear-gradient(180deg, #F6F1ED 0 4px, #B9AFA9 4px 5px);
            -webkit-background-clip: text;
                    background-clip: text;
            color: transparent;
        }
        /* Cabeçote da impressora, no topo da camada impressa */
        .piece .head {
            position: absolute;
            top: 0;
            left: -4%;
            width: 108%;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--brand) 12%, var(--head-glow) 50%, var(--brand) 88%, transparent);
            box-shadow: 0 0 18px rgba(224, 67, 62, 0.55);
        }

        .copy {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            max-width: 560px;
        }
        .copy .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--eyebrow);
        }
        .copy h1 {
            margin: 0;
            font-family: Archivo, sans-serif;
            font-weight: 900;
            font-size: clamp(28px, 6vw, 46px);
            line-height: 1.05;
            letter-spacing: -0.025em;
            color: var(--txt-strong);
            text-wrap: balance;
        }
        .copy p {
            margin: 0;
            font-size: clamp(15px, 2.4vw, 17px);
            line-height: 1.6;
            color: rgba(232, 223, 218, 0.72);
            text-wrap: pretty;
        }

        /* ---------- CTAs ---------- */

        .ctas {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            width: 100%;
            max-width: 560px;
        }
        .ctas a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 52px;
            border-radius: 4px;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease;
        }
        .cta-primary {
            flex: 1 1 200px;
            padding: 0 24px;
            background: var(--brand);
            color: #FFF6F5;
            font-family: Archivo, sans-serif;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.02em;
            animation: pg-pulse 3.2s ease-in-out 2.6s infinite;
        }
        .cta-primary:hover { background: var(--brand-hover); color: #FFF6F5; }

        .cta-secondary {
            flex: 1 1 160px;
            padding: 0 24px;
            border: 1px solid rgba(246, 241, 237, 0.28);
            color: var(--txt-strong);
            font-family: Archivo, sans-serif;
            font-weight: 700;
            font-size: 15px;
        }
        .cta-secondary:hover { border-color: var(--txt-strong); background: rgba(246, 241, 237, 0.06); color: var(--txt-strong); }

        .cta-tertiary {
            flex: 1 1 160px;
            gap: 8px;
            padding: 0 20px;
            color: rgba(232, 223, 218, 0.8);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            letter-spacing: 0.06em;
        }
        .cta-tertiary:hover { color: #fff; background: rgba(246, 241, 237, 0.06); }

        /* ---------- Footer ---------- */

        .site-footer {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px 24px;
            padding: 18px 24px 22px;
            border-top: 1px solid var(--line);
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(232, 223, 218, 0.45);
        }
        .site-footer .contacts { display: flex; flex-wrap: wrap; gap: 8px 18px; }
        .site-footer .contacts a { color: rgba(232, 223, 218, 0.6); }
        .site-footer .contacts a:hover { color: #fff; }

        /* Obrigatório pelo handoff: nada anima para quem pediu menos movimento.
           O 404 fica estático já no progresso final. */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body>

<div class="filament-grid" aria-hidden="true"></div>

<header class="site-header">
    <a href="{{ url('/') }}" class="lockup">
        <img src="{{ asset('assets/brand/logo/icone.png') }}" alt="Print Garage 3D" width="34" height="34">
        <span class="lines">
            <span class="name">Print Garage 3D</span>
            <span class="sub">Impressão 3D · Brasília-DF</span>
        </span>
    </a>
    <span class="err-code">ERR_404</span>
</header>

<main>
    {{-- O "404" é ilustração: os leitores de tela recebem a informação pelo <h1>. --}}
    <div class="piece" aria-hidden="true">
        <div class="digits unprinted">404</div>
        <div class="printed">
            <div class="digits">404</div>
            <div class="head"></div>
        </div>
    </div>

    <div class="copy">
        <span class="eyebrow">impressão interrompida</span>
        <h1>Essa peça ainda<br>não foi impressa.</h1>
        <p>
            O link que você seguiu não existe (ou saiu do catálogo). Nada quebrado por aqui —
            a garagem segue ligada e a impressora, quentinha.
        </p>
    </div>

    <div class="ctas">
        <a href="{{ route('site.home') }}" class="cta-primary">Voltar para o início</a>
        <a href="{{ route('site.catalogo') }}" class="cta-secondary">Ver catálogo</a>
        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="cta-tertiary">Falar no WhatsApp →</a>
    </div>
</main>

<footer class="site-footer">
    <span>Suas ideias, impressas em 3D.</span>
    <div class="contacts">
        <a href="{{ $waLink }}" target="_blank" rel="noopener">{{ $waExibicao }}</a>
        <a href="{{ $instagram }}" target="_blank" rel="noopener">{{ $instaHandle }}</a>
    </div>
</footer>

</body>
</html>
