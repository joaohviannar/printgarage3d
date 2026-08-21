{{--
    Landing Page — Programa de Parceiros (Pet Shops)
    Implementação do handoff "design_handoff_parceria_petshop".

    Página standalone (não usa layouts.site): o design tem header, footer e
    sistema de cores próprios. Os tokens abaixo são finais — vieram do handoff
    e não devem ser "aproximados" para a escala do Tailwind.
--}}
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Programa de Parceiros para Pet Shops · Print Garage 3D</title>
    <meta name="description" content="Venda miniaturas 3D personalizadas do pet do cliente sem estoque e sem risco. Custo fixo de R$ 130 por peça, você define o preço final. Parceria B2B no DF e entorno.">
    <meta name="theme-color" content="#0A0A0C">

    {{-- Open Graph (preview ao enviar no WhatsApp) --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:title" content="R$ 120 de lucro por peça, sem estoque e sem risco">
    <meta property="og:description" content="Seu pet shop vende miniaturas 3D personalizadas do pet do cliente. A gente produz só depois da venda fechada.">
    <meta property="og:image" content="{{ asset('assets/petshop/mini-bolt.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg:           #0A0A0C;
            --bg-alt:       #0D0D11;
            --surface:      #121118;
            --surface-dim:  #101014;
            --accent:       #F5301E;
            --accent-hover: #D8250F;
            --accent-light: #FF7461;
            --link-hover:   #FF6B57;
            --txt:          #F3F1EE;
            --txt-2:        #B4B0BC;
            --txt-3:        #A6A2AE;
            --txt-muted:    #8F8B99;
            --txt-faint:    #6B6775;
            --txt-hi:       #E7E4EC;
            --txt-hi-2:     #C9C5D2;
            --border:       rgba(255, 255, 255, 0.09);
            --divider:      rgba(255, 255, 255, 0.07);
            --accent-brd:   rgba(245, 48, 30, 0.4);
            --grad-step:    linear-gradient(160deg, #17142B 0%, #121118 100%);
            --grad-hi:      linear-gradient(160deg, #221429 0%, #121118 100%);
            --grad-sec:     linear-gradient(180deg, #100E1A 0%, #0A0A0C 100%);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--txt);
            font-family: Poppins, system-ui, sans-serif;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a { color: var(--accent); text-decoration: none; }
        a:hover { color: var(--link-hover); }

        h1, h2, p { margin: 0; }

        img { display: block; max-width: 100%; }

        @keyframes pulseDot {
            0%, 100% { opacity: 1; }
            50%      { opacity: 0.25; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .dot-pulse { animation: none; }
        }

        /* ---------- Estruturais ---------- */

        .wrap { max-width: 1180px; margin: 0 auto; }
        .sec  { padding: 88px 24px; }

        .sec-alt { background: var(--bg-alt); border-top: 1px solid var(--divider); }

        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent-light);
            margin-bottom: 14px;
        }

        .h2 {
            font-size: clamp(28px, 3.4vw, 44px);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.08;
            text-wrap: balance;
        }

        .lede { color: var(--txt-3); font-size: 17px; line-height: 1.6; text-wrap: pretty; }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
        }

        .grid { display: grid; }

        /* ---------- Botões ---------- */

        .btn {
            display: inline-block;
            border-radius: 12px;
            font-weight: 700;
            transition: background-color .15s ease, border-color .15s ease, color .15s ease;
        }

        .btn-primary { background: var(--accent); color: #fff; }
        .btn-primary:hover { background: var(--accent-hover); color: #fff; }

        .btn-ghost {
            border: 1px solid rgba(255, 255, 255, 0.16);
            color: var(--txt);
            font-weight: 600;
        }
        .btn-ghost:hover { border-color: rgba(255, 255, 255, 0.4); color: #fff; }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(245, 48, 30, 0.45);
            color: var(--accent-light);
            border-radius: 999px;
            padding: 7px 15px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }
        .pill span.dot { width: 6px; height: 6px; border-radius: 50%; background: var(--accent); flex: none; }

        /* ---------- 1. Barra de urgência ---------- */

        .urgency {
            background: var(--accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            letter-spacing: 0.01em;
        }
        .urgency .dot-pulse {
            width: 7px; height: 7px; border-radius: 50%;
            background: #fff; flex: none;
            animation: pulseDot 1.6s infinite;
        }

        /* ---------- 2. Header sticky ---------- */

        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(14px);
            background: rgba(10, 10, 12, 0.82);
            border-bottom: 1px solid var(--divider);
        }
        .site-header > .wrap {
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .logo {
            display: flex;
            align-items: baseline;
            gap: 7px;
            font-weight: 800;
            font-size: 17px;
            letter-spacing: -0.02em;
            color: var(--txt);
        }
        .logo .accent { color: var(--accent); }
        .header-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--txt-muted);
        }
        .header-cta { font-size: 14px; padding: 11px 20px; border-radius: 10px; white-space: nowrap; }

        /* ---------- 3. Hero ---------- */

        .hero {
            position: relative;
            background: radial-gradient(1200px 600px at 78% 8%, #2A1B45 0%, rgba(10, 10, 12, 0) 62%), var(--bg);
            padding: 84px 24px 76px;
        }
        .hero > .wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 56px;
            align-items: center;
        }
        .hero h1 {
            font-size: clamp(38px, 5.4vw, 64px);
            line-height: 1.02;
            font-weight: 800;
            letter-spacing: -0.035em;
            margin: 26px 0 22px;
            text-wrap: balance;
        }
        .hero h1 .accent { color: var(--accent); }
        .hero .subhead {
            font-size: clamp(17px, 1.5vw, 20px);
            line-height: 1.55;
            color: var(--txt-2);
            margin-bottom: 34px;
            max-width: 560px;
            text-wrap: pretty;
        }
        .hero-ctas { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 28px; }
        .hero-ctas .btn-primary {
            font-size: 17px;
            padding: 18px 30px;
            box-shadow: 0 14px 34px rgba(245, 48, 30, 0.32);
        }
        .hero-ctas .btn-ghost { font-size: 17px; padding: 18px 28px; }

        .checks { display: flex; flex-wrap: wrap; gap: 12px 26px; font-size: 14px; color: var(--txt-3); }
        .checks span { display: flex; gap: 8px; align-items: center; }
        .checks b { color: var(--accent); font-weight: 800; }

        .hero-media { position: relative; }
        .hero-media .frame {
            position: relative;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
        }
        .hero-media img { width: 100%; height: 520px; object-fit: cover; object-position: 50% 58%; }
        .price-tag {
            position: absolute;
            bottom: -22px;
            left: -14px;
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 16px 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.55);
        }
        .price-tag .label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--txt-muted);
            margin-bottom: 6px;
        }
        .price-tag .value { font-size: 26px; font-weight: 800; letter-spacing: -0.02em; }
        .price-tag .value small { font-size: 13px; font-weight: 500; color: var(--txt-muted); }

        /* ---------- 4. Faixa de números ---------- */

        .stats {
            border-top: 1px solid var(--divider);
            border-bottom: 1px solid var(--divider);
            background: var(--bg-alt);
            padding: 34px 24px;
        }
        .stats > .wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 28px;
        }
        .stats .value { font-size: 30px; font-weight: 800; letter-spacing: -0.03em; }
        .stats .value.accent { color: var(--accent); }
        .stats .label { font-size: 13px; color: var(--txt-muted); margin-top: 4px; }

        /* ---------- 5. Prova visual ---------- */

        .proof-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 26px;
        }
        .proof-card { overflow: hidden; }
        .proof-card img { width: 100%; height: 300px; object-fit: cover; object-position: 50% 62%; }
        .proof-card .meta {
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }
        .proof-card .meta .name { font-weight: 700; }
        .proof-card .meta .detail {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            color: var(--txt-muted);
            text-align: right;
        }

        /* ---------- 6. O problema ---------- */

        .problem { background: var(--grad-sec); }
        .problem > .wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 48px;
            align-items: start;
        }
        .pain { display: grid; gap: 14px; }
        .pain > div {
            background: var(--surface);
            border: 1px solid var(--border);
            border-left: 3px solid var(--accent);
            border-radius: 14px;
            padding: 20px 22px;
        }
        .pain .title { font-weight: 700; margin-bottom: 6px; }
        .pain .body { color: var(--txt-muted); font-size: 14.5px; line-height: 1.55; }

        /* ---------- 7. Como funciona ---------- */

        #como-funciona { scroll-margin-top: 72px; }

        .steps { grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 22px; }
        .step {
            background: var(--grad-step);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px 26px;
        }
        .step .num {
            font-size: 44px;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: -0.04em;
            line-height: 1;
            margin-bottom: 18px;
        }
        .step .title { font-size: 19px; font-weight: 700; margin-bottom: 10px; }
        .step .body { color: var(--txt-3); font-size: 15px; line-height: 1.6; }

        /* ---------- 8. Vantagens ---------- */

        .benefits { grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 26px; }
        .benefits > .card { border-radius: 22px; padding: 32px 28px; }
        .benefits .head { display: flex; align-items: center; gap: 12px; margin-bottom: 26px; }
        .benefits .head .emoji { font-size: 26px; }
        .benefits .head .title { font-size: 19px; font-weight: 700; }
        .benefits .items { display: grid; gap: 20px; }
        .benefits .items .title { font-weight: 700; font-size: 15.5px; margin-bottom: 5px; }
        .benefits .items .body { color: var(--txt-muted); font-size: 14.5px; line-height: 1.55; }

        .benefits-cta { margin-top: 40px; display: flex; flex-wrap: wrap; gap: 16px; align-items: center; }
        .benefits-cta .btn-primary { font-size: 17px; padding: 17px 30px; }
        .benefits-cta .note { color: var(--txt-muted); font-size: 14px; }

        /* ---------- 9. Comparativo ---------- */

        .compare-wrap { max-width: 1000px; margin: 0 auto; }
        .compare { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; }
        .compare > div { border-radius: 20px; padding: 30px 26px; }
        .compare .lose {
            background: var(--surface-dim);
            border: 1px solid rgba(255, 255, 255, 0.08);
            opacity: 0.85;
        }
        .compare .win {
            background: var(--grad-hi);
            border: 1px solid var(--accent-brd);
            box-shadow: 0 24px 60px rgba(245, 48, 30, 0.12);
        }
        .compare .eyebrow { margin-bottom: 18px; }
        .compare .lose .eyebrow { color: var(--txt-muted); }
        .compare ul { list-style: none; margin: 0; padding: 0; display: grid; gap: 13px; font-size: 15px; }
        .compare li { display: flex; gap: 11px; }
        .compare .lose ul { color: var(--txt-3); }
        .compare .lose li b { color: var(--txt-faint); font-weight: 700; }
        .compare .win ul { color: var(--txt-hi); }
        .compare .win li b { color: var(--accent); font-weight: 800; }

        /* ---------- 11. O produto ---------- */

        .product { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 46px; align-items: start; }
        .process > div { display: flex; gap: 18px; padding: 22px 0; border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .process > div:first-child { padding-top: 0; }
        .process > div:last-child { padding-bottom: 0; border-bottom: 0; }
        .process .idx { font-family: 'IBM Plex Mono', monospace; font-size: 12px; color: var(--accent); padding-top: 3px; }
        .process .title { font-weight: 700; margin-bottom: 5px; }
        .process .body { color: var(--txt-muted); font-size: 14.5px; line-height: 1.55; }

        .specs { display: grid; gap: 14px; }
        .specs > div {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: baseline;
        }
        .specs .label { color: var(--txt-muted); font-size: 14px; flex: none; }
        .specs .value { font-weight: 700; text-align: right; }

        /* ---------- 12. Condições + garantias ---------- */

        .terms { background: var(--grad-sec); }
        .conditions { grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .conditions > div {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 26px 24px;
        }
        .conditions .title { font-size: 24px; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 8px; }
        .conditions .body { color: var(--txt-muted); font-size: 14.5px; line-height: 1.55; }
        .conditions .featured { background: var(--grad-hi); border-color: var(--accent-brd); }
        .conditions .featured .title { color: var(--accent-light); }
        .conditions .featured .body { color: var(--txt-hi-2); }

        .guarantees {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .guarantees > div {
            border: 1px dashed rgba(255, 255, 255, 0.16);
            border-radius: 18px;
            padding: 26px 24px;
        }
        .guarantees .eyebrow { margin-bottom: 12px; }
        .guarantees .title { font-weight: 700; margin-bottom: 6px; }
        .guarantees .body { color: var(--txt-muted); font-size: 14.5px; line-height: 1.55; }

        /* ---------- 13. Mitos ---------- */

        .myths { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .myths > div {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 26px 24px;
        }
        .myths .objection {
            color: var(--txt-muted);
            font-size: 14.5px;
            margin-bottom: 12px;
            text-decoration: line-through;
        }
        .myths .answer { font-weight: 700; font-size: 16px; line-height: 1.5; }

        /* ---------- 14. FAQ ---------- */

        .faq-wrap { max-width: 860px; margin: 0 auto; }
        .faq { display: grid; gap: 12px; }
        .faq details {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
        }
        .faq summary {
            list-style: none;
            font-size: 16.5px;
            font-weight: 600;
            text-align: left;
            padding: 22px 24px;
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: center;
            cursor: pointer;
        }
        .faq summary::-webkit-details-marker { display: none; }
        .faq summary::after {
            content: '+';
            color: var(--accent);
            font-size: 22px;
            font-weight: 700;
            flex: none;
            line-height: 1;
        }
        .faq details[open] summary::after { content: '−'; }
        .faq summary:focus-visible { outline: 2px solid var(--accent); outline-offset: -2px; }
        .faq .answer {
            padding: 0 24px 24px;
            color: var(--txt-3);
            font-size: 15.5px;
            line-height: 1.65;
            max-width: 680px;
        }

        /* ---------- 15. CTA final ---------- */

        .closing {
            padding: 96px 24px 110px;
            background: radial-gradient(900px 500px at 50% 0%, #2A1B45 0%, rgba(10, 10, 12, 0) 68%), var(--bg);
            text-align: center;
            border-top: 1px solid var(--divider);
        }
        .closing > div { max-width: 760px; margin: 0 auto; }
        .closing h2 {
            font-size: clamp(32px, 4.4vw, 54px);
            font-weight: 800;
            letter-spacing: -0.035em;
            line-height: 1.05;
            margin: 26px 0 20px;
            text-wrap: balance;
        }
        .closing p { color: var(--txt-2); font-size: 18px; line-height: 1.55; margin-bottom: 34px; }
        .closing .row { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; align-items: center; }
        .closing .btn-primary {
            font-size: 18px;
            padding: 19px 34px;
            box-shadow: 0 16px 40px rgba(245, 48, 30, 0.34);
        }
        .closing .phone { color: var(--txt-muted); font-size: 15px; font-family: 'IBM Plex Mono', monospace; }

        /* ---------- 16. Footer ---------- */

        .site-footer {
            border-top: 1px solid var(--divider);
            padding: 36px 24px 100px; /* padding-bottom extra reserva espaço para o CTA fixo mobile */
            background: var(--bg);
        }
        .site-footer > .wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: space-between;
            align-items: center;
            color: var(--txt-faint);
            font-size: 13px;
        }
        .site-footer .logo { font-size: 15px; gap: 6px; }

        /* ---------- 17. CTA fixo mobile (CSS puro, sem JS) ---------- */

        .mobile-cta { display: none; }

        @media (max-width: 759px) {
            .mobile-cta {
                display: block;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 60;
                padding: 12px 16px;
                background: rgba(10, 10, 12, 0.92);
                backdrop-filter: blur(14px);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }
            .mobile-cta .btn {
                display: block;
                text-align: center;
                font-size: 17px;
                padding: 16px;
            }
            /* O CTA do header vira redundante com a barra fixa */
            .header-label { display: none; }
        }
    </style>
</head>
<body>

@php
    $cfg = fn ($k, $d = null) => \App\Services\ConfiguracaoService::get($k, $d);

    // O WhatsApp é o único caminho de conversão da página: se a configuração
    // estiver vazia ou com placeholder (ex.: 5500000000000), cai no número do
    // handoff em vez de publicar 5 CTAs quebrados.
    $waConfigurado = preg_replace('/\D/', '', (string) $cfg('whatsapp_numero', ''));
    $waValido = preg_match('/^55\d{10,11}$/', $waConfigurado)
        && ! preg_match('/^(\d)\1+$/', substr($waConfigurado, 2));

    $waNumero = $waValido ? $waConfigurado : '5561994129384';
    $waMsg    = 'Olá! Tenho um pet shop e quero ser parceiro da Print Garage 3D nas miniaturas 3D de pets.';
    $waLink   = 'https://wa.me/' . $waNumero . '?text=' . rawurlencode($waMsg);

    // (61) 99412-9384 — derivado do número configurado, sem o DDI
    $waExibicao = preg_replace(
        '/^55(\d{2})(\d{4,5})(\d{4})$/',
        '($1) $2-$3',
        $waNumero
    );

    $faqs = [
        ['q' => 'Preciso ter equipe ou funcionário dedicado?',      'a' => 'Não. Quem já atende no balcão dá conta: mostrar a peça-amostra, pedir uma foto de corpo inteiro do pet e nos repassar o pedido. Leva menos tempo do que registrar uma venda de ração.'],
        ['q' => 'Preciso entender de impressão 3D?',                'a' => 'Nada. Modelagem, impressão, pintura à mão e embalagem são inteiramente nossos. Você nunca lida com arquivo, máquina ou tinta.'],
        ['q' => 'Como eu divulgo isso na minha loja?',              'a' => 'Com a peça-amostra no balcão, que puxa conversa sozinha, e com o kit de artes que enviamos todo mês para o Instagram e o WhatsApp da loja. Você só publica.'],
        ['q' => 'E se o cliente não gostar da peça?',               'a' => 'O risco é baixíssimo porque o tutor aprova a prévia do modelo 3D antes de imprimirmos. Se houver defeito de fabricação, pintura fora do combinado ou quebra no transporte, refazemos por nossa conta.'],
        ['q' => 'Quanto eu posso cobrar do tutor?',                 'a' => 'O preço final é decisão sua. Sugerimos R$ 250, o que deixa R$ 120 de margem por peça sobre o custo fixo de R$ 130 — mas você conhece seu público e pode praticar mais ou menos que isso.'],
        ['q' => 'Quanto tempo leva para a peça ficar pronta?',      'a' => 'De 10 a 15 dias úteis a partir da aprovação do modelo 3D. Entregamos direto na sua loja, no DF e entorno.'],
        ['q' => 'Preciso comprar alguma coisa para começar?',       'a' => 'Não. Sem taxa de adesão, sem mensalidade e sem pedido mínimo. Você paga somente as peças que já vendeu.'],
        ['q' => 'Quantos pet shops entram por região?',             'a' => 'Trabalhamos com exclusividade: um parceiro por bairro. Assim a novidade continua sendo diferencial da sua loja e não vira commodity na rua.'],
    ];
@endphp

{{-- ============ 1. Barra de urgência ============ --}}
{{-- TODO: confirmar com cliente — a regra "1 pet shop por bairro" e o número
     de vagas foram propostos pelo designer, não informados pelo cliente. --}}
<div class="urgency">
    <span class="dot-pulse" aria-hidden="true"></span>
    <span>Programa de parceiros 2026 — apenas 1 pet shop por bairro no DF. <strong style="font-weight: 800">6 vagas abertas.</strong></span>
</div>

{{-- ============ 2. Header sticky ============ --}}
<header class="site-header">
    <div class="wrap">
        <div class="logo"><span>PRINT</span><span class="accent">GARAGE 3D</span></div>
        <div style="display: flex; align-items: center; gap: 22px">
            <span class="header-label">Programa de parceiros</span>
            <a href="{{ $waLink }}" target="_blank" rel="noopener" data-cta="header" class="btn btn-primary header-cta">Quero ser parceiro</a>
        </div>
    </div>
</header>

{{-- ============ 3. Hero ============ --}}
<section class="hero">
    <div class="wrap">
        <div>
            <span class="pill"><span class="dot" aria-hidden="true"></span> Parceria B2B · DF e entorno</span>

            <h1>R$ 120 de lucro por peça,<br><span class="accent">sem estoque e sem risco.</span></h1>

            <p class="subhead">
                Sua loja vende miniaturas 3D personalizadas do pet do cliente. A gente produz cada peça só depois da venda
                fechada — você não compra nada antes, não guarda nada na prateleira e não toca em nenhuma etapa de produção.
            </p>

            <div class="hero-ctas">
                <a href="{{ $waLink }}" target="_blank" rel="noopener" data-cta="hero" class="btn btn-primary">Quero ser parceiro →</a>
                <a href="#como-funciona" class="btn btn-ghost">Ver como funciona</a>
            </div>

            <div class="checks">
                <span><b aria-hidden="true">✓</b> Estoque zero</span>
                <span><b aria-hidden="true">✓</b> Sem mensalidade</span>
                <span><b aria-hidden="true">✓</b> Você define o preço final</span>
            </div>
        </div>

        <div class="hero-media">
            <div class="frame">
                <picture>
                    <source srcset="{{ asset('assets/petshop/mini-bolt.webp') }}" type="image/webp">
                    <img src="{{ asset('assets/petshop/mini-bolt.jpg') }}" width="1200" height="675"
                         alt="Miniatura 3D pintada à mão de um cachorro shih tzu, com base preta e plaquinha com o nome Bolt">
                </picture>
            </div>
            <div class="price-tag">
                <div class="label">Custo do parceiro</div>
                <div class="value">R$ 130 <small>/ peça</small></div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 4. Faixa de números ============ --}}
<section class="stats">
    <div class="wrap">
        <div>
            <div class="value">R$ 130</div>
            <div class="label">Preço fixo de parceria por peça</div>
        </div>
        <div>
            <div class="value">R$ 250</div>
            <div class="label">Preço sugerido de venda ao tutor</div>
        </div>
        <div>
            <div class="value accent">R$ 120</div>
            <div class="label">Sua margem por peça vendida</div>
        </div>
        <div>
            <div class="value">10–15</div>
            <div class="label">Dias úteis de produção</div>
        </div>
    </div>
</section>

{{-- ============ 5. Prova visual ============ --}}
{{-- TODO: as fotos originais dos pets ainda não existem. O design previa cada
     card em 2 colunas (foto do tutor | miniatura). Enquanto não houver a foto
     original, publicamos o card de 1 coluna — só a miniatura — conforme o
     handoff. Ao receber as fotos, voltar ao grid de 2 colunas:
     grid-template-columns: minmax(0,1fr) minmax(0,1fr); gap: 2px;
     background: rgba(255,255,255,0.07)  (o gap cria a linha divisória). --}}
<section class="sec">
    <div class="wrap">
        <p class="eyebrow">Prova visual</p>
        <h2 class="h2" style="margin-bottom: 14px; max-width: 760px">Da foto no celular do tutor à peça pintada à mão.</h2>
        <p class="lede" style="max-width: 620px; margin-bottom: 44px">
            O tutor manda a foto. Nós modelamos, imprimimos, pintamos e embalamos. Sua loja só entrega.
        </p>

        <div class="grid proof-grid">
            <article class="card proof-card">
                <picture>
                    <source srcset="{{ asset('assets/petshop/mini-bolt-2.webp') }}" type="image/webp">
                    <img src="{{ asset('assets/petshop/mini-bolt-2.jpg') }}" width="800" height="450" loading="lazy"
                         alt="Miniatura 3D do cachorro Bolt, um shih tzu marrom, vista de frente">
                </picture>
                <div class="meta">
                    <span class="name">Bolt</span>
                    <span class="detail">Shih tzu · 12 cm</span>
                </div>
            </article>

            <article class="card proof-card">
                <picture>
                    <source srcset="{{ asset('assets/petshop/mini-pipoca.webp') }}" type="image/webp">
                    <img src="{{ asset('assets/petshop/mini-pipoca.jpg') }}" width="800" height="450" loading="lazy"
                         alt="Miniatura 3D da cachorra Pipoca, malhada preto e branco, vista de frente">
                </picture>
                <div class="meta">
                    <span class="name">Pipoca</span>
                    <span class="detail">Malhado preto e branco</span>
                </div>
            </article>

            <article class="card proof-card">
                <picture>
                    <source srcset="{{ asset('assets/petshop/mini-pipoca-2.webp') }}" type="image/webp">
                    <img src="{{ asset('assets/petshop/mini-pipoca-2.jpg') }}" width="800" height="450" loading="lazy"
                         alt="Miniatura 3D vista de perfil, mostrando a plaquinha com o nome do pet na base">
                </picture>
                <div class="meta">
                    <span class="name">Base com o nome</span>
                    <span class="detail">Plaquinha personalizada</span>
                </div>
            </article>
        </div>
    </div>
</section>

{{-- ============ 6. O problema ============ --}}
<section class="sec problem">
    <div class="wrap">
        <div>
            <p class="eyebrow">O problema</p>
            <h2 class="h2" style="margin-bottom: 20px">Todo pet shop do bairro vende exatamente a mesma coisa.</h2>
            <p class="lede">
                Ração, coleira, banho e tosa. Produtos que o cliente compara por preço, que o marketplace entrega mais
                barato e que exigem capital parado na prateleira para girar. A conta fecha cada vez mais apertada.
            </p>
        </div>

        <div class="pain">
            <div>
                <div class="title">Margem apertada no que gira</div>
                <div class="body">Ração e acessório rendem pouco por real investido e o cliente já sabe o preço de tabela antes de entrar na loja.</div>
            </div>
            <div>
                <div class="title">Capital preso em prateleira</div>
                <div class="body">Para oferecer novidade você precisa comprar lote, arriscar encalhe e depois queimar preço para virar caixa.</div>
            </div>
            <div>
                <div class="title">Nenhum motivo para escolher você</div>
                <div class="body">Sem produto exclusivo, a decisão do tutor volta a ser distância e desconto — e a fidelização nunca acontece.</div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 7. Como funciona ============ --}}
<section class="sec" id="como-funciona">
    <div class="wrap">
        <p class="eyebrow">Como funciona</p>
        <h2 class="h2" style="margin-bottom: 12px; max-width: 720px">Três passos. É literalmente todo o seu trabalho.</h2>
        <p class="lede" style="margin-bottom: 46px">Nenhuma etapa de produção fica com você.</p>

        <div class="grid steps">
            <div class="step">
                <div class="num">01</div>
                <div class="title">Apresente e feche a venda</div>
                <div class="body">A peça-amostra no balcão faz o trabalho de convencimento. Você define o preço e recebe do tutor.</div>
            </div>
            <div class="step">
                <div class="num">02</div>
                <div class="title">Repasse a foto do pet</div>
                <div class="body">Uma foto de corpo inteiro, com boa luz, enviada pelo WhatsApp. Pedido registrado na hora.</div>
            </div>
            <div class="step">
                <div class="num">03</div>
                <div class="title">Receba pronta e entregue</div>
                <div class="body">A miniatura chega pintada e embalada para presente. Você entrega e fica com a diferença.</div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 8. Vantagens ============ --}}
<section class="sec sec-alt">
    <div class="wrap">
        <h2 class="h2" style="margin-bottom: 46px; max-width: 700px">Por que essa parceria fecha a conta.</h2>

        <div class="grid benefits">
            <div class="card">
                <div class="head">
                    <span class="emoji" aria-hidden="true">💰</span>
                    <span class="title">Financeiro e operacional</span>
                </div>
                <div class="items">
                    <div>
                        <div class="title">Estoque zero</div>
                        <div class="body">Nada comprado antecipadamente, nada parado na prateleira. As vendas são 100% sob demanda.</div>
                    </div>
                    <div>
                        <div class="title">Margem de lucro livre</div>
                        <div class="body">A peça sai por um custo fixo de R$ 130. O preço final ao tutor é decisão sua — e a diferença é toda sua.</div>
                    </div>
                    <div>
                        <div class="title">Nenhum esforço de produção</div>
                        <div class="body">Modelagem, impressão, pintura detalhada à mão e embalagem ficam inteiramente com a Print Garage 3D.</div>
                    </div>
                    <div>
                        <div class="title">Logística simplificada</div>
                        <div class="body">Seu trabalho: captar a venda, receber a foto e repassar o pedido. Nada além disso.</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="head">
                    <span class="emoji" aria-hidden="true">🚀</span>
                    <span class="title">Estratégia e mercado</span>
                </div>
                <div class="items">
                    <div>
                        <div class="title">Alto valor agregado</div>
                        <div class="body">Produto exclusivo e emocional não é tratado como mercadoria comum — vende em preço premium sem comparação de tabela.</div>
                    </div>
                    <div>
                        <div class="title">Diferencial competitivo</div>
                        <div class="body">Oferecer eternização em 3D separa sua loja da concorrência que vende só ração e acessório.</div>
                    </div>
                    <div>
                        <div class="title">Fidelização do cliente</div>
                        <div class="body">Um item marcante cria memória afetiva e amarra o tutor ao seu estabelecimento, não ao preço.</div>
                    </div>
                    <div>
                        <div class="title">Atração de público</div>
                        <div class="body">Uma peça no balcão e nas redes da loja gera curiosidade, foto e conversa — e traz gente nova para dentro.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="benefits-cta">
            <a href="{{ $waLink }}" target="_blank" rel="noopener" data-cta="vantagens" class="btn btn-primary">Quero garantir a vaga do meu bairro →</a>
            <span class="note">Resposta no mesmo dia útil pelo WhatsApp.</span>
        </div>
    </div>
</section>

{{-- ============ 9. Comparativo ============ --}}
<section class="sec">
    <div class="compare-wrap">
        <h2 class="h2" style="margin-bottom: 40px; text-align: center">Dois jeitos de colocar um produto novo na loja.</h2>

        <div class="grid compare">
            <div class="lose">
                <p class="eyebrow">Modelo tradicional de estoque</p>
                <ul>
                    <li><b aria-hidden="true">✕</b> Compra de lote antecipada</li>
                    <li><b aria-hidden="true">✕</b> Capital parado em prateleira</li>
                    <li><b aria-hidden="true">✕</b> Risco de encalhe e queima de preço</li>
                    <li><b aria-hidden="true">✕</b> Preço de tabela comparável no marketplace</li>
                    <li><b aria-hidden="true">✕</b> Espaço físico ocupado</li>
                </ul>
            </div>
            <div class="win">
                <p class="eyebrow">Parceria sob encomenda</p>
                <ul>
                    <li><b aria-hidden="true">✓</b> R$ 0 de investimento inicial</li>
                    <li><b aria-hidden="true">✓</b> Produção só depois da venda fechada</li>
                    <li><b aria-hidden="true">✓</b> Risco de encalhe: zero</li>
                    <li><b aria-hidden="true">✓</b> Produto único, sem comparação de preço</li>
                    <li><b aria-hidden="true">✓</b> Uma peça-amostra no balcão e pronto</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{--
    ============ 10. Depoimentos — REMOVIDO INTENCIONALMENTE ============

    O handoff é explícito: todo o conteúdo desta seção era placeholder
    ("[Nome do lojista]", "[Nome do pet shop] · [Bairro]") e remover a seção é
    preferível a publicar texto falso.

    TODO: ao receber depoimentos reais (citação, nome, loja, bairro e, se
    possível, foto), reinserir a seção aqui — entre o comparativo e "O produto".
    Spec no README, seção 10: fundo #0D0D11, eyebrow "Lojas parceiras",
    H2 "Quem já está vendendo.", 3 cards minmax(280px,1fr), citação 16.5px/1.6
    em #E7E4EC, avatar circular 46×46 com a inicial em #FF7461.
--}}

{{-- ============ 11. O produto ============ --}}
<section class="sec">
    <div class="wrap">
        <p class="eyebrow">O produto</p>
        <h2 class="h2" style="margin-bottom: 46px; max-width: 700px">O que sai da nossa oficina e chega na sua loja.</h2>

        <div class="grid product">
            <div class="process">
                <div>
                    <span class="idx">01</span>
                    <div>
                        <div class="title">Modelagem 3D a partir da foto</div>
                        <div class="body">Escultura digital feita à mão respeitando cor, pelagem e proporção do pet.</div>
                    </div>
                </div>
                <div>
                    <span class="idx">02</span>
                    <div>
                        <div class="title">Aprovação antes de imprimir</div>
                        <div class="body">Você recebe a prévia do 3D e o tutor aprova. Só depois a peça entra na impressora.</div>
                    </div>
                </div>
                <div>
                    <span class="idx">03</span>
                    <div>
                        <div class="title">Impressão e acabamento</div>
                        <div class="body">Impressão de alta resolução, lixamento e preparo de superfície para a pintura.</div>
                    </div>
                </div>
                <div>
                    <span class="idx">04</span>
                    <div>
                        <div class="title">Pintura detalhada à mão</div>
                        <div class="body">Cada mancha, olho e nuance de pelo pintado manualmente e selado com verniz.</div>
                    </div>
                </div>
                <div>
                    <span class="idx">05</span>
                    <div>
                        <div class="title">Base, plaquinha e embalagem</div>
                        <div class="body">Base com o nome do pet e embalagem pronta para presente, sem custo extra.</div>
                    </div>
                </div>
            </div>

            <div class="specs">
                <div>
                    <span class="label">Prazo médio de produção</span>
                    <span class="value">10 a 15 dias úteis</span>
                </div>
                {{-- TODO: confirmar com cliente — altura da peça e descrição dos materiais. --}}
                <div>
                    <span class="label">Altura da peça</span>
                    <span class="value">≈ 12 cm com base</span>
                </div>
                <div>
                    <span class="label">Personalização</span>
                    <span class="value">Raça, pose, cor da pelagem e nome na base</span>
                </div>
                <div>
                    <span class="label">Entrega</span>
                    <span class="value">DF e entorno, direto na sua loja</span>
                </div>
                <div>
                    <span class="label">Materiais</span>
                    <span class="value">Impressão 3D + tinta acrílica e verniz</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 12. Condições da parceria + garantias ============ --}}
<section class="sec terms">
    <div class="wrap">
        <h2 class="h2" style="margin-bottom: 12px">Condições da parceria.</h2>
        <p class="lede" style="margin-bottom: 44px">Sem contrato de fidelidade, sem taxa de adesão.</p>

        <div class="grid conditions">
            <div>
                <div class="title">R$ 130</div>
                <div class="body">Preço fixo por peça, independente da raça ou do nível de detalhe.</div>
            </div>
            <div>
                <div class="title">Sem mensalidade</div>
                <div class="body">Você paga apenas as peças que vender. Nenhuma cobrança recorrente.</div>
            </div>
            <div>
                <div class="title">Sem pedido mínimo</div>
                <div class="body">Uma peça por mês ou trinta: a condição é a mesma.</div>
            </div>
            <div class="featured">
                <div class="title">Kit de divulgação</div>
                <div class="body">Fotos e artes prontas para o Instagram e o WhatsApp da loja, atualizadas todo mês.</div>
            </div>
        </div>

        <div class="grid guarantees">
            <div>
                <p class="eyebrow">Garantia 01</p>
                <div class="title">Reposição por defeito de fabricação</div>
                <div class="body">Peça com falha de impressão, pintura ou quebra no transporte é refeita por nossa conta. Você não perde a venda nem o cliente.</div>
            </div>
            <div>
                <p class="eyebrow">Garantia 02</p>
                <div class="title">Aprovação do 3D antes de imprimir</div>
                <div class="body">O tutor vê a prévia digital e pede ajustes antes da produção começar. A peça só é impressa depois do "pode ir".</div>
            </div>
        </div>
    </div>
</section>

{{-- ============ 13. Mitos / objeções ============ --}}
<section class="sec sec-alt">
    <div class="wrap">
        <h2 class="h2" style="margin-bottom: 40px; max-width: 680px">O que todo lojista pensa antes de dizer sim.</h2>

        <div class="grid myths">
            <div>
                <p class="objection">"Vou precisar montar uma equipe pra isso."</p>
                <p class="answer">Não. Quem já atende no balcão consegue vender: são três perguntas e uma foto.</p>
            </div>
            <div>
                <p class="objection">"Vou precisar entender de impressão 3D."</p>
                <p class="answer">Não. A parte técnica é 100% nossa. Você nunca vê uma impressora.</p>
            </div>
            <div>
                <p class="objection">"Vou precisar investir antes de faturar."</p>
                <p class="answer">Não. O tutor paga, você repassa o pedido, a peça é produzida. Caixa nunca fica negativo.</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ 14. FAQ ============ --}}
{{-- <details name="faq"> dá o comportamento "um aberto por vez" nativamente,
     sem JS. Onde o atributo name não for suportado, degrada para múltiplos
     abertos — aceitável. --}}
<section class="sec">
    <div class="faq-wrap">
        <h2 class="h2" style="margin-bottom: 40px">Perguntas frequentes.</h2>

        <div class="faq">
            @foreach($faqs as $i => $faq)
                <details name="faq" @if($i === 0) open @endif>
                    <summary>{{ $faq['q'] }}</summary>
                    <p class="answer">{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- ============ 15. CTA final ============ --}}
<section class="closing">
    <div>
        {{-- TODO: confirmar com cliente — número de vagas. --}}
        <span class="pill"><span class="dot" aria-hidden="true"></span> 6 vagas abertas no DF</span>

        <h2>Coloque uma peça no balcão e comece a vender esta semana.</h2>
        <p>Mande uma mensagem, diga em que bairro sua loja fica e a gente confirma se a vaga da região ainda está livre.</p>

        <div class="row">
            <a href="{{ $waLink }}" target="_blank" rel="noopener" data-cta="fechamento" class="btn btn-primary">Falar no WhatsApp agora</a>
            <span class="phone">{{ $waExibicao }}</span>
        </div>
    </div>
</section>

{{-- ============ 16. Footer ============ --}}
<footer class="site-footer">
    <div class="wrap">
        <div class="logo"><span>PRINT</span><span class="accent">GARAGE 3D</span></div>
        <div>Impressão 3D personalizada · Brasília–DF · Programa de parceiros para pet shops</div>
    </div>
</footer>

{{-- ============ 17. CTA fixo mobile ============ --}}
<div class="mobile-cta">
    <a href="{{ $waLink }}" target="_blank" rel="noopener" data-cta="mobile-fixo" class="btn btn-primary">Quero ser parceiro →</a>
</div>

{{-- Analytics: rastreia qual das 5 posições de CTA converte mais.
     Só dispara se já houver gtag ou dataLayer na página — no-op caso contrário.
     TODO: instalar GA4/Pixel para os eventos abaixo serem coletados. --}}
<script>
    document.querySelectorAll('a[data-cta]').forEach(function (el) {
        el.addEventListener('click', function () {
            var pos = el.dataset.cta;
            if (typeof window.gtag === 'function') {
                window.gtag('event', 'whatsapp_click', { cta_position: pos });
            } else if (Array.isArray(window.dataLayer)) {
                window.dataLayer.push({ event: 'whatsapp_click', cta_position: pos });
            }
        });
    });
</script>

</body>
</html>
