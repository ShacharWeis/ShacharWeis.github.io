<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> id="html" class="no-js blog">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>
    <link rel="dns-prefetch" href="https://fonts.gstatic.com"/>
    <link rel="dns-prefetch" href="https://use.fontawesome.com"/>
    <link rel="dns-prefetch" href="https://www.google-analytics.com"/>
    <link rel="stylesheet" href="<?php echo WP_HOME . '/../assets/css/main.css';?>" />
    <?php wp_head(); ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo WP_HOME . '/../static'; ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo WP_HOME . '/../static'; ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo WP_HOME . '/../static'; ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo WP_HOME . '/../static'; ?>/favicon/manifest.json">
    <link rel="mask-icon" href="<?php echo WP_HOME . '/../static'; ?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo WP_HOME . '/../static/'; ?>favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Packet39">
    <meta name="application-name" content="Packet39">
    <meta name="msapplication-config" content="<?php echo WP_HOME . '/../static/'; ?>favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <script type="text/javascript">
        document.getElementById('html').classList.toggle('no-js');
        document.getElementById('html').classList.toggle('js');
        document.getElementById('html').classList.add('no-fonts');
    </script>
    <script>
        (function(i,s,o,g,r,a,m){
            i['GoogleAnalyticsObject']=r;
            i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},
                i[r].l=1*new Date();
            a=s.createElement(o),m=s.getElementsByTagName(o)[0];
            a.async=1;
            a.src=g;
            m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-135140120-1', 'auto');
        ga('send', 'pageview');
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-761297127"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'AW-761297127');
    </script>
    <script>
        gtag('event', 'page_view', {
            'send_to': 'AW-761297127',
            'dynx_itemid': 'replace with value',
            'dynx_itemid2': 'replace with value',
            'dynx_pagetype': 'replace with value',
            'dynx_totalvalue': 'replace with value'
        });
    </script>
</head>
<body <?php body_class(); ?>>
<div id="mobileHeader">
    <a href="/" title="Packet39 Home Link" id="mobileLogo" aria-hidden="true">
        <img src="<?php echo WP_HOME . '/..'; ?>/assets/images/monochrome-logo.png" alt="Packet39 Monochrome Box Logo" aria-hidden="true" />
    </a>
    <div id="menuToggle">
        <span>Menu</span>
    </div>
</div>
<header id="mainHeader">
    <a href="/" title="Packet39 Home Link" class="homeLink" aria-hidden="true">
        <img src="<?php echo WP_HOME . '/..'; ?>/assets/images/monochrome-logo.png" alt="Packet39 Monochrome Box Logo" aria-hidden="true" />
    </a>
    <nav>
        <ul>
            <li><a href="/#wrapper" data-scroll>About</a></li>
            <li><a href="/projects">Projects</a></li>
            <li><a href="/the-team">The Team</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/#footer" data-scroll>Contact Us</a></li>
        </ul>
    </nav>
</header>

<main id="page-wrapper">
    <div id="heroImage" style="background-image: url(<?php echo WP_HOME . '/../assets/images'; ?>/main_small.jpg)"></div>
    <div id="wrapper">
