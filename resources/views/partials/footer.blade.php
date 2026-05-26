<footer class="bg-brand-dark-soft border-t border-brand-silver-700/40 mt-20">
    <div class="container-x py-12">
        <div class="grid md:grid-cols-3 gap-10">

            {{-- Coluna 1: Logo + sobre --}}
            <div>
                <img src="{{ asset('assets/brand/logo/logo-principal.png') }}"
                     alt="Print Garage 3D"
                     class="h-16 w-auto mb-4">
                <p class="text-sm text-brand-silver-200 leading-relaxed">
                    Especialistas em impressão 3D personalizada. Transformamos suas ideias em peças reais com qualidade e dedicação.
                </p>
            </div>

            {{-- Coluna 2: Links rápidos --}}
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-red-300 mb-4">Navegação</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('site.home') }}" class="text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">Início</a></li>
                    <li><a href="{{ route('site.catalogo', ['tipo' => 'B2C']) }}" class="text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">Catálogo Pessoal (B2C)</a></li>
                    <li><a href="{{ route('site.catalogo', ['tipo' => 'B2B']) }}" class="text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">Soluções Empresariais (B2B)</a></li>
                    <li><a href="{{ route('site.parcerias') }}" class="text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">Parceiros</a></li>
                    <li><a href="#sobre" class="text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">Sobre a Print Garage</a></li>
                </ul>
            </div>

            {{-- Coluna 3: Contato + redes --}}
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-red-300 mb-4">Contato</h3>
                <div class="space-y-3">
                    <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
                       target="_blank"
                       rel="noopener"
                       class="flex items-center gap-3 text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24z"/>
                        </svg>
                        WhatsApp
                    </a>
                    <a href="{{ \App\Services\ConfiguracaoService::get('instagram_url', '#') }}"
                       target="_blank"
                       rel="noopener"
                       class="flex items-center gap-3 text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                        </svg>
                        {{ \App\Services\ConfiguracaoService::get('instagram_handle', '@printgarage_3d') }}
                    </a>
                    <a href="mailto:{{ \App\Services\ConfiguracaoService::get('empresa_email') }}"
                       class="flex items-center gap-3 text-sm text-brand-silver-100 hover:text-brand-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ \App\Services\ConfiguracaoService::get('empresa_email') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Linha inferior --}}
        <div class="mt-10 pt-6 border-t border-brand-silver-700/40 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-brand-silver-200">
                &copy; {{ date('Y') }} {{ \App\Services\ConfiguracaoService::get('empresa_nome', 'Print Garage 3D') }}. Todos os direitos reservados.
            </p>
            <p class="text-xs text-brand-silver-300">
                Feito com <span class="text-brand-red">♥</span> e impressão 3D
            </p>
        </div>
    </div>
</footer>
