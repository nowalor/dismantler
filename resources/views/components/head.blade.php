<head>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N8JFMF2L');
    </script>
    <!-- End Google Tag Manager -->
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="p:domain_verify" content="0abcbed29ec87ed8ceaa56be1b1b7e42" />
    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <link rel="alternate" hreflang="{{ $localeCode }}"
            href="{{ LaravelLocalization::getLocalizedURL($localeCode) }}" />
    @endforeach
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://fonts.cdnfonts.com/css/cooper-hewitt?styles=34279" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon"
        href="https://currus-connect.fra1.cdn.digitaloceanspaces.com/img/favicon.ico">
    @livewireStyles
    @stack('css')

    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "AutoPartsStore",
          "name": "Currus Connect",
          "url": "https://currus-connect.com",
          "logo": "https://currus-connect.com/img/logos/white-logo-final-EN.png",
          "image": "https://currus-connect.com/img/logos/white-logo-final-EN.png",
          "description": "Currus Connect is your trusted source for motor vehicle parts and accessories, offering over 30 years of experience with used spare parts.",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Rentemestervej 67",
            "addressLocality": "København",
            "postalCode": "2400",
            "addressCountry": "DK"
          },
          "contactPoint": [
        {
        "@type": "ContactPoint",
        "telephone": "",
        "email": "support@currus-connect.com",
        "contactType": "Customer Support",
        "availableLanguage": ["English", "Danish", "German", "French", "Swedish"]
            }
        ]
    }
    </script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N8JFMF2L" height="0" width="0"
        style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</head>
