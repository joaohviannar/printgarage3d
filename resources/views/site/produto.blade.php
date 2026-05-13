@extends('layouts.site')

@section('title', $produto->nome . ' | Print Garage 3D')
@section('description', $produto->descricao_curta ?: \Illuminate\Support\Str::limit(strip_tags($produto->descricao), 160))
@section('og_image', $produto->imagem_principal ? asset('storage/' . $produto->imagem_principal) : asset('assets/brand/logo/logo-principal.png'))

@section('content')

<section class="py-10 lg:py-16">
    <div class="container-x">

        {{-- Breadcrumb --}}
        <nav class="mb-8 text-sm text-brand-silver-300">
            <a href="{{ route('site.home') }}" class="hover:text-brand-red-300">Início</a>
            <span class="mx-2">›</span>
            <a href="{{ route('site.catalogo', ['tipo' => $produto->categoria->tipo]) }}" class="hover:text-brand-red-300">
                Catálogo {{ $produto->categoria->tipo === 'B2C' ? 'Pessoal' : 'Empresarial' }}
            </a>
            <span class="mx-2">›</span>
            <span class="text-brand-silver-100">{{ $produto->nome }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16">

            {{-- Galeria de imagens --}}
            <div x-data="{ ativa: '{{ $produto->imagem_principal ? asset('storage/' . $produto->imagem_principal) : '' }}' }">
                <div class="aspect-square bg-brand-dark-soft rounded-2xl overflow-hidden border border-brand-silver-700/40">
                    @if($produto->imagem_principal)
                        <img :src="ativa" alt="{{ $produto->nome }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-brand-silver-500 text-8xl">
                            📦
                        </div>
                    @endif
                </div>

                @if($produto->imagens->isNotEmpty())
                    <div class="grid grid-cols-5 gap-2 mt-4">
                        @if($produto->imagem_principal)
                            <button @click="ativa = '{{ asset('storage/' . $produto->imagem_principal) }}'"
                                    class="aspect-square rounded-lg overflow-hidden border-2 border-brand-red">
                                <img src="{{ asset('storage/' . $produto->imagem_principal) }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endif
                        @foreach($produto->imagens as $img)
                            <button @click="ativa = '{{ asset('storage/' . $img->caminho) }}'"
                                    class="aspect-square rounded-lg overflow-hidden border border-brand-silver-700 hover:border-brand-red">
                                <img src="{{ asset('storage/' . $img->caminho) }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Detalhes do produto --}}
            <div>
                <span class="{{ $produto->categoria->tipo === 'B2C' ? 'badge-b2c' : 'badge-b2b' }} mb-3 inline-block">
                    {{ $produto->categoria->nome }}
                </span>

                <h1 class="text-3xl lg:text-4xl font-bold mb-4">{{ $produto->nome }}</h1>

                @if($produto->descricao_curta)
                    <p class="text-lg text-brand-silver-100 mb-6">{{ $produto->descricao_curta }}</p>
                @endif

                <div class="bg-brand-dark-soft rounded-xl p-6 mb-6 border border-brand-silver-700/40">
                    <span class="text-sm text-brand-silver-200 uppercase tracking-wider">Preço</span>
                    <p class="text-4xl font-black text-brand-red-300 mt-1">
                        R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mb-8">
                    <a href="{{ \App\Services\ConfiguracaoService::whatsappLink($produto->nome) }}"
                       target="_blank"
                       rel="noopener"
                       class="btn-whatsapp flex-1">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/>
                        </svg>
                        Comprar pelo WhatsApp
                    </a>
                </div>

                {{-- Descrição completa --}}
                @if($produto->descricao)
                    <div class="prose prose-invert max-w-none">
                        <h3 class="text-lg font-bold mb-3 text-brand-silver-50">Descrição</h3>
                        <div class="text-brand-silver-100 leading-relaxed whitespace-pre-line">
                            {{ $produto->descricao }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Produtos relacionados --}}
        @if($relacionados->isNotEmpty())
            <div class="mt-20">
                <h2 class="text-2xl font-bold mb-6">Você também pode gostar</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($relacionados as $rel)
                        <a href="{{ route('site.produto', $rel->slug) }}" class="product-card group block">
                            <div class="aspect-square bg-brand-silver-900 overflow-hidden">
                                @if($rel->imagem_principal)
                                    <img src="{{ asset('storage/' . $rel->imagem_principal) }}"
                                         alt="{{ $rel->nome }}"
                                         loading="lazy"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-brand-silver-500 text-4xl">📦</div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-semibold text-sm group-hover:text-brand-red-300 line-clamp-2">{{ $rel->nome }}</h3>
                                <p class="text-brand-red-300 font-bold mt-1">R$ {{ number_format($rel->preco_venda, 2, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection
