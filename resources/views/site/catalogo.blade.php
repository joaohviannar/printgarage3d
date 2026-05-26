@extends('layouts.site')

@section('title', 'Catálogo ' . ($tipo === 'B2C' ? 'Pessoal' : 'Empresarial') . ' | Print Garage 3D')

@section('content')
<section class="py-12 lg:py-20">
    <div class="container-x">

        {{-- Cabeçalho --}}
        <div class="text-center mb-12">
            <span class="{{ $tipo === 'B2C' ? 'badge-b2c' : 'badge-b2b' }} mb-4">
                {{ $tipo === 'B2C' ? 'Para Você' : 'Para Empresas' }}
            </span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                Catálogo {{ $tipo === 'B2C' ? 'Pessoal' : 'Empresarial' }}
            </h1>
            <p class="text-brand-silver-200 max-w-2xl mx-auto">
                {{ $tipo === 'B2C'
                    ? 'Peças personalizadas para você, sua casa e seu dia a dia.'
                    : 'Soluções 3D para empresas: brindes, identidade e diferenciais corporativos.' }}
            </p>
        </div>

        {{-- Toggle B2C / B2B --}}
        <div class="flex justify-center mb-8">
            <div class="inline-flex bg-brand-dark-soft rounded-lg p-1 border border-brand-silver-700/40">
                <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}"
                   class="px-6 py-2 rounded-md text-sm font-semibold uppercase tracking-wider transition-all
                          {{ $tipo === 'B2C' ? 'bg-brand-red text-white shadow-lg' : 'text-brand-silver-200 hover:text-white' }}">
                    Para Você
                </a>
                <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}"
                   class="px-6 py-2 rounded-md text-sm font-semibold uppercase tracking-wider transition-all
                          {{ $tipo === 'B2B' ? 'bg-brand-red text-white shadow-lg' : 'text-brand-silver-200 hover:text-white' }}">
                    Para Empresas
                </a>
            </div>
        </div>

        {{-- Filtro por categoria --}}
        @if($categorias->isNotEmpty())
            <div class="flex flex-wrap gap-2 justify-center mb-10">
                <a href="{{ route('site.catalogo', ['tipo' => $tipo]) }}"
                   class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all
                          {{ !$categoriaId ? 'bg-brand-red text-white' : 'bg-brand-dark-soft text-brand-silver-100 hover:bg-brand-silver-700' }}">
                    Todas
                </a>
                @foreach($categorias as $cat)
                    <a href="{{ route('site.catalogo', ['tipo' => $tipo, 'categoria' => $cat->id]) }}"
                       class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wider transition-all
                              {{ $categoriaId == $cat->id ? 'bg-brand-red text-white' : 'bg-brand-dark-soft text-brand-silver-100 hover:bg-brand-silver-700' }}">
                        {{ $cat->nome }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Grade de produtos --}}
        @if($produtos->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($produtos as $produto)
                    <a href="{{ route('site.produto', $produto->slug) }}" class="product-card group block">
                        <div class="relative aspect-square bg-brand-silver-900 overflow-hidden">
                            @if($produto->imagem_principal)
                                <img src="{{ asset('storage/' . $produto->imagem_principal) }}"
                                     alt="{{ $produto->nome }}"
                                     loading="lazy"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-brand-silver-500 text-6xl">
                                    📦
                                </div>
                            @endif
                            @if($produto->destaque)
                                <span class="absolute top-3 left-3 px-2 py-1 bg-brand-red text-white text-xs font-bold uppercase tracking-wider rounded">
                                    ⭐ Destaque
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="text-xs text-brand-silver-300 uppercase tracking-wider">
                                {{ $produto->categoria->nome }}
                            </span>
                            <h3 class="font-bold text-lg mt-1 mb-2 group-hover:text-brand-red-300 transition-colors line-clamp-2">
                                {{ $produto->nome }}
                            </h3>
                            <p class="text-2xl font-bold text-brand-red-300">
                                R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Paginação --}}
            <div class="mt-12">
                {{ $produtos->withQueryString()->links() }}
            </div>
        @else
            {{-- Estado vazio --}}
            <div class="text-center py-20 bg-brand-dark-soft rounded-2xl border border-brand-silver-700/40">
                <div class="text-6xl mb-4">🛠️</div>
                <h3 class="text-2xl font-bold mb-3">Em breve!</h3>
                <p class="text-brand-silver-200 mb-6 max-w-md mx-auto">
                    Ainda não temos produtos cadastrados nessa categoria. Mas você pode fazer um pedido personalizado pelo WhatsApp!
                </p>
                <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
                   target="_blank"
                   class="btn-whatsapp">
                    Fazer pedido personalizado
                </a>
            </div>
        @endif

        {{-- ============================================
             REPOSITÓRIOS 3D EXTERNOS
             ============================================ --}}
        <div class="mt-20 pt-12 border-t border-brand-silver-700/40 text-center">
            <h2 class="text-2xl lg:text-3xl font-bold mb-3">Não encontrou o que procura?</h2>
            <p class="text-brand-silver-200 max-w-2xl mx-auto mb-10">
                Entre nesses sites de modelos 3D, escolha o que mais gostar e nos mande o link do modelo pelo WhatsApp — a gente imprime pra você!
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 max-w-4xl mx-auto">
                @php
                    $repositorios = [
                        ['nome' => 'MakerWorld',     'url' => 'https://makerworld.com/',        'desc' => 'Biblioteca da Bambu Lab', 'logo' => 'assets/repos/makerworld.png'],
                        ['nome' => 'Printables',     'url' => 'https://www.printables.com/',    'desc' => 'Comunidade Prusa',        'logo' => 'assets/repos/printables.png'],
                        ['nome' => 'Creality Cloud', 'url' => 'https://www.crealitycloud.com/', 'desc' => 'Modelos da Creality',     'logo' => 'assets/repos/crealitycloud.png'],
                    ];
                @endphp

                @foreach($repositorios as $repo)
                    <a href="{{ $repo['url'] }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="group flex flex-col items-center gap-2 px-6 py-6 rounded-xl bg-brand-dark-soft border border-brand-silver-700/40
                              hover:border-brand-red hover:bg-brand-red-900/10 hover:-translate-y-1
                              transition-all duration-200">
                        <span class="flex items-center justify-center w-16 h-16 mb-1 rounded-xl bg-white p-2.5 transition-transform group-hover:scale-110">
                            <img src="{{ asset($repo['logo']) }}" alt="{{ $repo['nome'] }}" class="w-full h-full object-contain" loading="lazy">
                        </span>
                        <span class="font-bold text-base group-hover:text-brand-red-300 transition-colors">{{ $repo['nome'] }}</span>
                        <span class="text-xs text-brand-silver-300">{{ $repo['desc'] }}</span>
                        <span class="mt-2 inline-flex items-center gap-1 text-xs font-semibold uppercase tracking-wider text-brand-red-300 opacity-0 group-hover:opacity-100 transition-opacity">
                            Acessar
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
                   target="_blank"
                   rel="noopener"
                   class="btn-whatsapp">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/>
                    </svg>
                    Enviar link do modelo
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
