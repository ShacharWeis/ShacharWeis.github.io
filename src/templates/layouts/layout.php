<?php

    require_once __DIR__.'/app/vendor/autoload.php';

    use Symfony\Component\HttpFoundation\Session\Session;

    $session = new Session();
    $session->start();

    if($session->has('token')) {
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

    <title>Packet39 - Virtual Reality, Augmented Reality, Custom software and hardware solutions</title>
    <meta name="keywords"
          content="Virtual Reality, Augmented Reality, Packet39, Custom hardware,software, software development, developer, applications, computer vision, 3d printing, machine learning, openCV">
    <meta name="description"
          content="Packet39 develops custom software and hardware solutions, Virtual Reality, Augmented Reality, computer vision and image processing applications for desktop, mobile or web.">
    <link rel="canonical" href="http://packet39.com/">

    <!--FACEBOOK-->
    <meta property="og:title"
          content="Packet39 - Virtual Reality, Augmented Reality, Custom software and hardware solutions">
    <meta property="og:site_name" content="Packet39">
    <meta property="og:url" content="http://packet39.com/">
    <meta property="og:description"
          content="Packet39 develops custom software and hardware solutions, Virtual Reality, Augmented Reality, computer vision and image processing applications for desktop, mobile or web.">
    <meta property="og:image" content="">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">

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

<!-- Scripts -->
<script>
    WebFontConfig = {
        google: {
            families: ['Raleway:200,700', 'Source Sans Pro:300,600,300italic,600italic']
        }
    };

    (function (d) {
        var wf = d.createElement('script'), s = d.currentScript;
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