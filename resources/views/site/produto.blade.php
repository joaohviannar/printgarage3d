@extends('layouts.site')

@section('title', $produto->nome . ' | Print Garage 3D')
@section('description', $produto->descricao_curta ?: \Illuminate\Support\Str::limit(strip_tags($produto->descricao), 160))
@section('og_image', $produto->imagem_principal ? asset('storage/' . $produto->imagem_principal) : asset('assets/brand/logo/logo-principal.png'))

@section('content')

<section class="relative bg-grid py-10 sm:py-16">
    <div class="pointer-events-none absolute -top-24 right-[-10%] h-[420px] w-[420px] glow-red opacity-30"></div>

    <div class="relative container-x">

        {{-- Breadcrumb --}}
        <nav class="mb-8 text-sm text-silver-2">
            <a href="{{ route('site.home') }}" class="hover:text-brand-lt transition">Início</a>
            <span class="mx-2 text-silver-2/50">›</span>
            <a href="{{ route('site.catalogo', ['tipo' => $produto->categoria->tipo]) }}" class="hover:text-brand-lt transition">
                Catálogo {{ $produto->categoria->tipo === 'B2C' ? 'Pessoal' : 'Empresarial' }}
            </a>
            <span class="mx-2 text-silver-2/50">›</span>
            <span class="text-silver">{{ $produto->nome }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">

            {{-- Galeria: foto principal + extras + vídeo no mesmo seletor --}}
            @php
                $imgPrincipal = $produto->imagem_principal ? asset('storage/' . $produto->imagem_principal) : '';
                $videoUrl = $produto->video ? asset('storage/' . $produto->video) : '';
            @endphp
            <div x-data="{
                    tipo: 'imagem',
                    src: '{{ $imgPrincipal }}',
                    ver(t, s) {
                        this.tipo = t;
                        this.src = s;
                        if (t !== 'video' && this.$refs.player) this.$refs.player.pause();
                    }
                 }">

                {{-- Visualizador principal --}}
                <div class="relative aspect-square rounded-3xl overflow-hidden border border-white/10 shadow-red-lg {{ $imgPrincipal ? 'bg-surface' : 'ph grid place-items-center' }}">
                    @if($imgPrincipal)
                        <img x-show="tipo === 'imagem'" :src="src" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                    @else
                        <div x-show="tipo === 'imagem'" class="text-8xl text-silver-2/40">📦</div>
                    @endif

                    @if($videoUrl)
                        <video x-show="tipo === 'video'" x-cloak x-ref="player"
                               :src="src" controls preload="metadata" playsinline
                               @if($imgPrincipal) poster="{{ $imgPrincipal }}" @endif
                               class="absolute inset-0 w-full h-full object-contain bg-black">
                            Seu navegador não suporta reprodução de vídeo.
                        </video>
                    @endif
                </div>

                {{-- Miniaturas --}}
                @if($produto->imagens->isNotEmpty() || $videoUrl)
                    <div class="grid grid-cols-5 gap-2.5 mt-4">
                        @if($imgPrincipal)
                            <button type="button" @click="ver('imagem', '{{ $imgPrincipal }}')"
                                    :class="tipo === 'imagem' && src === '{{ $imgPrincipal }}' ? 'border-brand' : 'border-white/10 hover:border-brand-lt'"
                                    class="aspect-square rounded-xl overflow-hidden border-2 transition">
                                <img src="{{ $imgPrincipal }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endif

                        @foreach($produto->imagens as $img)
                            @php $imgUrl = asset('storage/' . $img->caminho); @endphp
                            <button type="button" @click="ver('imagem', '{{ $imgUrl }}')"
                                    :class="tipo === 'imagem' && src === '{{ $imgUrl }}' ? 'border-brand' : 'border-white/10 hover:border-brand-lt'"
                                    class="aspect-square rounded-xl overflow-hidden border-2 transition">
                                <img src="{{ $imgUrl }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach

                        {{-- Miniatura do vídeo --}}
                        @if($videoUrl)
                            <button type="button" @click="ver('video', '{{ $videoUrl }}')"
                                    :class="tipo === 'video' ? 'border-brand' : 'border-white/10 hover:border-brand-lt'"
                                    class="relative aspect-square rounded-xl overflow-hidden border-2 transition bg-black grid place-items-center"
                                    aria-label="Ver vídeo do produto">
                                @if($imgPrincipal)
                                    <img src="{{ $imgPrincipal }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-40">
                                @endif
                                <svg class="relative h-7 w-7 text-silver drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Detalhes do produto --}}
            <div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-brand-lt/25 bg-brand/10 px-3 py-1 text-xs font-bold tracking-wide text-brand-lt mb-4">
                    {{ $produto->categoria->nome }}
                </span>

                <h1 class="font-head font-extrabold tracking-tight text-silver text-3xl lg:text-4xl mb-4">{{ $produto->nome }}</h1>

                @if($produto->descricao_curta)
                    <p class="text-lg text-silver-2 leading-relaxed mb-6">{{ $produto->descricao_curta }}</p>
                @endif

                <div class="rounded-3xl border border-white/10 bg-surface p-6 mb-6">
                    <span class="ph-label text-xs text-silver-2/60 uppercase tracking-wider">Preço</span>
                    <p class="font-head font-black text-grad text-4xl mt-1 w-fit">
                        R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mb-8">
                    <a href="{{ \App\Services\ConfiguracaoService::whatsappLink($produto->nome) }}"
                       target="_blank" rel="noopener"
                       class="flex-1 inline-flex items-center justify-center gap-2.5 rounded-2xl bg-wa px-7 py-4 text-base font-bold text-[#06250f] shadow-wa hover:bg-wa-hi transition min-h-[52px]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/>
                        </svg>
                        Comprar pelo WhatsApp
                    </a>
                </div>

                {{-- Descrição completa --}}
                @if($produto->descricao)
                    <div class="rounded-3xl border border-white/10 bg-surface/50 p-6">
                        <h3 class="font-head font-extrabold text-lg text-silver mb-3">Descrição</h3>
                        <div class="text-silver-2 leading-relaxed whitespace-pre-line">
                            {{ $produto->descricao }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Produtos relacionados --}}
        @if($relacionados->isNotEmpty())
            <div class="mt-20">
                <h2 class="font-head font-extrabold text-silver text-2xl sm:text-3xl tracking-tight mb-6">Você também pode gostar</h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relacionados as $rel)
                        <a href="{{ route('site.produto', $rel->slug) }}" class="lift group rounded-3xl border border-white/10 bg-surface overflow-hidden block">
                            <div class="relative aspect-[4/3] overflow-hidden {{ $rel->imagem_principal ? '' : 'ph grid place-items-center' }}">
                                @if($rel->imagem_principal)
                                    <img src="{{ asset('storage/' . $rel->imagem_principal) }}"
                                         alt="{{ $rel->nome }}"
                                         loading="lazy"
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <span class="ph-label text-xs uppercase text-silver-2/50">foto do produto</span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="font-head font-extrabold text-sm tracking-tight text-silver line-clamp-1 group-hover:text-brand-lt transition-colors">{{ $rel->nome }}</h3>
                                <p class="font-head font-extrabold text-silver mt-1.5">R$ {{ number_format($rel->preco_venda, 2, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection
