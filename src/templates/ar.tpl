{% extends "./layouts/layout.base" %}

{% block content %}
<!-- One -->
<section id="one" class="wrapper spotlight style1" style="margin-top: 40%;">
    <div class="inner">
        <a href="#" class="image"><img src="images/pic04.jpg" alt=""/></a>
        <div class="content">
            <h2 class="major">Virtual Reality</h2>
            <p>
                From stunning, captivating experiences to seamlessly
                integrating our physical and digital worlds, Packet39
                helps clients define, develop, and deliver Virtual Reality,
                Augmented Reality, and Mixed Reality games and apps.
                We develop for the Google Cardboard, Daydream,
                GearVR, HTC Vive, and Oculus Rift platforms.
            </p>
            <form method="post" action="mailto:Vice@Packet39.com">
                <input type="submit" value="Contact Us"/>
            </form>
        </div>
    </div>
</section>


<!-- Two -->
<section id="two" class="wrapper alt spotlight style2">
    <div class="inner">
        <a href="#" class="image"><img src="images/pewpew.png" alt=""/></a>
        <div class="content">
            <h2 class="major">Augmented Reality</h2>
            <p>Bring to life static everyday objects, from buisness cards, to books, magazines, brochures and
                even three dimentional items such as toys or consumer products. Overlay, animate, gamify and
                extend your marketing materials.
                <br><br>
                Try it yourself, download our AR apps from the links below (Android only). Run the app and point
                your smartphone camera at one of our cards. If you don't have any, you can download and print
                our <b><a href="images/BizCard.png">buisness card</a></b> or the Alien Attack <b><a
                            href="images/AlienAttack.png"> game card</a></b>.</p>
            </p>

            <table border=0>
                <tr>
                    <td>
                        <input type="submit" value="Buisness Card AR"
                               onclick="window.location.href='https://www.dropbox.com/s/wdp1tnpkqi83ov1/Packet39.apk?dl=1';"/>
                    </td>
                    <td>

                        <input type="submit" value="Alien Attack"
                               onclick="window.location.href='https://www.dropbox.com/s/flq8g7g8dkcjoqp/Packet39%20Alien%20Attack.apk?dl=1';"/>

                    </td>
                </tr>


            </table>


        </div>
    </div>
</section>


<section id="five" class="wrapper style4">
    <div class="inner">
        <h2 class="major">Contact</h2>
        <p>We will be happy to answer any questions you might have and we'll create a white paper and a proposal
            for your project, free of charge and without commitment. </p>
        <ul class="contact">
            <li class="fa-envelope"><a href="mailto:Vice@Packet39.com">Vice@Packet39.com</a></li>
            <li class="fa-home">
                Packet39<br/>
                39 Raebrook place<br/>
                London, ON, Canada<br/>
                N5X2Z8
            </li>
            <li class="fa-phone">519-902-6191</li>
            <li class="fa-twitter"><a href="http://twitter.com/vice_ookpiklabs">twitter.com/vice_ookpiklabs</a>
            </li>
            <li class="fa-wordpress"><a href="https://callmevice.com/">CallMeVice.com</a></li>
        </ul>

    </div>
</section>
{% endblock %}