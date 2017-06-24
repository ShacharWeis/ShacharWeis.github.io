{% extends "./layouts/layout.base" %}

{% block content %}
<!-- One -->
<section id="one" class="wrapper spotlight style1" style="margin-top: 40%;">
    <div class="inner">
        <a href="#" class="image"><img src="{{ imagePath }}/pic01.jpg" alt=""/></a>
        <div class="content">
            <h2 class="major">Packet39</h2>
            <h3 class="major">Code outside the box</h3>
            <p>We are a team of professional software developers and academics, working together to provide
                software & hardware solutions. We thrive in the space between code and the physical world and we
                develop solutions that sense, manipulate and move around in the environment. </p>
            <form method="post" action="mailto:Vice@Packet39.com">
                <input type="submit" value="Contact Us"/>
            </form>
        </div>
    </div>
</section>


<section id="two" class="wrapper alt spotlight style2">
    <div class="inner">
        <a href="#" class="image"><img src="{{ imagePath }}/pic04.jpg" alt=""/></a>
        <div class="content">
            <h2 class="major">Virtual Reality</h2>
            <p>We design and develop Virual Reality, Augmented Reality and Mixed Reality games and experiences.
                <br><br>
                We can build your idea, or help you refine it. We can deliver games or applications for Google
                Cardboard, Daydream, Samsung GearVR, HTC Vive or the Oculus Rift.</p>
        </div>
    </div>
</section>

<section id="three" class="wrapper spotlight style1">
    <div class="inner">
        <a href="#" class="image"><img src="{{ imagePath }}/pewpew.png" alt=""/></a>
        <div class="content">
            <h2 class="major">Augmented Reality</h2>
            <p>Bring to life static everyday objects, from buisness cards, to books, magazines, brochures and
                even three dimentional items such as toys or consumer products. Overlay, animate, gamify and
                extend your marketing materials.
                <br><br>
                Try it yourself, download our AR apps from the links below (Android only). Run the app and point
                your smartphone camera at one of our cards. If you don't have any, you can download and print
                our <b><a href="{{ imagePath }}/BizCard.png" target="_blank">buisness card</a></b> or the Alien Attack
                <b><a
                            href="{{ imagePath }}/AlienAttack.png" target="_blank"> game card</a></b>.</p>
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

<!-- Two -->
<section id="four" class="wrapper alt spotlight style2">
    <div class="inner">
        <a href="#" class="image"><img src="{{ imagePath }}/pic02.jpg" alt=""/></a>
        <div class="content">
            <h2 class="major">Software</h2>
            <p>We develop software under Windows or Linux, using C# & .Net, Matlab, C++, Java or Python. We are
                familiar with OpenCV, EMGU, PCL, OpenNI and other CV and Image processing libraries.
                <br><br>
                We have experience in a wide range of fields, including virtual reality, augmented reality,
                action recognition in video, shape detection in stills, segmentation, medical imaging, 3D
                printing, 3D scanning and 3D reconstruction, gesture and finger detection using depth cameras,
                optical flow, face tracking and much more.
                <br><br>
                With decades of combined expertise, we can develop and implement algorithms to solve real world
                problems. We will choose the right hardware, cameras or sensors for your needs and provide a
                start-to-finish service.</p>
        </div>
    </div>
</section>

<!-- Three -->
<section id="three" class="wrapper spotlight style3">
    <div class="inner">
        <a href="#" class="image"><img src="{{ imagePath }}/pic03.jpg" alt=""/></a>
        <div class="content">
            <h2 class="major">Hardware & Sensors</h2>
            <p>We can recommend the hardware most suited for your needs, or work with the equipment you already
                have. We have experience with a wide range of small board computers, cameras and sensors,
                including Arduino, Raspberry Pi, machine vision cameras and depth cameras.
                <br><br>
                We can build custom hardware, testing rigs, quadcopters, robotics or tactile user interfaces. We
                have the facilities and expertise to design, test and fabricate in-house most of the parts
                needed for small to medium projects, allowing a very quick turnaround time. We've also worked
                with thermal imagers, capacitance sensors, laser scanners and more exotic forms of remote
                sensing and data acquisition.</p>
        </div>
    </div>
</section>


<section id="four" class="wrapper alt style2">
    <div class="inner">
        <h2 class="major">Projects</h2>
        <section class="features">
            <article>
                <div class="youtubePlayer" data-id="kyDiQ-KHNe0"></div>
                <br>

                <h3 class="major">Orbital Injection - Virtual Reality game</h3>
                <p>Our VR game is now live on <a href="http://store.steampowered.com/app/587730/">Steam</a>.
                    Grab planets and toss them into a stable orbit. This is a room-scale virtual reality
                    experiance, running on the HTC Vive.</p>


            </article>

            <article>
                <div class="youtubePlayer" data-id="P7X9AR5KecE"></div>
                <br>

                <h3 class="major">Augmented Reality Buisness Card</h3>
                <p>We spruced up our Packet39 Buisness cards with some Augmented Reality magic. Realtime digital
                    3D graphics overlay, attached to a physical object. If you want to try it yourself, download
                    the app <b><a
                                href="https://www.dropbox.com/s/wdp1tnpkqi83ov1/Packet39.apk?dl=0">here</a></b>
                    (Android only). You'll need a Packet39 <b><a href="{{ imagePath }}/BizCard.png">card</a></b>, print
                    one if you don't have any.</p>


            </article>


            <article>
                <div class="youtubePlayer" data-id="iOc8JQwl8Cc"></div>
                <br>

                <h3 class="major">Interactive displays</h3>
                <p>Demo reel of several interactive displays developed by Packet39 team members. Detection is
                    done using cameras and thermal sensors. Effects play in a powerful and customizable XNA
                    framework. Most effects can be stacked and combined. An editor allowed our client to create
                    unique experiences with their own graphics and media.</p>


            </article>
            <article>
                <div class="youtubePlayer" data-id="0ND8xQoi4yg"></div>
                <br>

                <h3 class="major">Custom built laser cutter / engraver</h3>
                <p>This custom laser engraver can cut paper, vinyl, plastics, foam or thin wood sheets. It can
                    engrave most non-metal materials. Sporting a 3.8W blue diode laser and a 32bit control
                    board, it can handle any complex cutting job you throw at it. Built with a bottom-less
                    design allowing working any surface or part, even parts that are bigger than the unit
                    itself.</p>


            </article>

            <article>
                <div class="intrinsicContainer">
                    <div class="intrinsicWrapper">
                        <img
                                src="{{ imagePath }}/3d_print.jpg"
                                alt=""/>
                    </div>
                </div>
                <br>

                <h3 class="major">High resolution 3D print</h3>
                <p>3D printed on our high resolution 3D printer, this model can fit on a penny. The printer was
                    built in our lab and sports a maximum resolution of 40 micron on the XY axis and 20 on the
                    Z. Castable resin is also available, for creating metal objects.</p>

            </article>
            <article>
                <div class="intrinsicContainer">
                    <div class="intrinsicWrapper">
                        <iframe
                                src="https://sketchfab.com/models/89f374da58dc4a5d974bcaba16c68d7f/embed"
                                frameborder="0" allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true"
                                onmousewheel=""></iframe>
                    </div>
                </div>

                <p style="font-size: 13px; font-weight: normal; margin: 5px; color: #4A4A4A;"></p><br>


                <h3 class="major">3D Scan of a house</h3>
                <p>This 3D model of a house was reconstructed from 200 images, shot with a custom built
                    autonomous quadcopter.</p>

            </article>
        </section>
    </div>
</section>


<!-- Four -->
<section id="four" class="wrapper style1">
    <div class="inner">
        <h2 class="major">The Team</h2>
        <section class="features">
            <article>
                <a href="#" class="image"><img src="{{ imagePath }}/vice.png" alt=""/></a>
                <h3 class="major">Shachar "Vice" Weis</h3>
                <p>Shachar is a software developer with over 20 years of experience. He has worked in many
                    fields and disciplines, from ancient mainframes to tiny system-on-chip units. Shachar has
                    extensive experience with small board computer and low-power systems, 3D platforms like
                    OpenGL, DirectX, XNA and Three.JS. Shachar has dealt with first-tier customers like Disney,
                    Sears, GE and Mazda.<br><br>

                    Shachar usually goes by Vice, and is also a tinkerer, maker, 3d printing enthusiast and
                    photographer. Follow some of his projects on his blog <a
                            href="http://CallMeVice.com">CallMeVice.com</a>
                </p>


            </article>
            <article>
                <a href="#" class="image"><img src="{{ imagePath }}/lena.png" alt=""/></a>
                <h3 class="major">Lena Gorelick</h3>
                <p> Dr. Gorelick is currently a research scientist with the Computer Science Department at the
                    University of Western Ontario, London, Canada. Both her MSc (2004) and PhD (2009) are in
                    Computer Science and Applied Mathematics from the Weizmann Institute of Science, Israel.
                    During the past 16 years Lena has gained a lot of experience in various academic, military
                    and industrial fields. Lena's publications can be found on her website, <a
                            href="http://www.csd.uwo.ca/~ygorelic/">csd.uwo.ca/~ygorelic/</a><br><br>

                    Lena is also an artist and a jeweler, she has an <a
                            href="https://lenagorelick.wordpress.com/">art blog</a> and an Etsy store called <a
                            href="https://nunandnoot.etsy.com/">Nun&Noot</a>.</p>
            </article>

            <article>
                <a href="#" class="image"><img src="{{ imagePath }}/hossam.png" alt=""/></a>
                <h3 class="major">Hossam Issacs</h3>
                <p> Hossam is doing his post-doctorate at the Computer Science Department at the University of
                    Western Ontario, London, Canada. Publications and CV can be found on Hossam's website: <a
                            href="http://www.hisack.com/">hisack.com</a><br><br>
            </article>

            <article>
                <a href="#" class="image"><img src="{{ imagePath }}/sarah.jpg" alt=""/></a>
                <h3 class="major">Sarah Legault </h3>
                <p>Sarah is an award winning filmmaker, director, producer, animator and writer. Her first
                    stop-motion animation Dear Love earned the Best Animated Short Film award at the 2014
                    Toronto Independent Film Festival. Sarah recently teamed up with Canadian electro-goth band
                    Johnny Hollow to direct and animate their stop-motion music video Firefly. Since 2005, she
                    has won over 10 awards for her unique custom motorcycle paint work and participated in about
                    50 group exhibits in Toronto, Berlin, Krakow, or Los Angeles. Sarah’s work spans
                    illustration, stop-motion animation, doll making, painting, photography and curating
                    multimedia shows.</a></p>
            </article>


        </section>
    </div>
</section>

<section id="footer" class="wrapper alt style4">
    <div class="inner">
        <h2 class="major">Contact</h2>
        <p>We will be happy to answer any questions you might have and we'll create a white paper and a proposal
            for your project, free of charge and without commitment. </p>
        <ul class="contact">
            <li class="fa-envelope"><a href="mailto:Vice@Packet39.com">Vice@Packet39.com</a></li>
            <li class="fa-home">
                Packet39<br/>
                39 Raebrook Place<br/>
                London, ON, Canada<br/>
                N5X2Z8
            </li>
            <li class="fa-phone">519-902-6191</li>
            <li class="fa-twitter"><a href="https://twitter.com/Vice_Packet39">@Vice_Packet39</a></li>
            <li class="fa-wordpress"><a href="https://callmevice.com/">CallMeVice.com</a></li>
        </ul>

        <!--<form method="post" action="#">
            <div class="field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name"/>
            </div>
            <div class="field">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"/>
            </div>
            <div class="field">
                <label for="message">Message</label>
                <textarea name="message" id="message" rows="4"></textarea>
            </div>
            <ul class="actions">
                <li><input type="submit" value="Send Message"/></li>
            </ul>
        </form>-->

    </div>
</section>
{% endblock %}