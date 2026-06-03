@extends('layouts.site')

@section('title', 'Print Garage 3D | Impressão 3D Personalizada')
@section('description', 'Transformamos suas ideias em peças 3D reais. Bonecos, suportes, peças personalizadas e soluções empresariais em Brasília-DF.')

@section('content')

@php $waGeral = \App\Services\ConfiguracaoService::whatsappLink(); @endphp

{{-- ===================== HERO ===================== --}}
<section id="topo" class="relative overflow-hidden bg-grid pt-12 pb-16 sm:pt-20 sm:pb-24">
    {{-- brilhos ambiente --}}
    <div class="pointer-events-none absolute -top-24 right-[-10%] h-[520px] w-[520px] glow-red opacity-70"></div>
    <div class="pointer-events-none absolute bottom-[-20%] left-[-10%] h-[420px] w-[420px] glow-red opacity-40"></div>

    <div class="relative container-x">
        <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-10">

            {{-- Copy --}}
            <div class="order-2 lg:order-1 lg:col-span-7 text-center lg:text-left">
                <span class="inline-flex items-center gap-2 rounded-full border border-brand-lt/25 bg-brand/10 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-brand-lt">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-mid animate-pulse"></span>
                    IMPRESSÃO 3D PERSONALIZADA · BRASÍLIA-DF
                </span>

                <h1 class="font-head font-black tracking-tight text-silver mt-6 text-[2.6rem] leading-[1.02] sm:text-6xl lg:text-[4.5rem]">
                    Suas ideias,<br class="hidden sm:block" />
                    <span class="text-grad">impressas em 3D.</span>
                </h1>

                <p class="mx-auto lg:mx-0 mt-6 max-w-xl text-lg text-silver-2 leading-relaxed">
                    Bonecos, suportes e peças personalizadas — da concepção à entrega, com acabamento artesanal e tecnologia de ponta.
                </p>

                <div class="mt-9 flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-3.5">
                    <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}"
                       class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand px-7 py-4 text-base font-bold text-silver shadow-red-lg hover:bg-brand-hi transition min-h-[52px]">
                        Ver Catálogo
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <a href="{{ $waGeral }}" target="_blank" rel="noopener"
                       class="inline-flex items-center justify-center gap-2.5 rounded-2xl border border-wa/40 bg-wa/10 px-7 py-4 text-base font-bold text-wa hover:bg-wa hover:text-[#06250f] transition min-h-[52px]">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zM6.597 20.13c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 0 0 1.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413z"/></svg>
                        Falar no WhatsApp
                    </a>
                </div>

                <ul class="mt-9 flex flex-wrap items-center justify-center lg:justify-start gap-x-7 gap-y-2.5 text-sm text-silver-2">
                    <li class="inline-flex items-center gap-2"><svg viewBox="0 0 24 24" class="h-4 w-4 text-brand-lt" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m5 13 4 4L19 7"/></svg>100% Personalizado</li>
                    <li class="inline-flex items-center gap-2"><svg viewBox="0 0 24 24" class="h-4 w-4 text-brand-lt" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m5 13 4 4L19 7"/></svg>Qualidade artesanal</li>
                    <li class="inline-flex items-center gap-2"><svg viewBox="0 0 24 24" class="h-4 w-4 text-brand-lt" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m5 13 4 4L19 7"/></svg>Entrega rápida</li>
                </ul>
            </div>

            {{-- Showcase: logo da marca --}}
            <div class="order-1 lg:order-2 lg:col-span-5">
                <div class="relative mx-auto max-w-md">
                    <div class="absolute -inset-4 glow-red opacity-60 blur-2xl"></div>
                    <div class="relative rounded-[20px] border border-white/10 aspect-square grid place-items-center shadow-red-lg overflow-hidden bg-surface/40">
                        <img src="{{ asset('assets/brand/logo/logo-principal.png') }}"
                             alt="Print Garage 3D"
                             class="w-4/5 h-4/5 object-contain drop-shadow-2xl">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ===================== DUAS PORTAS B2C / B2B ===================== --}}
<section id="portas" class="relative py-16 sm:py-24">
    <div class="container-x">
        <div class="max-w-2xl">
            <p class="font-head text-xs font-bold uppercase tracking-[0.18em] text-brand-lt">Pra quem é a Print Garage?</p>
            <h2 class="font-head font-extrabold text-silver mt-3 text-3xl sm:text-4xl tracking-tight">Escolha sua porta de entrada.</h2>
            <p class="mt-4 text-silver-2 text-lg">Atendemos pessoas com peças únicas e empresas com soluções corporativas sob medida.</p>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            {{-- B2C --}}
            <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="lift group relative flex flex-col rounded-3xl border border-white/10 bg-surface p-7 sm:p-9 overflow-hidden">
                <div class="pointer-events-none absolute -top-16 -right-16 h-48 w-48 glow-red opacity-0 group-hover:opacity-60 transition-opacity duration-500"></div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-brand-lt/25 bg-brand/10 px-3 py-1 text-xs font-bold tracking-wide text-brand-lt">B2C · PARA VOCÊ</span>
                <h3 class="font-head font-extrabold text-2xl sm:text-[1.7rem] tracking-tight text-silver mt-5">Peças pessoais e personalizadas</h3>
                <p class="mt-3 text-silver-2 leading-relaxed">Bonecos, action figures, suportes de capacete, itens decorativos, presentes únicos e peças do seu dia a dia.</p>
                <div class="mt-7 flex flex-wrap gap-2">
                    <span class="rounded-lg bg-white/5 px-3 py-1.5 text-xs text-silver-2">Action figures</span>
                    <span class="rounded-lg bg-white/5 px-3 py-1.5 text-xs text-silver-2">Decoração</span>
                    <span class="rounded-lg bg-white/5 px-3 py-1.5 text-xs text-silver-2">Presentes</span>
                </div>
                <span class="mt-8 inline-flex items-center gap-2 font-semibold text-silver group-hover:text-brand-lt transition">
                    Explorar catálogo
                    <svg viewBox="0 0 24 24" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </span>
            </a>

            {{-- B2B --}}
            <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}" class="lift group relative flex flex-col rounded-3xl border border-brand/30 bg-gradient-to-br from-brand/15 to-surface p-7 sm:p-9 overflow-hidden">
                <div class="pointer-events-none absolute -top-16 -right-16 h-48 w-48 glow-red opacity-50 group-hover:opacity-80 transition-opacity duration-500"></div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-brand px-3 py-1 text-xs font-bold tracking-wide text-silver shadow-red-sm">B2B · PARA EMPRESAS</span>
                <h3 class="font-head font-extrabold text-2xl sm:text-[1.7rem] tracking-tight text-silver mt-5">Soluções empresariais</h3>
                <p class="mt-3 text-silver-2 leading-relaxed">Combos corporativos, logo 3D, placas de Instagram, placas PIX, brindes personalizados e identidade visual física.</p>
                <div class="mt-7 flex flex-wrap gap-2">
                    <span class="rounded-lg bg-white/8 px-3 py-1.5 text-xs text-silver">Logo 3D</span>
                    <span class="rounded-lg bg-white/8 px-3 py-1.5 text-xs text-silver">Placas PIX</span>
                    <span class="rounded-lg bg-white/8 px-3 py-1.5 text-xs text-silver">Brindes</span>
                </div>
                <span class="mt-8 inline-flex items-center gap-2 font-semibold text-brand-lt">
                    Ver soluções
                    <svg viewBox="0 0 24 24" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </span>
            </a>
        </div>
    </div>
</section>

{{-- ===================== PRODUTOS EM DESTAQUE ===================== --}}
@if(isset($destaques) && $destaques->isNotEmpty())
<section id="produtos" x-data="carrossel()" class="relative py-16 sm:py-24 border-y border-white/5 bg-surface/30">
    <div class="container-x">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-5">
            <div class="max-w-2xl">
                <p class="font-head text-xs font-bold uppercase tracking-[0.18em] text-brand-lt">⭐ Em destaque</p>
                <h2 class="font-head font-extrabold text-silver mt-3 text-3xl sm:text-4xl tracking-tight">Confira nossos produtos</h2>
            </div>
            <div class="flex items-center gap-3">
                {{-- Setas do carrossel (desktop) — só aparecem quando há produtos suficientes pra rolar --}}
                <div x-show="scrollable" x-cloak class="hidden sm:flex items-center gap-2">
                    <button type="button" @click="prev()"
                            class="grid place-items-center h-11 w-11 rounded-full border border-white/10 text-silver hover:bg-white/5 hover:border-brand-lt/40 transition"
                            aria-label="Anterior">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button type="button" @click="next()"
                            class="grid place-items-center h-11 w-11 rounded-full border border-white/10 text-silver hover:bg-white/5 hover:border-brand-lt/40 transition"
                            aria-label="Próximo">
                        <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
                <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="inline-flex w-fit items-center gap-2 rounded-xl border border-white/10 px-5 py-3 text-sm font-semibold text-silver hover:border-brand-lt/40 hover:bg-white/5 transition min-h-[44px]">
                    Ver catálogo completo
                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Trilho do carrossel infinito: peek (metade dos vizinhos) + swipe no mobile --}}
        @php
            $temPeek = $destaques->count() > 1;
            $repeticoes = $temPeek ? 3 : 1; // 3x para o loop infinito (clone | reais | clone)
        @endphp
        <div x-ref="track" @scroll="aoRolar()"
             class="mt-12 flex gap-4 sm:gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar pb-2">

            @for($c = 0; $c < $repeticoes; $c++)
            @foreach($destaques as $produto)
                <a data-slide href="{{ route('site.produto', $produto->slug) }}"
                   @if($temPeek && $c !== 1) aria-hidden="true" tabindex="-1" @endif
                   class="snap-center shrink-0 {{ $temPeek ? 'w-1/2' : 'w-full max-w-md mx-auto' }} lift group rounded-3xl border border-white/10 bg-surface overflow-hidden block">
                    <div class="relative aspect-[4/3] overflow-hidden {{ $produto->imagem_principal ? '' : 'ph grid place-items-center' }}">
                        @if($produto->imagem_principal)
                            <img src="{{ asset('storage/' . $produto->imagem_principal) }}"
                                 alt="{{ $produto->nome }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <span class="ph-label text-xs uppercase text-silver-2/50">foto do produto</span>
                        @endif
                        <span class="absolute top-3 left-3 rounded-lg bg-ink/70 px-2.5 py-1 text-[11px] font-semibold text-brand-lt backdrop-blur">{{ $produto->categoria->nome }}</span>
                    </div>
                    <div class="p-6">
                        <h3 class="font-head font-extrabold text-lg tracking-tight text-silver line-clamp-1">{{ $produto->nome }}</h3>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="font-head font-extrabold text-xl text-silver">
                                R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-lt group-hover:gap-2.5 transition-all">Detalhes <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
                        </div>
                    </div>
                </a>
            @endforeach
            @endfor
        </div>
    </div>
</section>
@endif

{{-- ===================== DIFERENCIAIS ===================== --}}
<section id="sobre" class="relative py-16 sm:py-24 scroll-mt-20">
    <div class="container-x">
        <div class="max-w-2xl">
            <p class="font-head text-xs font-bold uppercase tracking-[0.18em] text-brand-lt">Por que a Print Garage?</p>
            <h2 class="font-head font-extrabold text-silver mt-3 text-3xl sm:text-4xl tracking-tight">Da garagem para o seu projeto.</h2>
        </div>

        <div class="mt-12 grid gap-px overflow-hidden rounded-3xl border border-white/10 bg-white/8 sm:grid-cols-2 lg:grid-cols-3">
            {{-- 1 Tecnologia --}}
            <div class="group bg-surface p-7 sm:p-8 transition-colors hover:bg-surface-2">
                <span class="grid h-12 w-12 place-items-center rounded-xl border border-brand-lt/20 bg-brand/10 text-brand-lt transition group-hover:scale-105">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 14h3M1 9h3M1 14h3"/></svg>
                </span>
                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver mt-5">Tecnologia de Ponta</h3>
                <p class="mt-2 text-silver-2 leading-relaxed">Impressoras 3D modernas e materiais premium para peças com alta precisão e durabilidade.</p>
            </div>

            {{-- 2 Personalização --}}
            <div class="group bg-surface p-7 sm:p-8 transition-colors hover:bg-surface-2">
                <span class="grid h-12 w-12 place-items-center rounded-xl border border-brand-lt/20 bg-brand/10 text-brand-lt transition group-hover:scale-105">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
                </span>
                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver mt-5">Personalização Total</h3>
                <p class="mt-2 text-silver-2 leading-relaxed">Cada peça é única. Adaptamos cores, tamanhos e detalhes conforme a sua necessidade.</p>
            </div>

            {{-- 3 Entrega --}}
            <div class="group bg-surface p-7 sm:p-8 transition-colors hover:bg-surface-2">
                <span class="grid h-12 w-12 place-items-center rounded-xl border border-brand-lt/20 bg-brand/10 text-brand-lt transition group-hover:scale-105">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>
                </span>
                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver mt-5">Entrega Ágil</h3>
                <p class="mt-2 text-silver-2 leading-relaxed">Otimizamos o processo da modelagem à finalização para você receber o quanto antes.</p>
            </div>

            {{-- 4 WhatsApp --}}
            <div class="group bg-surface p-7 sm:p-8 transition-colors hover:bg-surface-2">
                <span class="grid h-12 w-12 place-items-center rounded-xl border border-brand-lt/20 bg-brand/10 text-brand-lt transition group-hover:scale-105">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </span>
                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver mt-5">Atendimento WhatsApp</h3>
                <p class="mt-2 text-silver-2 leading-relaxed">Conversamos do briefing à entrega. Sem burocracia, com atenção de verdade.</p>
            </div>

            {{-- 5 Qualidade --}}
            <div class="group bg-surface p-7 sm:p-8 transition-colors hover:bg-surface-2">
                <span class="grid h-12 w-12 place-items-center rounded-xl border border-brand-lt/20 bg-brand/10 text-brand-lt transition group-hover:scale-105">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>
                </span>
                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver mt-5">Qualidade Garantida</h3>
                <p class="mt-2 text-silver-2 leading-relaxed">Acabamento cuidadoso e revisão peça por peça antes de chegar até você.</p>
            </div>

            {{-- 6 Preço --}}
            <div class="group bg-surface p-7 sm:p-8 transition-colors hover:bg-surface-2">
                <span class="grid h-12 w-12 place-items-center rounded-xl border border-brand-lt/20 bg-brand/10 text-brand-lt transition group-hover:scale-105">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.59 13.41 13.42 20.6a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </span>
                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver mt-5">Preço Justo</h3>
                <p class="mt-2 text-silver-2 leading-relaxed">Trabalho artesanal com valores que cabem no bolso, sem abrir mão da qualidade.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===================== CTA FINAL ===================== --}}
<section class="relative container-x pb-16 sm:pb-24">
    <div class="relative mx-auto overflow-hidden rounded-[28px] border border-brand/30 bg-gradient-to-br from-brand-hi via-brand to-[#3a0908] px-6 py-16 sm:px-16 sm:py-20 shadow-red-lg">
        <div class="pointer-events-none absolute inset-0 bg-grid opacity-30"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-12 h-72 w-72 rounded-full bg-black/30 blur-3xl"></div>
        <div class="relative max-w-3xl">
            <h2 class="font-head font-black text-silver tracking-tight text-3xl sm:text-5xl leading-[1.05]">Pronto para criar algo único?</h2>
            <p class="mt-5 text-lg text-silver/90 max-w-xl">Mande sua ideia pelo WhatsApp. A gente conversa, ajusta o projeto e dá vida à sua peça.</p>
            <a href="{{ $waGeral }}" target="_blank" rel="noopener"
               class="mt-9 inline-flex items-center justify-center gap-2.5 rounded-2xl bg-wa px-8 py-4 text-base font-bold text-[#06250f] shadow-wa hover:bg-wa-hi transition min-h-[52px]">
                <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zM6.597 20.13c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 0 0 1.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413z"/></svg>
                Começar pelo WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
