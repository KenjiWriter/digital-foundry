<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Meta Tags --}}
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="description"
        content="Cerasus Digital - Tworzymy dedykowane systemy IT, które budują przewagę konkurencyjną. Specjalizujemy się w Laravel, Vue.js i automatyzacji procesów biznesowych.">
    <meta name="keywords"
        content="Software House, Custom Software, Aplikacje Dedykowane, Laravel, Vue.js, Automatyzacja, CRM, ERP, Programista Laravel">

    {{-- Open Graph Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Cerasus Digital | Custom Software House">
    <meta property="og:description"
        content="Budujemy dedykowane systemy IT, CRM i aplikacje webowe. Laravel & Vue.js Experts.">
    <meta property="og:site_name" content="Cerasus Digital">
    <meta property="og:locale" content="pl_PL">
    <meta property="og:image" content="https://cerasusdigital.pl/images/og-share-image.jpg">

    {{-- Twitter Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:site" content="@cerasusdigital">
    <meta name="twitter:title" content="Cerasus Digital | Custom Software House">
    <meta name="twitter:description" content="Budujemy dedykowane systemy IT, CRM i aplikacje webowe.">
    <meta name="twitter:image" content="https://cerasusdigital.pl/images/og-share-image.jpg">

    {{-- Structured Data (JSON-LD) --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "ProfessionalService",
      "name": "Cerasus Digital",
      "image": "{{ asset('images/logo-og.png') }}",
      "@@id": "https://cerasusdigital.pl",
      "url": "https://cerasusdigital.pl",
      "telephone": "+48 455 518 083",
      "email": "hello@cerasusdigital.pl",
      "address": {
        "@@type": "PostalAddress",
        "streetAddress": "Emilianów 8A",
        "addressLocality": "Emilianów",
        "postalCode": "96-330",
        "addressCountry": "PL"
      },
      "priceRange": "$$$",
      "openingHoursSpecification": {
        "@@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday"
        ],
        "opens": "09:00",
        "closes": "17:00"
      },
      "sameAs": [
        "https://www.linkedin.com/company/cerasus-digital",
        "https://github.com/cerasus-digital"
      ]
    }
    </script>

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function () {
            const appearance = '{{ $appearance ?? "system" }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead

</head>
<!-- DEBUG_Identify_This_File -->

<body class="font-sans antialiased">
    @inertia
</body>

</html>