<header x-data="{ mobileOpen: false }" class="fixed top-0 inset-x-0 z-50 border-b border-white/5 bg-ink/80 backdrop-blur-md">
    <div class="container-x">
        <div class="flex h-16 items-center justify-between gap-4">

            {{-- Logo lockup --}}
            <a href="{{ route('site.home') }}" class="flex items-center gap-2.5 shrink-0" aria-label="Print Garage 3D — início">
                <img src="{{ asset('assets/brand/logo/icone.png') }}" alt="" class="h-9 w-9 object-contain">
                <span class="font-head font-extrabold tracking-tight text-[15px] leading-none">
                    PRINT <span class="text-brand-lt">GARAGE</span> <span class="text-silver-2 font-bold">3D</span>
                </span>
            </a>

            {{-- Nav desktop --}}
            <nav class="hidden md:flex items-center gap-1" aria-label="Navegação principal">
                <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}"
                   class="px-3 py-2 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Para Você</a>
                <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}"
                   class="px-3 py-2 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Para Empresas</a>
                <a href="{{ route('site.parcerias') }}"
                   class="px-3 py-2 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition {{ request()->routeIs('site.parcerias') ? 'text-silver bg-white/5' : '' }}">Parceiros</a>
                <a href="{{ route('site.home') }}#sobre"
                   class="px-3 py-2 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Sobre</a>
            </nav>

            {{-- CTA WhatsApp (desktop) --}}
            <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
               target="_blank" rel="noopener"
               class="hidden sm:inline-flex items-center gap-2 rounded-xl bg-wa px-4 py-2.5 text-sm font-semibold text-[#06250f] shadow-wa hover:bg-wa-hi transition min-h-[44px]">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zM6.597 20.13c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 0 0 1.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479c0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413z"/></svg>
                WhatsApp
            </a>

            {{-- Botão menu mobile --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden grid place-items-center h-10 w-10 rounded-lg text-silver-2 hover:text-silver hover:bg-white/5 transition"
                    aria-label="Abrir menu">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Menu mobile --}}
        <div x-show="mobileOpen" x-cloak x-transition class="md:hidden pb-4 space-y-1">
            <a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="block px-3 py-2.5 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Para Você</a>
            <a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}" class="block px-3 py-2.5 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Para Empresas</a>
            <a href="{{ route('site.parcerias') }}" class="block px-3 py-2.5 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Parceiros</a>
            <a href="{{ route('site.home') }}#sobre" class="block px-3 py-2.5 rounded-lg text-sm text-silver-2 hover:text-silver hover:bg-white/5 transition">Sobre</a>
            <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}" target="_blank" rel="noopener"
               class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-wa px-4 py-3 text-sm font-semibold text-[#06250f] shadow-wa hover:bg-wa-hi transition">
                <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24zM6.597 20.13c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 0 0 1.51 5.26l-.999 3.648 3.978-1.607z"/></svg>
                WhatsApp
            </a>
        </div>
    </div>
</header>

{{-- Espaçador: compensa o header fixed --}}
<div class="h-16"></div>
