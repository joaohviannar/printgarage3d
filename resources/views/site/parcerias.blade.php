@extends('layouts.site')

@section('title', 'Parceiros | Print Garage 3D')
@section('description', 'Conheça as empresas parceiras da Print Garage 3D.')

@section('content')
<section x-data="{ aberto: false, parceiro: {} }" class="py-12 lg:py-20">
    <div class="container-x">

        {{-- Cabeçalho --}}
        <div class="text-center mb-14">
            <span class="badge bg-brand-red/10 text-brand-red-300 border border-brand-red-700/40 mb-4">🤝 Quem confia na gente</span>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">Nossos Parceiros</h1>
            <p class="text-brand-silver-200 max-w-2xl mx-auto">
                Empresas e marcas que caminham junto com a Print Garage 3D. Clique em um parceiro para saber mais.
            </p>
        </div>

        @if($parcerias->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($parcerias as $parceiro)
                    @php
                        $dadosParceiro = [
                            'nome' => $parceiro->nome,
                            'contato' => $parceiro->contato,
                            'logo' => $parceiro->logo ? asset('storage/' . $parceiro->logo) : null,
                            'descricao_completa' => $parceiro->descricao_completa ?: '<p>Sem descrição detalhada.</p>',
                        ];
                    @endphp
                    <button type="button"
                            x-on:click="parceiro = @js($dadosParceiro); aberto = true"
                            class="group text-left bg-brand-dark-soft rounded-xl p-6 border border-brand-silver-700/40 hover:border-brand-red hover:-translate-y-1 transition-all duration-200 cursor-pointer">
                        <div class="flex items-center gap-4 mb-4">
                            @if($parceiro->logo)
                                <img src="{{ asset('storage/' . $parceiro->logo) }}"
                                     alt="{{ $parceiro->nome }}"
                                     class="w-16 h-16 object-contain rounded-lg bg-white/5 p-1">
                            @else
                                <div class="w-16 h-16 flex items-center justify-center rounded-lg bg-brand-red-900/20 text-2xl">🏢</div>
                            @endif
                            <div>
                                <h3 class="font-bold text-lg group-hover:text-brand-red-300 transition-colors">{{ $parceiro->nome }}</h3>
                                @if($parceiro->contato)
                                    <p class="text-xs text-brand-silver-300">{{ $parceiro->contato }}</p>
                                @endif
                            </div>
                        </div>
                        @if($parceiro->descricao_curta)
                            <p class="text-sm text-brand-silver-200 leading-relaxed">{{ $parceiro->descricao_curta }}</p>
                        @endif
                        <span class="mt-4 inline-flex items-center gap-1 text-xs font-semibold uppercase tracking-wider text-brand-red-300 opacity-0 group-hover:opacity-100 transition-opacity">
                            Ver mais
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </button>
                @endforeach
            </div>
        @else
            {{-- Estado vazio --}}
            <div class="text-center py-20 bg-brand-dark-soft rounded-2xl border border-brand-silver-700/40">
                <div class="text-6xl mb-4">🤝</div>
                <h3 class="text-2xl font-bold mb-3">Em breve!</h3>
                <p class="text-brand-silver-200 max-w-md mx-auto">
                    Ainda não temos parceiros cadastrados. Volte em breve!
                </p>
            </div>
        @endif

        {{-- Modal Alpine.js --}}
        <div x-show="aberto"
             x-cloak
             @keydown.escape.window="aberto = false"
             class="fixed inset-0 z-[60] flex items-center justify-center p-4"
             style="display: none;">
            {{-- Overlay (fecha ao clicar fora) --}}
            <div x-show="aberto"
                 x-transition.opacity
                 @click="aberto = false"
                 class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

            {{-- Conteúdo --}}
            <div x-show="aberto"
                 x-transition
                 class="relative bg-brand-dark-soft border border-brand-silver-700/50 rounded-2xl max-w-lg w-full max-h-[85vh] overflow-y-auto shadow-2xl">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 mb-5">
                        <div class="flex items-center gap-4">
                            <template x-if="parceiro.logo">
                                <img :src="parceiro.logo" :alt="parceiro.nome" class="w-16 h-16 object-contain rounded-lg bg-white/5 p-1">
                            </template>
                            <div>
                                <h3 class="text-xl font-bold" x-text="parceiro.nome"></h3>
                                <p class="text-sm text-brand-silver-300" x-text="parceiro.contato"></p>
                            </div>
                        </div>
                        <button @click="aberto = false"
                                class="text-brand-silver-300 hover:text-white transition-colors p-1"
                                aria-label="Fechar">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div class="prose prose-invert prose-sm max-w-none text-brand-silver-100" x-html="parceiro.descricao_completa"></div>

                    <div class="mt-6 text-right">
                        <button @click="aberto = false" class="btn-secondary !py-2 !px-5 !text-xs">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
