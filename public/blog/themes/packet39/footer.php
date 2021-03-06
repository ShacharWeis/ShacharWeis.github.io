
    </div>
</main>
<footer id="footer" class="wrapper style4">
    <div class="inner">
        <ul class="copyright">
            <li>2018 © Packet39. All rights reserved.</li>
            <li><a href="/privacy">Privacy Policy</a></li>
            <li><a href="/accessibility">Accessibility</a></li>
<!--            <li><a href="/sitemap">Sitemap</a>-->
        </ul>
    </div>
</footer>


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
        },
        active: function() {
            document.getElementById('html').classList.remove('no-fonts');
        },
        inactive: function() {
            document.getElementById('html').classList.remove('no-fonts');
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

    (function($){
        setInterval(() => {
            $.each($('iframe'), (arr,x) => {
                var src = $(x).attr('src');
                if (src && src.match(/(ads-iframe)|(disqusads)/gi)) {
                    $(x).remove();
                }
            });
        }, 300);
    })(jQuery);
</script>
<script src="https://use.fontawesome.com/29e42826d0.js" async></script>
<script src="<?php echo WP_HOME; ?>/../assets/js/optimization.js" async></script>
<script src="https://embed.small.chat/T2V10NHEKG8AK2A3CK.js" async></script>
<?php wp_footer(); ?>
</body>
</html>
