<header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 bg-brand-dark/95 backdrop-blur border-b border-brand-silver-700/40">
    <div class="container-x">
        <nav class="flex items-center justify-between h-20">
            {{-- Logo --}}
            <a href="{{ route('site.home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('assets/brand/logo/logo-principal.png') }}"
                     alt="Print Garage 3D"
                     class="h-12 w-auto transition-transform group-hover:scale-105">
            </a>

            {{-- Menu desktop --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('site.home') }}"
                   class="text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300 transition-colors {{ request()->routeIs('site.home') ? 'text-brand-red-300' : '' }}">
                    Início
                </a>
                <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}"
                   class="text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300 transition-colors">
                    Para Você
                </a>
                <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}"
                   class="text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300 transition-colors">
                    Para Empresas
                </a>
                <a href="#sobre"
                   class="text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300 transition-colors">
                    Sobre
                </a>
                <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
                   target="_blank"
                   rel="noopener"
                   class="btn-primary !py-2 !px-5 !text-xs">
                    Fale Conosco
                </a>
            </div>

            {{-- Botão menu mobile --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden p-2 text-brand-silver-100 hover:text-brand-red-300"
                    aria-label="Abrir menu">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </nav>

        {{-- Menu mobile --}}
        <div x-show="mobileOpen" x-cloak x-transition class="md:hidden pb-4 space-y-2">
            <a href="{{ route('site.home') }}" class="block py-2 text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300">Início</a>
            <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="block py-2 text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300">Para Você</a>
            <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}" class="block py-2 text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300">Para Empresas</a>
            <a href="#sobre" class="block py-2 text-sm font-semibold uppercase tracking-wider text-brand-silver-100 hover:text-brand-red-300">Sobre</a>
            <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}" target="_blank" class="btn-primary w-full mt-3">Fale Conosco</a>
        </div>
    </div>
</header>
