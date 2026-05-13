@extends('layouts.site')

@section('title', 'Print Garage 3D | Impressão 3D Personalizada')
@section('description', 'Transformamos suas ideias em peças 3D reais. Bonecos, suportes, peças personalizadas e soluções empresariais com qualidade e dedicação.')

@section('content')

{{-- ============================================
     HERO SECTION
     ============================================ --}}
<section class="relative overflow-hidden bg-brand-dark">
    {{-- Background decorativo --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 -left-20 w-96 h-96 bg-brand-red rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-brand-red-900 rounded-full blur-3xl"></div>
    </div>

    <div class="container-x relative py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Texto --}}
            <div>
                <span class="badge bg-brand-red/10 text-brand-red-300 border border-brand-red-700/40 mb-6">
                    🔥 Impressão 3D personalizada
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6">
                    Suas ideias,
                    <span class="block bg-gradient-to-r from-brand-red-400 to-brand-red-600 bg-clip-text text-transparent">
                        impressas em 3D.
                    </span>
                </h1>
                <p class="text-lg text-brand-silver-100 mb-8 max-w-xl leading-relaxed">
                    Bonecos, suportes, peças personalizadas e soluções empresariais.
                    Da concepção à entrega, cuidamos de cada detalhe com qualidade artesanal e tecnologia de ponta.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="btn-primary">
                        Ver Catálogo
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
                       target="_blank"
                       rel="noopener"
                       class="btn-whatsapp">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/>
                        </svg>
                        Falar no WhatsApp
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="mt-10 flex items-center gap-8 text-sm text-brand-silver-200">
                    <div class="flex items-center gap-2">
                        <span class="text-brand-red text-xl">✓</span>
                        Personalizado
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-brand-red text-xl">✓</span>
                        Qualidade
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-brand-red text-xl">✓</span>
                        Entrega Rápida
                    </div>
                </div>
            </div>

            {{-- Imagem / Logo destaque --}}
            <div class="relative">
                <div class="relative aspect-square max-w-md mx-auto">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-red/20 to-transparent rounded-3xl blur-2xl"></div>
                    <img src="{{ asset('assets/brand/logo/logo-principal.png') }}"
                         alt="Print Garage 3D"
                         class="relative w-full h-full object-contain drop-shadow-2xl">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================
     DUAS DIVISÕES: B2C E B2B
     ============================================ --}}
<section class="py-20 bg-brand-dark-soft">
    <div class="container-x">
        <div class="text-center mb-14">
            <h2 class="text-3xl lg:text-4xl font-bold mb-4">Pra quem é a Print Garage?</h2>
            <p class="text-brand-silver-200 max-w-2xl mx-auto">
                Atendemos pessoas físicas com peças únicas e empresas com soluções corporativas personalizadas.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            {{-- B2C --}}
            <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}"
               class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-red-900/40 to-brand-dark p-8 border border-brand-red-700/30 hover:border-brand-red transition-all hover:-translate-y-1">
                <span class="badge-b2c mb-4">B2C — Para Você</span>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-brand-red-300 transition-colors">
                    Peças Pessoais e Personalizadas
                </h3>
                <p class="text-brand-silver-200 mb-6">
                    Bonecos, action figures, suportes de capacete, itens decorativos, presentes únicos e peças do seu dia a dia.
                </p>
                <span class="inline-flex items-center gap-2 text-brand-red-300 font-semibold text-sm uppercase tracking-wider group-hover:gap-3 transition-all">
                    Explorar catálogo
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </span>
            </a>

            {{-- B2B --}}
            <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}"
               class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-silver-800 to-brand-dark p-8 border border-brand-silver-700/40 hover:border-brand-silver-200 transition-all hover:-translate-y-1">
                <span class="badge-b2b mb-4">B2B — Para Empresas</span>
                <h3 class="text-2xl font-bold mb-3 group-hover:text-brand-silver-50 transition-colors">
                    Soluções Empresariais
                </h3>
                <p class="text-brand-silver-200 mb-6">
                    Combos corporativos, logo 3D, placas Instagram, placas PIX, brindes personalizados e identidade visual física.
                </p>
                <span class="inline-flex items-center gap-2 text-brand-silver-100 font-semibold text-sm uppercase tracking-wider group-hover:gap-3 transition-all">
                    Ver soluções
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>

{{-- ============================================
     DIFERENCIAIS
     ============================================ --}}
<section id="sobre" class="py-20">
    <div class="container-x">
        <div class="text-center mb-14">
            <span class="badge bg-brand-red/10 text-brand-red-300 border border-brand-red-700/40 mb-4">Por que a Print Garage?</span>
            <h2 class="text-3xl lg:text-4xl font-bold">Da garagem para o seu projeto</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
                $diferenciais = [
                    ['icon' => '⚙️', 'titulo' => 'Tecnologia de Ponta', 'desc' => 'Impressoras 3D modernas e materiais premium para entregar peças com alta precisão e durabilidade.'],
                    ['icon' => '🎨', 'titulo' => 'Personalização Total', 'desc' => 'Cada peça é única. Adaptamos cores, tamanhos e detalhes conforme sua necessidade.'],
                    ['icon' => '🚀', 'titulo' => 'Entrega Ágil', 'desc' => 'Otimizamos o processo da modelagem à finalização para você receber o quanto antes.'],
                    ['icon' => '💬', 'titulo' => 'Atendimento Próximo', 'desc' => 'Conversamos por WhatsApp do briefing à entrega. Sem burocracia, com atenção.'],
                    ['icon' => '🏆', 'titulo' => 'Qualidade Garantida', 'desc' => 'Acabamento cuidadoso e revisão peça por peça antes da entrega.'],
                    ['icon' => '💰', 'titulo' => 'Preço Justo', 'desc' => 'Trabalho artesanal com valores que cabem no bolso, sem abrir mão da qualidade.'],
                ];
            @endphp

            @foreach($diferenciais as $d)
                <div class="bg-brand-dark-soft rounded-xl p-6 border border-brand-silver-700/40 hover:border-brand-red-700/60 transition-colors">
                    <div class="text-4xl mb-4">{{ $d['icon'] }}</div>
                    <h3 class="text-lg font-bold mb-2">{{ $d['titulo'] }}</h3>
                    <p class="text-sm text-brand-silver-200 leading-relaxed">{{ $d['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================
     CTA FINAL
     ============================================ --}}
<section class="py-20 bg-gradient-to-br from-brand-red-900/30 via-brand-dark to-brand-dark">
    <div class="container-x text-center">
        <h2 class="text-3xl lg:text-5xl font-bold mb-6">
            Pronto para criar algo único?
        </h2>
        <p class="text-lg text-brand-silver-100 mb-10 max-w-2xl mx-auto">
            Mande sua ideia pelo WhatsApp. A gente conversa, ajusta o projeto e dá vida à sua peça.
        </p>

        <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
           target="_blank"
           rel="noopener"
           class="btn-whatsapp !text-base !px-8 !py-4">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/>
            </svg>
            Começar pelo WhatsApp
        </a>
    </div>
</section>

@endsection
