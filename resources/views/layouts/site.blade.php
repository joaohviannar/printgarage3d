<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO --}}
    <title>@yield('title', \App\Services\ConfiguracaoService::get('site_titulo', 'Print Garage 3D'))</title>
    <meta name="description" content="@yield('description', \App\Services\ConfiguracaoService::get('site_descricao'))">
    <meta name="theme-color" content="#8e1512">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="author" content="Print Garage 3D">
    <meta name="keywords" content="impressão 3D, impressao 3d, print garage, print garage 3d, peças personalizadas 3D, bonecos 3D, suportes 3D, placas PIX, logo 3D, brindes corporativos">
    <meta name="geo.region" content="BR">
    <meta property="og:site_name" content="Print Garage 3D">

    {{-- Open Graph (WhatsApp / Instagram preview) --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('description', \App\Services\ConfiguracaoService::get('site_descricao'))">
    <meta property="og:image" content="@yield('og_image', asset('assets/brand/logo/logo-principal.png'))">
    <meta property="og:locale" content="pt_BR">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name'))">
    <meta name="twitter:description" content="@yield('description', \App\Services\ConfiguracaoService::get('site_descricao'))">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/brand/logo/logo-principal.png'))">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/logo/icone.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">

    {{-- Vite (Tailwind + JS) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Dados estruturados (Schema.org) - ajuda o Google a reconhecer a empresa --}}
    @php
        $cfg = fn($k, $d = null) => \App\Services\ConfiguracaoService::get($k, $d);
        $whatsappNumero = preg_replace('/\D/', '', $cfg('whatsapp_numero', ''));
    @endphp
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Print Garage 3D",
        "alternateName": "Print Garage",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('assets/brand/logo/logo-principal.png') }}",
        "image": "{{ asset('assets/brand/logo/logo-principal.png') }}",
        "description": "{{ $cfg('site_descricao', 'Especialistas em impressão 3D personalizada.') }}",
        "email": "{{ $cfg('empresa_email', '') }}",
        "telephone": "+{{ $whatsappNumero }}",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "BR"
        },
        "sameAs": [
            "{{ $cfg('instagram_url', 'https://www.instagram.com/printgarage_3d/') }}"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+{{ $whatsappNumero }}",
            "contactType": "customer service",
            "availableLanguage": "Portuguese"
        }
    }
    </script>

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Print Garage 3D",
        "url": "{{ url('/') }}"
    }
    </script>

    @stack('head')
</head>
<body class="bg-brand-dark text-brand-silver-50 min-h-screen flex flex-col">

    @include('partials.header')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Botão flutuante WhatsApp --}}
    <a href="{{ \App\Services\ConfiguracaoService::whatsappLink() }}"
       target="_blank"
       rel="noopener"
       class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 rounded-full bg-[#25D366] shadow-2xl shadow-[#25D366]/40 hover:scale-110 transition-transform duration-200"
       aria-label="Falar no WhatsApp">
        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.595 5.392l-1.001 3.65 3.895-1.024.001-.001zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.296-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.149-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/>
        </svg>
    </a>

    @stack('scripts')
</body>
</html>
