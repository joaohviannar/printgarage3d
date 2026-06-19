<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Página exclusiva por link: não indexar --}}
    <meta name="robots" content="noindex, nofollow">

    <title>PrintGarage3D · Catálogo Exclusivo para Barbearias</title>
    <meta name="description" content="Peças 3D personalizadas com a logo, as cores e o formato da sua barbearia. Suportes, organizadores, letreiros e bandejas premium sob medida.">
    <meta name="theme-color" content="#0a0a0a">

    {{-- Open Graph (preview ao enviar no WhatsApp) --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Exclusividade em Cada Detalhe · PrintGarage3D">
    <meta property="og:description" content="Catálogo de peças 3D personalizadas para elevar o nível da sua barbearia.">
    <meta property="og:image" content="{{ asset('assets/brand/logo/logo-principal.png') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Fontes: Playfair Display (serif premium) + Inter (corpo) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;0,800;1,500&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])

    @php
        $cfg = fn($k, $d = null) => \App\Services\ConfiguracaoService::get($k, $d);
        $waNumero = preg_replace('/\D/', '', $cfg('whatsapp_numero', '5561994129384'));
        $waMsg = 'Olá! Sou de uma barbearia e quero um orçamento de peças 3D personalizadas com a minha logomarca.';
        $waLink = 'https://wa.me/' . $waNumero . '?text=' . rawurlencode($waMsg);

        $produtos = [
            [
                'nome' => 'Placas com QR Code Personalizadas',
                'desc' => 'Placas de mesa para avaliações no Google, WiFi, PIX e redes sociais — com a sua logo e as suas cores. Mais avaliações, mais clientes encontrando você.',
                'preco' => '49,90',
                'img' => 'produto-1.jpg',
                'featured' => true,
                'icone' => '<rect x="4" y="4" width="7" height="7" rx="1"/><rect x="13" y="4" width="7" height="7" rx="1"/><rect x="4" y="13" width="7" height="7" rx="1"/><path d="M13 13h3v3m-3 4h7v-7"/>',
            ],
            [
                'nome' => 'Logo 3D Decorativa',
                'desc' => 'Sua logomarca em três dimensões, em camadas e cores fiéis à sua identidade. O letreiro que vira o ponto focal do ambiente.',
                'preco' => '150,00',
                'img' => 'produto-2.jpg',
                'featured' => false,
                'icone' => '<path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="m2 17 10 5 10-5M2 12l10 5 10-5"/>',
            ],
            [
                'nome' => 'Estátua Premium de Bancada',
                'desc' => 'Peça escultural que celebra a arte da barbearia. Acabamento sofisticado que impressiona quem entra e valoriza o seu espaço.',
                'preco' => '220,00',
                'img' => 'produto-3.jpg',
                'featured' => false,
                'tag' => false,
                'icone' => '<path d="M12 2a3 3 0 0 0-3 3v6a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"/><path d="M5 11a7 7 0 0 0 14 0M12 18v4m-4 0h8"/>',
            ],
            [
                'nome' => 'Porta-Cartão Tesoura',
                'desc' => 'Seus cartões de visita expostos com estilo, numa tesoura de barbeiro estilizada. Praticidade que vira decoração no balcão.',
                'preco' => '75,00',
                'img' => 'produto-4.jpg',
                'featured' => false,
                'tag' => false,
                'icone' => '<circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M20 4 8.12 15.88M14.47 14.48 20 20M8.12 8.12 12 12"/>',
            ],
            [
                'nome' => 'Porta-Cartão Barber (Caveira)',
                'desc' => 'Porta-cartões temático com caveira barbuda, tesoura e poste de barbearia. Personalidade forte pra marcar presença na recepção.',
                'preco' => '95,00',
                'img' => 'produto-5.jpg',
                'featured' => false,
                'tag' => false,
                'icone' => '<path d="M12 2a8 8 0 0 0-8 8v4a3 3 0 0 0 3 3v3h10v-3a3 3 0 0 0 3-3v-4a8 8 0 0 0-8-8Z"/><path d="M9 12h.01M15 12h.01M10 18h4"/>',
            ],
            [
                'nome' => 'Organizador de Bancada',
                'desc' => 'Espaço sob medida para tesouras, pentes e produtos, com divisórias e furos. Bancada impecável e atendimento mais ágil — com a sua marca em relevo.',
                'preco' => '89,90',
                'img' => 'produto-6.jpg',
                'featured' => false,
                'icone' => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 4v5m4-5v5m4-5v5"/>',
            ],
            [
                'nome' => 'Suporte Inclinado para Pentes',
                'desc' => 'Pentes e acessórios sempre à mão, organizados num display inclinado e elegante. Praticidade que valoriza a sua estação de trabalho.',
                'preco' => '79,90',
                'img' => 'produto-7.jpg',
                'featured' => false,
                'icone' => '<path d="M4 8h16v4H4z"/><path d="M6 12v4m3-4v4m3-4v4m3-4v4M4 8l2-3h12l2 3"/>',
            ],
            [
                'nome' => 'Placa de Parede "Barber Shop"',
                'desc' => 'Letreiro de parede vazado com tesouras, pentes e navalhas. Personalize com o nome da sua barbearia e transforme a parede em identidade.',
                'preco' => '130,00',
                'img' => 'produto-8.jpg',
                'featured' => false,
                'icone' => '<path d="M3 9l9-6 9 6v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9Z"/><path d="M9 22V12h6v10"/>',
            ],
        ];
    @endphp
</head>
<body class="font-body bg-ink text-silver-2 antialiased selection:bg-gold/30 selection:text-silver">

    {{-- ===================== TOPO / MARCA ===================== --}}
    <div class="border-b border-white/5">
        <div class="max-w-6xl mx-auto px-5 sm:px-8 h-14 flex items-center">
            <span class="text-xs sm:text-sm font-semibold tracking-[0.25em] text-gold uppercase">
                PrintGarage3D <span class="text-silver-2/40">//</span> B2B
            </span>
        </div>
    </div>

    {{-- ===================== HERO ===================== --}}
    <section class="relative overflow-hidden bg-grid">
        <div class="pointer-events-none absolute -top-32 right-[-15%] h-[560px] w-[560px] glow-gold opacity-80"></div>
        <div class="pointer-events-none absolute bottom-[-30%] left-[-15%] h-[420px] w-[420px] glow-gold opacity-50"></div>

        <div class="relative max-w-6xl mx-auto px-5 sm:px-8 py-20 sm:py-28 text-center">
            <span class="inline-flex items-center gap-2 rounded-full border border-gold/30 bg-gold/5 px-4 py-1.5 text-[11px] sm:text-xs font-semibold tracking-[0.18em] uppercase text-gold">
                <span class="h-1.5 w-1.5 rounded-full bg-gold animate-pulse"></span>
                Catálogo Exclusivo · Barbearias
            </span>

            <h1 class="mt-7 text-4xl sm:text-6xl lg:text-7xl leading-[1.05] text-silver"
                style="font-family: var(--font-serif); font-weight: 700;">
                Exclusividade em<br class="hidden sm:block">
                <span class="text-gold-grad italic">Cada Detalhe.</span>
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-base sm:text-lg leading-relaxed text-silver-2">
                Catálogo de peças 3D personalizadas para elevar o nível da sua barbearia.
                Tudo feito sob medida — com a <span class="text-gold">sua marca</span>.
            </p>

            <div class="mx-auto mt-8 h-px w-24 bg-gradient-to-r from-transparent via-gold to-transparent"></div>

            <div class="mt-9">
                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2.5 rounded-full bg-gold px-7 py-3.5 text-sm font-bold uppercase tracking-wide text-ink hover:bg-gold-light transition min-h-[48px]">
                    Quero a minha barbearia única
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ===================== O PODER DA PERSONALIZAÇÃO ===================== --}}
    <section class="relative py-16 sm:py-24 border-y border-white/5 bg-surface/30">
        <div class="max-w-6xl mx-auto px-5 sm:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-gold">O Poder da Personalização</p>
                <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl leading-tight text-silver"
                    style="font-family: var(--font-serif); font-weight: 700;">
                    Não vendemos produtos de prateleira.<br class="hidden sm:block">
                    <span class="text-gold-grad">Vendemos a sua marca.</span>
                </h2>
                <p class="mt-5 text-base sm:text-lg text-silver-2 leading-relaxed">
                    Cada peça nasce do zero, pensada para a identidade da sua barbearia. Você não recebe "mais um produto" — você recebe a sua marca transformada em objeto físico.
                </p>
            </div>

            <div class="mt-14 grid gap-6 md:grid-cols-3">
                @php
                    $pilares = [
                        [
                            'titulo' => 'Sua Logo em Alto-Relevo',
                            'desc' => 'Imprimimos a logomarca da sua barbearia em três dimensões, com profundidade e acabamento que se sentem no toque.',
                            'icone' => '<path d="M12 2 2 7l10 5 10-5-10-5Z"/><path d="m2 17 10 5 10-5M2 12l10 5 10-5"/>',
                        ],
                        [
                            'titulo' => 'Nas Suas Cores',
                            'desc' => 'Reproduzimos a paleta da sua identidade visual. A peça conversa com a sua fachada, o seu site e as suas redes.',
                            'icone' => '<circle cx="13.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="10.5" r="2.5"/><circle cx="8.5" cy="7.5" r="2.5"/><circle cx="6.5" cy="12.5" r="2.5"/><path d="M12 2a10 10 0 0 0 0 20c1.1 0 2-.9 2-2 0-.5-.2-1-.5-1.3-.3-.4-.5-.8-.5-1.2 0-1.1.9-2 2-2h2.3A4.2 4.2 0 0 0 22 11c0-5-4.5-9-10-9Z"/>',
                        ],
                        [
                            'titulo' => 'Sob Medida pro seu Setup',
                            'desc' => 'Adaptamos o design às máquinas, tesouras e navalhas que você usa. Encaixe perfeito, nada genérico.',
                            'icone' => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76Z"/>',
                        ],
                    ];
                @endphp

                @foreach($pilares as $p)
                    <div class="lift rounded-3xl border border-white/10 bg-surface p-7 hover:border-gold/40">
                        <span class="grid h-12 w-12 place-items-center rounded-xl border border-gold/25 bg-gold/10 text-gold">
                            <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">{!! $p['icone'] !!}</svg>
                        </span>
                        <h3 class="mt-5 text-xl text-silver" style="font-family: var(--font-serif); font-weight: 600;">{{ $p['titulo'] }}</h3>
                        <p class="mt-2 text-silver-2 leading-relaxed">{{ $p['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== CATÁLOGO ===================== --}}
    <section class="py-16 sm:py-24">
        <div class="max-w-6xl mx-auto px-5 sm:px-8">
            <div class="max-w-2xl mb-12 text-center mx-auto">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-gold">A Coleção</p>
                <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl text-silver" style="font-family: var(--font-serif); font-weight: 700;">
                    Peças sob medida para a sua barbearia
                </h2>
                <p class="mt-4 text-silver-2 text-base sm:text-lg">
                    Exemplos da nossa linha — todos personalizáveis com a sua logo, suas cores e o seu formato.
                </p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                @foreach($produtos as $produto)
                    @php $temFoto = isset($produto['img']) && file_exists(public_path('assets/barbearia/' . $produto['img'])); @endphp
                    <article class="lift group rounded-3xl border border-white/10 bg-surface overflow-hidden hover:border-gold/40 {{ ($produto['featured'] ?? false) ? 'sm:col-span-2' : '' }}">
                        {{-- Imagem do produto --}}
                        <div class="relative grid place-items-center overflow-hidden {{ ($produto['featured'] ?? false) ? 'aspect-[16/9] sm:aspect-[21/8]' : 'aspect-[16/10]' }} {{ $temFoto ? 'bg-ink' : 'ph-gold' }}">
                            @if($temFoto)
                                <img src="{{ asset('assets/barbearia/' . $produto['img']) }}"
                                     alt="{{ $produto['nome'] }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <svg viewBox="0 0 24 24" class="h-16 w-16 text-gold/40 transition-transform duration-500 group-hover:scale-110" fill="none" stroke="currentColor" stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round">{!! $produto['icone'] !!}</svg>
                            @endif
                            {{-- Tag personalizável --}}
                            @if($produto['tag'] ?? true)
                                <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 rounded-full bg-gold px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-ink shadow-lg">
                                    <svg viewBox="0 0 24 24" class="h-3 w-3" fill="currentColor"><path d="m12 2 2.4 7.4H22l-6 4.5 2.3 7.1L12 16.7 5.7 21l2.3-7.1-6-4.5h7.6L12 2Z"/></svg>
                                    100% Personalizável
                                </span>
                            @endif
                        </div>
                        {{-- Corpo --}}
                        <div class="p-6 sm:p-7">
                            <h3 class="text-xl sm:text-2xl text-silver" style="font-family: var(--font-serif); font-weight: 600;">{{ $produto['nome'] }}</h3>
                            <p class="mt-2.5 text-silver-2 leading-relaxed">{{ $produto['desc'] }}</p>
                            <div class="mt-5 flex items-end justify-between gap-4">
                                <div>
                                    <span class="block text-[11px] uppercase tracking-wider text-silver-2/60">A partir de</span>
                                    <span class="text-2xl font-bold text-gold-grad" style="font-family: var(--font-head);">R$ {{ $produto['preco'] }}</span>
                                </div>
                                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1.5 rounded-xl border border-gold/30 px-4 py-2.5 text-sm font-semibold text-gold hover:bg-gold hover:text-ink transition">
                                    Personalizar
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <p class="mt-8 text-center text-sm text-silver-2/60">
                Estes são apenas exemplos. Tem uma ideia diferente? A gente cria do zero pra você.
            </p>
        </div>
    </section>

    {{-- ===================== CTA FINAL ===================== --}}
    <section class="px-5 sm:px-8 pb-16 sm:pb-24">
        <div class="relative max-w-6xl mx-auto overflow-hidden rounded-[28px] border border-gold/25 px-6 py-16 sm:px-16 sm:py-20 text-center"
             style="background: radial-gradient(120% 140% at 50% 0%, rgba(212,175,55,0.14), transparent 60%), #141310;">
            <div class="pointer-events-none absolute inset-0 bg-grid opacity-20"></div>

            <div class="relative">
                <h2 class="text-3xl sm:text-5xl leading-tight text-silver" style="font-family: var(--font-serif); font-weight: 700;">
                    Pronto para ter a sua<br class="hidden sm:block">
                    <span class="text-gold-grad italic">barbearia única?</span>
                </h2>
                <p class="mx-auto mt-5 max-w-xl text-base sm:text-lg text-silver-2">
                    Envie a sua logo pelo WhatsApp e receba um orçamento personalizado. Sem compromisso, com atenção de verdade.
                </p>

                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                   class="mt-9 inline-flex items-center justify-center gap-3 rounded-2xl bg-wa px-8 py-4 text-base font-bold text-[#06250f] shadow-wa hover:bg-wa-hi transition min-h-[56px]">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zM6.597 20.13c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 0 0 1.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413z"/></svg>
                    Solicitar Orçamento com Minha Logo
                </a>

                <p class="mt-5 text-sm text-silver-2/60">Resposta rápida · Atendimento direto com a PrintGarage3D</p>
            </div>
        </div>
    </section>

    {{-- ===================== RODAPÉ ===================== --}}
    <footer class="border-t border-white/5">
        <div class="max-w-6xl mx-auto px-5 sm:px-8 py-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-silver-2/60">
            <span class="font-semibold tracking-[0.2em] text-gold uppercase text-xs">PrintGarage3D <span class="text-silver-2/40">//</span> B2B</span>
            <span>Impressão 3D personalizada · Brasília-DF · {{ $cfg('instagram_handle', '@printgarage_3d') }}</span>
        </div>
    </footer>

</body>
</html>
