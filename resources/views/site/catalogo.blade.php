@extends('layouts.site')

@section('title', 'Catálogo ' . ($tipo === 'B2C' ? 'Pessoal' : 'Empresarial') . ' | Print Garage 3D')

@section('content')
<section class="relative bg-grid py-12 sm:py-20">
    <div class="pointer-events-none absolute -top-24 right-[-10%] h-[420px] w-[420px] glow-red opacity-40"></div>

    <div class="relative container-x">

        {{-- Cabeçalho --}}
        <div class="text-center max-w-2xl mx-auto mb-10">
            <p class="font-head text-xs font-bold uppercase tracking-[0.18em] text-brand-lt">
                {{ $tipo === 'B2C' ? 'B2C · Para Você' : 'B2B · Para Empresas' }}
            </p>
            <h1 class="font-head font-extrabold text-silver mt-3 text-3xl sm:text-4xl lg:text-5xl tracking-tight">
                Catálogo {{ $tipo === 'B2C' ? 'Pessoal' : 'Empresarial' }}
            </h1>
            <p class="mt-4 text-silver-2 text-lg">
                {{ $tipo === 'B2C'
                    ? 'Peças personalizadas para você, sua casa e seu dia a dia.'
                    : 'Soluções 3D para empresas: brindes, identidade e diferenciais corporativos.' }}
            </p>
        </div>

        {{-- Toggle B2C / B2B --}}
        <div class="flex justify-center mb-8">
            <div class="inline-flex rounded-2xl border border-white/10 bg-surface p-1">
                <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}"
                   class="px-6 py-2.5 rounded-xl text-sm font-semibold transition
                          {{ $tipo === 'B2C' ? 'bg-brand text-silver shadow-red-sm' : 'text-silver-2 hover:text-silver' }}">
                    Para Você
                </a>
                <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}"
                   class="px-6 py-2.5 rounded-xl text-sm font-semibold transition
                          {{ $tipo === 'B2B' ? 'bg-brand text-silver shadow-red-sm' : 'text-silver-2 hover:text-silver' }}">
                    Para Empresas
                </a>
            </div>
        </div>

        {{-- Filtro por categoria --}}
        @if($categorias->isNotEmpty())
            <div class="flex flex-wrap gap-2 justify-center mb-12">
                <a href="{{ route('site.catalogo', ['tipo' => $tipo]) }}"
                   class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wide transition
                          {{ !$categoriaId ? 'bg-brand text-silver' : 'border border-white/10 text-silver-2 hover:text-silver hover:bg-white/5' }}">
                    Todas
                </a>
                @foreach($categorias as $cat)
                    <a href="{{ route('site.catalogo', ['tipo' => $tipo, 'categoria' => $cat->id]) }}"
                       class="px-4 py-2 rounded-full text-xs font-semibold uppercase tracking-wide transition
                              {{ $categoriaId == $cat->id ? 'bg-brand text-silver' : 'border border-white/10 text-silver-2 hover:text-silver hover:bg-white/5' }}">
                        {{ $cat->nome }}
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Grade de produtos --}}
        @if($produtos->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($produtos as $produto)
                    <a href="{{ route('site.produto', $produto->slug) }}" class="lift group rounded-3xl border border-white/10 bg-surface overflow-hidden block">
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
                            @if($produto->destaque)
                                <span class="absolute top-3 right-3 rounded-lg bg-brand px-2.5 py-1 text-[11px] font-bold text-silver shadow-red-sm">⭐ Destaque</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-head font-extrabold text-lg tracking-tight text-silver line-clamp-1">{{ $produto->nome }}</h3>
                            <div class="mt-4 flex items-center justify-between">
                                <p class="font-head font-extrabold text-xl text-silver">
                                    R$ {{ number_format($produto->preco_venda, 2, ',', '.') }}
                                </p>
                                <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-lt group-hover:gap-2.5 transition-all">
                                    Detalhes
                                    <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </span>
                            </div>
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
            <div class="text-center py-20 rounded-3xl border border-white/10 bg-surface">
                <div class="text-6xl mb-4">🛠️</div>
                <h3 class="font-head font-extrabold text-2xl text-silver mb-3">Em breve!</h3>
                <p class="text-silver-2 mb-6 max-w-md mx-auto">
                    Ainda não temos produtos cadastrados nessa categoria. Mas você pode fazer um pedido personalizado pelo WhatsApp!
                </p>
                <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2 rounded-2xl bg-wa px-6 py-3.5 text-sm font-bold text-[#06250f] shadow-wa hover:bg-wa-hi transition min-h-[48px]">
                    Fazer pedido personalizado
                </a>
            </div>
        @endif

        {{-- ============================================
             REPOSITÓRIOS 3D EXTERNOS
             ============================================ --}}
        <div class="mt-20 pt-12 border-t border-white/5 text-center">
            <h2 class="font-head font-extrabold text-silver text-2xl lg:text-3xl mb-3">Não encontrou o que procura?</h2>
            <p class="text-silver-2 max-w-2xl mx-auto mb-10">
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
                    <a href="{{ $repo['url'] }}" target="_blank" rel="noopener noreferrer"
                       class="lift group flex flex-col items-center gap-2 px-6 py-6 rounded-3xl border border-white/10 bg-surface">
                        <span class="flex items-center justify-center w-16 h-16 mb-1 rounded-2xl bg-white p-2.5 transition-transform group-hover:scale-110">
                            <img src="{{ asset($repo['logo']) }}" alt="{{ $repo['nome'] }}" class="w-full h-full object-contain" loading="lazy">
                        </span>
                        <span class="font-head font-extrabold text-base text-silver group-hover:text-brand-lt transition-colors">{{ $repo['nome'] }}</span>
                        <span class="text-xs text-silver-2">{{ $repo['desc'] }}</span>
                        <span class="mt-2 inline-flex items-center gap-1 text-xs font-semibold uppercase tracking-wide text-brand-lt opacity-0 group-hover:opacity-100 transition-opacity">
                            Acessar
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}" target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center gap-2 rounded-2xl bg-wa px-6 py-3.5 text-sm font-bold text-[#06250f] shadow-wa hover:bg-wa-hi transition min-h-[48px]">
                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
                    Enviar link do modelo
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
