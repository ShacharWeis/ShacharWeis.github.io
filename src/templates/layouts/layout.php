<?php

require_once __DIR__ . '/app/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Session\Session;

$session = new Session();
$session->start();

if ($session->has('token')) {
    $token = $session->get('token');
} else {
    $token = bin2hex(random_bytes(32));
    $session->set('token', $token);
}

?>

<!DOCTYPE HTML>

<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com"/>
    <link rel="dns-prefetch" href="https://use.fontawesome.com"/>
    <link rel="dns-prefetch" href="https://www.google-analytics.com"/>

    <script>
        window.ga = window.ga || function () {
                (ga.q = ga.q || []).push(arguments);
            };
        ga.l = +new Date;
        ga('create', 'UA-80992066-1', 'auto');
        ga('send', 'pageview');
    </script>
    <script async src='https://www.google-analytics.com/analytics.js'></script>

    <title>Packet39 | Virtual & Augmented Reality, Custom Solutions</title>
    <meta name="description"
          content="We develop custom software and hardware solutions, Virtual Reality, Augmented Reality, computer vision and image processing applications for your needs.">
    <link rel="canonical" href="http://packet39.com/">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Packet39">

    <!--FACEBOOK-->
    <meta property="og:title"
          content="Packet39 | Virtual & Augmented Reality, Custom Solutions">
    <meta property="og:site_name" content="Packet39">
    <meta property="og:url" content="http://packet39.com/">
    <meta property="og:description"
          content="We develop custom software and hardware solutions, Virtual Reality, Augmented Reality, computer vision and image processing applications for your needs.">
    <meta property="og:image" content="http://packet39.com/assets/images/packet39-social.jpg">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Vice_Packet39">
    <meta name="twitter:title" content="Packet39 | Virtual & Augmented Reality, Custom Solutions">
    <meta name="twitter:description"
          content="We develop custom software and hardware solutions, Virtual Reality, Augmented Reality, computer vision and image processing applications for your needs.">
    <meta name="twitter:image" content="http://packet39.com/assets/images/packet39-social.jpg">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ staticPath }}/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ staticPath }}/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ staticPath }}/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ staticPath }}/favicon/manifest.json">
    <link rel="mask-icon" href="{{ staticPath }}/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="{{ staticPath }}/favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Packet39">
    <meta name="application-name" content="Packet39">
    <meta name="msapplication-config" content="{{ staticPath }}/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">


    <style><?php include '{{ stylePath }}/main.css' ?></style>
</head>
<body style="background-image: url('./assets/images/main_small.jpg')">

<div id="page-wrapper">

    <section id="wrapper">
        {% block content %}

        {% endblock %}
    </section>
</div>


<script type="application/ld+json">
{
    "@context" : "http://schema.org",
    "@type" : "Organization",
    "name" : "Packet39",
    "legalName" : "Packet39",
    "url": "http://packet39.com/",
    "logo": "http://packet39.com/assets/images/packet39-social.jpg",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "39 Raebrook Place",
        "addressLocality": "London",
        "addressRegion": "ON",
        "postalCode": "N5X 2Z8",
        "addressCountry": "Canada"
    },
    "contactPoint": {
    "@type": "ContactPoint",
        "contactType": "sales",
        "telephone": "+1-519-902-6191",
        "email": "vice@packet39.com"
    },
    "sameAs": [
        "https://twitter.com/Vice_Packet39",
        "https://www.linkedin.com/company/packet39"
    ]
}
</script>
<!-- Scripts -->
<script id="webfontLoader">
    WebFontConfig = {
        google: {
            families: ['Raleway:200,700', 'Source Sans Pro:300,600,300italic,600italic']
        }
    };

    (function (d) {
        var wf = d.createElement('script'), s = d.getElementById('webfontLoader');
        wf.src = 'https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.26/webfontloader.js';
        wf.async = true;
        wf.setAttribute('integrity', 'sha256-+6jNhQy77vjBVW8D4TAIG0HBtnzN9YreZOvtii8vrAM=');
        wf.setAttribute('crossorigin', 'anonymous');
        s.parentNode.insertBefore(wf, s);
    })(document);
</script>
<script src="https://use.fontawesome.com/29e42826d0.js" async></script>
<script src="{{ scriptPath }}/optimization.js" async></script>
<script src="{{ scriptPath }}/submission.js" async></script>
</body>
</html>