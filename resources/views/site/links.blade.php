{{--
    Link na bio — página pública usada na bio do Instagram.
    Implementação do handoff "design_handoff_link_in_bio", tela 01.

    Os botões são gerenciados no Filament (Catálogo → Links da Bio).
    Página standalone: paleta e tipografia próprias do design.
--}}
@php
    $perfil = [
        'nome'    => \App\Services\ConfiguracaoService::get('empresa_nome', 'Print Garage 3D'),
        'eyebrow' => 'Impressão 3D personalizada<br>· Brasília-DF ·',
        'tagline' => 'Suas ideias, impressas em 3D. Da garagem para o seu projeto.',
    ];
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $perfil['nome'] }} · Links</title>
    <meta name="description" content="Fale com a Print Garage 3D no WhatsApp, veja os catálogos para pessoas e empresas ou conheça as parcerias. Impressão 3D personalizada em Brasília-DF.">
    <meta name="theme-color" content="#0E0E10">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:title" content="{{ $perfil['nome'] }}">
    <meta property="og:description" content="Suas ideias, impressas em 3D. Da garagem para o seu projeto.">
    <meta property="og:image" content="{{ asset('assets/brand/logo/icone.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand:       #8E1512;
            --brand-txt:   #D9645F;
            --brand-icon:  #F0A9A6;
            --bg:          #0E0E10;
            --txt:         #F7F5F1;
            --txt-2:       rgba(242, 239, 234, 0.62);
            --txt-3:       rgba(242, 239, 234, 0.4);
            --txt-4:       rgba(242, 239, 234, 0.34);
            --border:      rgba(242, 239, 234, 0.13);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body { margin: 0; padding: 0; }

        body {
            position: relative;
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            flex-direction: column;
            /* Textura de camadas de impressão 3D */
            background-color: var(--bg);
            background-image: repeating-linear-gradient(180deg, rgba(255,255,255,0.028) 0 1px, transparent 1px 5px);
            color: var(--txt);
            font-family: Archivo, Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Glow vermelho no topo */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(120% 60% at 50% -10%, rgba(142, 21, 18, 0.42), transparent 62%);
            pointer-events: none;
            z-index: 0;
        }

        /* Em telas maiores, a coluna vira uma faixa central de 440px */
        .shell {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            margin: 0 auto;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        :focus-visible { outline: 2px solid var(--brand-icon); outline-offset: 2px; }

        /* ---------- Header ---------- */

        .profile {
            padding: 32px 26px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-align: center;
        }
        .avatar {
            width: 104px;
            height: 104px;
            border-radius: 50%;
            padding: 4px;
            background: var(--bg);
            border: 2px solid var(--brand);
            box-shadow: 0 0 0 6px rgba(142, 21, 18, 0.12), 0 0 28px rgba(142, 21, 18, 0.35);
        }
        .avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            display: block;
        }
        .eyebrow {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--brand-txt);
            max-width: 260px;
            line-height: 1.6;
        }
        .name {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--txt);
        }
        .tagline {
            font-size: 15px;
            line-height: 1.5;
            color: var(--txt-2);
            max-width: 250px;
            text-wrap: pretty;
        }

        /* ---------- Botões ---------- */

        .links {
            padding: 24px 22px 0;
            display: flex;
            flex-direction: column;
            gap: 9px;
        }
        .link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 11px 16px;
            border-radius: 14px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.035);
            color: inherit;
            text-decoration: none;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease, background .18s ease;
        }
        .link:hover,
        .link:active {
            border-color: var(--brand);
            background: rgba(142, 21, 18, 0.16);
            box-shadow: 0 0 0 1px rgba(142, 21, 18, 0.5), 0 0 22px rgba(142, 21, 18, 0.35);
            transform: translateY(-1px);
        }
        /* Tile do ícone: plataformas externas usam a cor da própria marca;
           links do site usam o vermelho da Print Garage 3D. */
        .link .icon {
            width: 40px;
            height: 40px;
            flex: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            /* padrão = links internos */
            background: rgba(142, 21, 18, 0.22);
            border: 1px solid rgba(142, 21, 18, 0.55);
            color: var(--brand-icon);
        }
        .link .icon svg { width: 22px; height: 22px; display: block; }

        .link .icon--wa {
            background: #25D366;
            border-color: #25D366;
            color: #fff;
        }
        .link .icon--ig {
            background: linear-gradient(45deg, #FEDA75 0%, #FA7E1E 25%, #D62976 50%, #962FBF 75%, #4F5BD5 100%);
            border-color: transparent;
            color: #fff;
        }
        .link .icon--tiktok {
            background: #111111;
            border-color: rgba(242, 239, 234, 0.22);
            color: #fff;
        }
        .link .icon--pix {
            background: #32BCAD;
            border-color: #32BCAD;
            color: #fff;
        }
        .link .text { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
        .link .label { font-size: 15px; font-weight: 600; color: var(--txt); }
        .link .hint {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: var(--txt-3);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .link .chevron { font-size: 16px; color: rgba(242, 239, 234, 0.35); flex: none; }

        .vazio {
            padding: 40px 22px;
            text-align: center;
            color: var(--txt-3);
            font-size: 14px;
        }

        /* ---------- Footer ---------- */

        .rodape {
            margin-top: auto;
            padding: 20px 22px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }
        .rodape .divisor { width: 46px; height: 1px; background: rgba(242, 239, 234, 0.14); }
        .rodape .copy {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            letter-spacing: 0.12em;
            color: var(--txt-4);
        }

        @media (prefers-reduced-motion: reduce) {
            .link { transition: none; }
            .link:hover, .link:active { transform: none; }
        }
    </style>
</head>
<body>

<div class="shell">

    <header class="profile">
        <div class="avatar">
            <img src="{{ asset('assets/brand/logo/icone.png') }}" alt="{{ $perfil['nome'] }}" width="104" height="104">
        </div>
        <p class="eyebrow">{!! $perfil['eyebrow'] !!}</p>
        <h1 class="name">{{ $perfil['nome'] }}</h1>
        <p class="tagline">{{ $perfil['tagline'] }}</p>
    </header>

    <nav class="links">
        @forelse($links as $link)
            <a href="{{ $link->url }}"
               class="link"
               data-link-id="{{ $link->id }}"
               @if($link->isExterno()) target="_blank" rel="noopener" @endif>
                @include('site.partials.link-icone', ['icone' => $link->icone])
                <span class="text">
                    <span class="label">{{ $link->label }}</span>
                    @if($link->hint)
                        <span class="hint">{{ $link->hint }}</span>
                    @endif
                </span>
                <span class="chevron" aria-hidden="true">›</span>
            </a>
        @empty
            <p class="vazio">Nenhum link publicado ainda.</p>
        @endforelse
    </nav>

    <footer class="rodape">
        <div class="divisor"></div>
        <p class="copy">© {{ date('Y') }} {{ mb_strtoupper($perfil['nome']) }}</p>
    </footer>

</div>

<script>
    // Contagem de cliques "fire-and-forget": o sendBeacon não bloqueia a
    // navegação, então o botão continua respondendo na hora.
    (function () {
        var token = @json(csrf_token());
        var base = @json(url('/links'));

        document.querySelectorAll('.link[data-link-id]').forEach(function (el) {
            el.addEventListener('click', function () {
                if (!navigator.sendBeacon) return;
                var dados = new FormData();
                dados.append('_token', token);
                navigator.sendBeacon(base + '/' + el.dataset.linkId + '/clique', dados);
            });
        });
    })();
</script>

</body>
</html>
