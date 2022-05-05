<!DOCTYPE html>
<html lang="Ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="ريك النجاح في التجاة الإلكترونية داخل إفريقيا">
    <meta name="keywords" content="codafrica, COD AFRICA, cod mauritanie, الدفع عند الإستلام في إفريقيا, الدفع عند الإستلام في موريتانيا, shipsen, codinafrica, COD.NETWORK, CODAFRICA.NETWORK,">
    <meta name="author" content="CODAFRICA.NETWORK">
    <!-- Site Title -->
    <title>COD AFRICA NETWORK | شريك النجاح في التجاة الإلكترونية داخل إفريقيا</title>
    <!-- Site Favicon -->
    <link rel="shortcut icon" href="{{asset('assets/site/custom/images/favicon.ico')}}" type="image/ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/bootstrap-rtl.css')}}">
    <!-- Material Icon -->
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/materialdesignicons.css')}}">
    <!-- Carousel Slider -->
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/owl.carousel.css')}}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/magnific-popup.css')}}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/animate.css')}}">
    <!-- Custom  CSS -->
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/site/custom/css/colors/theme01.css')}}" id="option-color">
</head>

<body>
<!--Start Navbar-->
<nav class="navbar navbar-expand-lg fixed-top custom-nav sticky">
    <div class="container">
        <!-- MENU OVERLAY -->
        <div class="menu-overlay"></div>
        <!-- MENU CLOSE ICON -->
        <div class="menu-close-btn"><i class="mdi mdi-close-circle-outline"></i></div>
        <!-- LOGO -->
        <a class="navbar-brand brand-logo mr-4" href="{{route('site.home')}}">
            <img src="{{asset('assets/site/custom/images/logo.png')}}" class="img-fluid logo-light" alt="">
            <img src="{{asset('assets/site/custom/images/logo-dark.png')}}" class="img-fluid logo-dark" alt="">
        </a>
        <div class="navbar-collapse collapse justify-content-center" id="navbarCollapse">
            <ul class="navbar-nav navbar-center" id="mySidenav">
                <li class="nav-item active">
                    <a href="{{route('site.home')}}#home" class="nav-link">رئيسية</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('site.home')}}#services" class="nav-link">خدمات</a>
                </li>
                <!--
                <li class="nav-item">
                    <a href="#howitworks" class="nav-link">How it Work</a>
                </li>

                <li class="nav-item">
                    <a href="#client" class="nav-link">Client</a>
                </li>
                -->
                <li class="nav-item">
                    <a href="{{route('site.home')}}#price" class="nav-link">سعر</a>
                </li>

                <li class="nav-item">
                    <a href="{{route('site.home')}}#footer" class="nav-link">من نحن
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('site.home')}}#contactus" class="nav-link">تواصل معنا</a>
                </li>
                <li class="nav-item">
                    <a href="{{route('site.join_us')}}" class="nav-link">أبدا الان</a>
                </li>

            </ul>

        </div>
        <div class="contact_btn ml-1">
            <a href="{{route('auth.login')}}" class="btn btn-sm">تسجيل الدخول</a>
            <button class="navbar-toggler ml-2 p-0" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>

    </div>

</nav>

@yield('content')


<footer class="footer theme-bg overflow-hidden pb-4">
    <section id="footer">
        <div class="container footer-bottom">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-30 m-lg-0">
                        <div class="foot_logo">
                            <img src="{{asset('assets/site/custom/images/logo.png')}}" class="img-fluid d-block" alt="">
                        </div>
                        <p class="mt-4 text-left ftr-about">COD Africa شركة متخصصة في مجال التجارة الإلكترونية
                            تقدم مجموعة من الخدمات المميزة و المتنوعة في مجموعة من الدول الإفريقيا
                            من بينها التصدير و الإستراد التخزين و التغليف مركز إتصال توصيل الطلبيات و تحصيل الأموالل</p>
                        <div class="mt-4">
                            <ul class="fot_social list-inline mt-4">
                                <li class="list-inline-item"><a href="#" class="social-icon"><i class="mdi mdi-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#" class="social-icon"><i class="mdi mdi-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="#" class="social-icon"><i class="mdi mdi-whatsapp"></i></a></li>
                                <li class="list-inline-item"><a href="#" class="social-icon"><i class="mdi mdi-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4">
                    <h5 class="footer-title">روابط</h5>
                    <ul class="footer_menu_list list-unstyled mb-0 mt-4">
                        <!--
                        <li class="nav-item">
                            <a href="#client" class="nav-link">Client</a>
                        </li>
                        -->
                        <li><a href="#home">الرئيسية</a></li>
                        <li><a href="#services">خدمات</a></li>
                        <li><a href="#price">سعر</a></li>
                        <li><a href="#faq">أسئلة</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-sm-4">
                    <h5 class="footer-title">دعم</h5>
                    <ul class="footer_menu_list list-unstyled mb-0 mt-4">
                        <li><a href="#contactus">دعم و مساعدة</a></li>
                        <li><a href="#">سياسة الخصوصية </a></li>
                        <li><a href="#">شروط و أحكام</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <h5 class="footer-title">تواصل معنا</h5>
                    <ul class="footer_menu_list list-unstyled mb-0 mt-4 contact-menu-list">
                        <!--
                        <li>
                             <i class="md-icon mdi mdi-map-marker"></i>
                             <a href="https://www.google.com/maps" target="_blank">
                                 555 NOrth Orchard Street
                                 Kings Mountain, NY 28086
                             </a>
                         </li>
                         -->
                        <li><i class="md-icon mdi mdi-email-outline"></i><a href="contact@codafrica.network">contact@codafrica.network</a></li>
                        <li><i class="md-icon mdi mdi-phone-in-talk"></i><a href="tel:+212666738995">212666738995</a></li>
                        <li><i class="md-icon mdi mdi-phone-in-talk"></i><a href="tel:+212660497180">212660497180</a></li>
                    </ul>
                </div>
                <div class="col-lg-12">
                    <div class="foot_desc mt-4 pt-4">
                        <p class="mb-0 text-center">2022 &copy; <span class="text-white font-weight-bold">COD AFRICA</span> </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</footer>
<!-- End Footer -->
<!-- Back To Top -->
<a href="#" class="back_top"> <i class="mdi mdi-chevron-up"></i></a>
<!-- Javascript -->
<script src="{{asset('assets/site/custom/js/jquery.js')}}"></script>
<script src="{{asset('assets/site/custom/js/popper.js')}}"></script>
<script src="{{asset('assets/site/custom/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/site/custom/js/jquery.easing.js')}}"></script>
<script src="{{asset('assets/site/custom/js/owl.carousel.js')}}"></script>
<script src="{{asset('assets/site/custom/js/wow.js')}}"></script>
<script src="{{asset('assets/site/custom/js/particles.js')}}"></script>
<script src="{{asset('assets/site/custom/js/jquery.magnific-popup.js')}}"></script>
<!-- Main Js   -->
<script src="{{asset('assets/site/custom/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
