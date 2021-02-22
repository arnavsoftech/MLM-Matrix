<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>The Smartlife : Your dreams come true</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/bootstrap.min.css">
    <!-- Animation-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/animate.css">
    <!-- Morris CSS -->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/morris.css">
    <!-- FontAwesome-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/font-awesome.min.css">
    <!-- Icon font-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/icon-font.css">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/owl.carousel.min.css">
    <!-- Owl Theme -->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/owl.theme.default.min.css">
    <!-- Colorbox-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/colorbox.css">
    <!-- Template styles-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/style.css">
    <!-- Responsive styles-->
    <link rel="stylesheet" href="<?= theme_url(); ?>css/responsive.css">
    <script type="text/javascript" src="<?= theme_url(); ?>js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script>
        var ApiUrl = '<?= site_url('home/call/'); ?>';
    </script>

</head>

<body>
    <div class="site-top-2">

        <div class="top-bar highlight" id="top-bar">

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-md-9 col-sm-12">

                        <ul class="top-info">

                            <li><span class="info-icon"><i class="icon icon-phone3"></i></span>

                                <div class="info-wrapper">

                                    <p class="info-title">(+91)99344-19465</p>

                                </div>

                            </li>

                            <li><span class="info-icon"><i class="icon icon-envelope"></i></span>

                                <div class="info-wrapper">

                                    <p class="info-title">info@thesmartlife.in</p>

                                </div>

                            </li>

                            <li class="last"><span class="info-icon"><i class="icon icon-map-marker2"></i></span>

                                <div class="info-wrapper">

                                    <p class="info-title">address</p>

                                </div>

                            </li>

                        </ul>

                    </div>

                    <!-- Top info end-->

                    <div class="col-lg-3 col-md-3 col-sm-12 text-lg-right text-md-center">

                        <ul class="top-social">

                            <li>

                                <a title="Facebook" href="#">

                                    <span class="social-icon"><i class="fa fa-facebook"></i></span>

                                </a>

                                <a title="Twitter" href="#">

                                    <span class="social-icon"><i class="fa fa-twitter"></i></span>

                                </a>

                                <a title="fa-instagram" href="#">

                                    <span class="social-icon"><i class="fa fa-instagram"></i></span>

                                </a>

                            </li>

                            <!-- List End -->

                        </ul>

                        <!-- Top Social End -->

                    </div>

                    <!--Col end-->

                </div>

                <!-- Content row end-->

            </div>

            <!-- Container end-->

        </div>

        <!-- Top bar end-->



        <header class="header-standard header-light" id="header">

            <div class="container">

                <div class="site-nav-inner">

                    <nav class="navbar navbar-expand-lg">

                        <div class="navbar-brand navbar-header">

                            <div class="logo">

                                <a href="<?= site_url() ?>">

                                    <img src="<?= theme_url('images/logo.png'); ?>" style="height: 50px;" class="img-resposive" />

                                </a>

                            </div>

                            <!-- logo end-->

                        </div>

                        <!-- Navbar brand end-->

                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"><i class="icon icon-menu"></i></span></button>

                        <!-- End of Navbar toggler-->

                        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li><a href="<?= site_url(); ?>">Home</a></li>
                                <li><a target="_blank" href="<?= theme_url('images/the-smart-life-plan.pdf'); ?>">Plans</a></li>
                                <li><a href="<?= site_url('contact-us'); ?>">Contact us</a></li>
                                <li><a href="<?= site_url('login'); ?>">Login</a></li>
                                <li><a href="<?= site_url('register'); ?>">Register</a></li>
                            </ul>
                            <!--Nav ul end-->
                        </div>
                    </nav>

                </div>

                <!-- Site nav inner end-->

            </div>

            <!-- Container end-->

        </header>

        <!-- Header end-->

    </div>
    <?php $this->load->front_view($main); ?>
    <!-- Footer start-->

    <footer class="footer" id="footer">

        <div class="footer-top">

            <div class="container">

                <div class="footer-top-bg row">

                    <div class="col-lg-4 footer-box"><i class="icon icon-map-marker2"></i>

                        <div class="footer-box-content">

                            <h3>Office</h3>

                            <p>address</p>

                        </div>

                    </div>

                    <!-- Box 1 end-->

                    <div class="col-lg-4 footer-box"><i class="icon icon-phone3"></i>

                        <div class="footer-box-content">

                            <h3>Call Us</h3>

                            <p>(+91)000000000</p>

                        </div>

                    </div>

                    <!-- Box 2 end-->

                    <div class="col-lg-4 footer-box"><i class="icon icon-envelope"></i>

                        <div class="footer-box-content">

                            <h3>Mail Us</h3>

                            <p>mail@example.com</p>

                        </div>

                    </div>

                    <!-- Box 3 end-->

                </div>

                <!-- Content row end-->

            </div>

            <!-- Container end-->

        </div>

        <!-- Footer top end-->

        <div class="footer-main bg-overlay">

            <div class="container">

                <div class="row">

                    <div class="col-lg-4 col-md-12 footer-widget footer-about">

                        <div class="footer-logo">

                            <a href="index.html">

                                <img src="images/logo.png" alt="">

                            </a>

                        </div>

                        <p>We are a awward winning multinational company. We believe in quality and standard worldwide.</p>

                        <div class="footer-social">

                            <ul>

                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>

                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>

                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>

                            </ul>

                        </div>

                        <!-- Footer social end-->

                    </div>

                    <!-- About us end-->

                    <div class="col-lg-4 col-md-12 footer-widget">

                        <h3 class="widget-title">Useful Links</h3>

                        <ul class="list-dash">

                            <li><a href="#">About Us</a></li>

                            <li><a href="#">Our Services</a></li>

                            <li><a href="#">Projects</a></li>

                            <li><a href="#">Our Team</a></li>

                            <li><a href="#">Career</a></li>

                            <li><a href="#">Our Blog</a></li>

                            <li><a href="#">Why Need Agent?</a></li>

                            <li><a href="#">Investments</a></li>

                            <li><a href="#">Consultation</a></li>

                            <li><a href="#">Contact Us</a></li>

                        </ul>

                    </div>

                    <div class="col-lg-4 col-md-12W footer-widget">

                        <h3 class="widget-title">Subscribe</h3>

                        <div class="newsletter-introtext">Don’t miss to subscribe to our new feeds, kindly fill the form below.</div>

                        <form class="newsletter-form" id="newsletter-form" action="#" method="post">

                            <div class="form-group">

                                <input class="form-control form-control-lg" id="newsletter-form-email" type="email" name="email" placeholder="Email Address" autocomplete="off">

                                <button class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>

                            </div>

                        </form>

                    </div>

                </div>

                <!-- Content row end-->

            </div>

            <!-- Container end-->

        </div>

        <!-- Footer Main-->

        <div class="copyright">

            <div class="container">

                <div class="row">

                    <div class="col-lg-6 col-md-12">

                        <div class="copyright-info"><span>Copyright © 2021 Smartlife. All Rights Reserved.</span></div>

                    </div>

                    <div class="col-lg-6 col-md-12">

                        <div class="footer-menu">

                            <ul class="nav unstyled">

                                <li><a href="#">About</a></li>

                                <li><a href="#">Privacy Policy</a></li>

                                <li><a href="#">Investors</a></li>

                                <li><a href="#">Legals</a></li>

                                <li><a href="#">Contact</a></li>

                            </ul>

                        </div>

                    </div>

                </div>

                <!-- Row end-->

            </div>

            <!-- Container end-->

        </div>

        <!-- Copyright end-->

    </footer>

    <!-- Footer end-->

    <div class="back-to-top affix" id="back-to-top" data-spy="affix" data-offset-top="10">

        <button class="btn btn-primary" title="Back to Top"><i class="fa fa-angle-double-up"></i>

            <!-- icon end-->

        </button>

        <!-- button end-->

    </div>
    <!-- End Back to Top-->

    <!--
      Javascript Files
      ==================================================
      -->
    <!-- initialize jQuery Library-->

    <!-- Popper-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/popper.min.js"></script>
    <!-- Bootstrap jQuery-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/bootstrap.min.js"></script>
    <!-- Owl Carousel-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/owl.carousel.min.js"></script>
    <!-- Counter-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/jquery.counterup.min.js"></script>
    <!-- Waypoints-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/waypoints.min.js"></script>
    <!-- Color box-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/jquery.colorbox.js"></script>
    <!-- Smoothscroll-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/smoothscroll.js"></script>
    <!-- Google Map API Key-->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCsa2Mi2HqyEcEnM1urFSIGEpvualYjwwM"></script>
    <!-- Google Map Plugin-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/gmap3.js"></script>
    <!-- Template custom-->
    <script type="text/javascript" src="<?= theme_url(); ?>js/custom.js"></script>
    </div>
    <!--Body Inner end-->
</body>

</html>