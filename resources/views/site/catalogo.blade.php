@extends('layouts.site')

@section('title', 'Catálogo ' . $tipo . ' | Print Garage 3D')

@section('content')
<section class="py-20">
    <div class="container-x">
        <div class="text-center mb-14">
            <span class="{{ $tipo === 'B2C' ? 'badge-b2c' : 'badge-b2b' }} mb-4">
                {{ $tipo === 'B2C' ? 'Para Você' : 'Para Empresas' }}
            </span>
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">Catálogo {{ $tipo }}</h1>
            <p class="text-brand-silver-200 max-w-2xl mx-auto">
                {{ $tipo === 'B2C'
                    ? 'Peças personalizadas para você, sua casa e seu dia a dia.'
                    : 'Soluções 3D para empresas: brindes, identidade e diferenciais corporativos.' }}
            </p>
        </div>

        {{-- Placeholder enquanto não há produtos cadastrados --}}
        <div class="text-center py-20 bg-brand-dark-soft rounded-2xl border border-brand-silver-700/40">
            <div class="text-6xl mb-4">🛠️</div>
            <h3 class="text-2xl font-bold mb-3">Catálogo em construção</h3>
            <p class="text-brand-silver-200 mb-6 max-w-md mx-auto">
                Em breve você verá aqui todos os nossos produtos disponíveis. Enquanto isso, fale conosco no WhatsApp!
            </p>
            <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
               target="_blank"
               class="btn-whatsapp">
                Falar no WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
