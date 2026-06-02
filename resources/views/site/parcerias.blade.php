@extends('layouts.site')

@section('title', 'Parceiros | Print Garage 3D')
@section('description', 'Conheça as empresas parceiras da Print Garage 3D.')

@section('content')
<section x-data="{ aberto: false, parceiro: {} }" class="relative bg-grid py-12 sm:py-20">
    <div class="pointer-events-none absolute -top-24 right-[-10%] h-[420px] w-[420px] glow-red opacity-40"></div>

    <div class="relative container-x">

        {{-- Cabeçalho --}}
        <div class="text-center max-w-2xl mx-auto mb-12">
            <p class="font-head text-xs font-bold uppercase tracking-[0.18em] text-brand-lt">🤝 Quem confia na gente</p>
            <h1 class="font-head font-extrabold text-silver mt-3 text-3xl sm:text-4xl lg:text-5xl tracking-tight">Nossos Parceiros</h1>
            <p class="mt-4 text-silver-2 text-lg">
                Empresas e marcas que caminham junto com a Print Garage 3D. Clique em um parceiro para saber mais.
            </p>
        </div>

        @if($parcerias->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                            class="lift group text-left rounded-3xl border border-white/10 bg-surface p-7 cursor-pointer">
                        <div class="flex items-center gap-4 mb-4">
                            @if($parceiro->logo)
                                <img src="{{ asset('storage/' . $parceiro->logo) }}" alt="{{ $parceiro->nome }}" class="w-16 h-16 object-contain rounded-2xl bg-white/5 p-1.5">
                            @else
                                <div class="w-16 h-16 grid place-items-center rounded-2xl border border-brand-lt/20 bg-brand/10 text-2xl">🏢</div>
                            @endif
                            <div>
                                <h3 class="font-head font-extrabold text-lg tracking-tight text-silver group-hover:text-brand-lt transition-colors">{{ $parceiro->nome }}</h3>
                                @if($parceiro->contato)
                                    <p class="text-xs text-silver-2">{{ $parceiro->contato }}</p>
                                @endif
                            </div>
                        </div>
                        @if($parceiro->descricao_curta)
                            <p class="text-sm text-silver-2 leading-relaxed">{{ $parceiro->descricao_curta }}</p>
                        @endif
                        <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brand-lt group-hover:gap-3 transition-all">
                            Ver mais
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </span>
                    </button>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 rounded-3xl border border-white/10 bg-surface">
                <div class="text-6xl mb-4">🤝</div>
                <h3 class="font-head font-extrabold text-2xl text-silver mb-3">Em breve!</h3>
                <p class="text-silver-2 max-w-md mx-auto">Ainda não temos parceiros cadastrados. Volte em breve!</p>
            </div>
        @endif

        {{-- Modal Alpine.js --}}
        <div x-show="aberto" x-cloak @keydown.escape.window="aberto = false"
             class="fixed inset-0 z-[60] flex items-center justify-center p-4" style="display: none;">
            <div x-show="aberto" x-transition.opacity @click="aberto = false" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>

            <div x-show="aberto" x-transition
                 class="relative bg-surface border border-white/10 rounded-3xl max-w-lg w-full max-h-[85vh] overflow-y-auto shadow-red-lg">
                <div class="p-6 sm:p-8">
                    <div class="flex items-start justify-between gap-4 mb-5">
                        <div class="flex items-center gap-4">
                            <template x-if="parceiro.logo">
                                <img :src="parceiro.logo" :alt="parceiro.nome" class="w-16 h-16 object-contain rounded-2xl bg-white/5 p-1.5">
                            </template>
                            <div>
                                <h3 class="font-head font-extrabold text-xl tracking-tight text-silver" x-text="parceiro.nome"></h3>
                                <p class="text-sm text-silver-2" x-text="parceiro.contato"></p>
                            </div>
                        </div>
                        <button @click="aberto = false" class="grid place-items-center h-9 w-9 rounded-lg text-silver-2 hover:text-silver hover:bg-white/5 transition" aria-label="Fechar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="prose prose-invert prose-sm max-w-none text-silver-2" x-html="parceiro.descricao_completa"></div>

                    <div class="mt-6 text-right">
                        <button @click="aberto = false" class="inline-flex items-center gap-2 rounded-xl border border-white/10 px-5 py-2.5 text-sm font-semibold text-silver hover:bg-white/5 transition">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
