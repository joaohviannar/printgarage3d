@php $cfg = fn($k, $d = null) => \App\Services\ConfiguracaoService::get($k, $d); @endphp

<footer class="border-t border-white/5 bg-ink mt-auto">
    <div class="container-x py-14">
        <div class="grid gap-10 md:grid-cols-[1.4fr_1fr_1fr]">

            {{-- Marca --}}
            <div>
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('assets/brand/logo/icone.png') }}" alt="" class="h-9 w-9 object-contain">
                    <span class="font-head font-extrabold tracking-tight text-[15px]">
                        PRINT <span class="text-brand-lt">GARAGE</span> <span class="text-silver-2 font-bold">3D</span>
                    </span>
                </div>
                <p class="mt-4 text-silver-2 max-w-sm leading-relaxed">
                    Especialistas em impressão 3D personalizada em Brasília-DF. Transformamos suas ideias em peças reais com qualidade e dedicação.
                </p>
            </div>

            {{-- Navegação --}}
            <div>
                <h4 class="font-head font-bold text-sm uppercase tracking-wider text-silver">Navegação</h4>
                <ul class="mt-4 space-y-2.5 text-silver-2">
                    <li><a href="{{ route('site.home') }}" class="hover:text-brand-lt transition">Início</a></li>
                    <li><a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="hover:text-brand-lt transition">Para Você (B2C)</a></li>
                    <li><a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}" class="hover:text-brand-lt transition">Para Empresas (B2B)</a></li>
                    <li><a href="{{ route('site.parcerias') }}" class="hover:text-brand-lt transition">Parceiros</a></li>
                    <li><a href="{{ route('site.home') }}#sobre" class="hover:text-brand-lt transition">Sobre</a></li>
                </ul>
            </div>

            {{-- Contato --}}
            <div>
                <h4 class="font-head font-bold text-sm uppercase tracking-wider text-silver">Contato</h4>
                <ul class="mt-4 space-y-2.5 text-silver-2">
                    <li>
                        <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-wa transition">
                            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163a11.867 11.867 0 0 1-1.587-5.945C.16 5.335 5.495 0 12.05 0a11.82 11.82 0 0 1 8.413 3.488 11.82 11.82 0 0 1 3.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 0 1-5.688-1.448L.057 24z"/></svg>
                            WhatsApp
                        </a>
                    </li>
                    <li>
                        <a href="{{ $cfg('instagram_url', 'https://www.instagram.com/printgarage_3d/') }}" target="_blank" rel="noopener" class="hover:text-brand-lt transition">
                            {{ $cfg('instagram_handle', '@printgarage_3d') }}
                        </a>
                    </li>
                    @if($cfg('empresa_email'))
                        <li><a href="mailto:{{ $cfg('empresa_email') }}" class="hover:text-brand-lt transition">{{ $cfg('empresa_email') }}</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-white/5 pt-6 text-sm text-silver-2/70">
            <p>&copy; {{ date('Y') }} {{ $cfg('empresa_nome', 'Print Garage 3D') }}. Todos os direitos reservados.</p>
            <p>Feito com <span class="text-brand-lt">♥</span> e impressão 3D</p>
        </div>
    </div>
</footer>
