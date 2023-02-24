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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
                    <a href="#home" class="nav-link">رئيسية</a>
                </li>
                <li class="nav-item">
                    <a href="#services" class="nav-link">خدمات</a>
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
                    <a href="#price" class="nav-link">سعر</a>
                </li>

                <li class="nav-item">
                    <a href="#footer" class="nav-link">من نحن
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#contactus" class="nav-link">تواصل معنا</a>
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

<!-- End Navbar -->
<!-- Home Start-->
<section class="theme-bg overflow-hidden home-section" id="home">
    <div id="particles-js">
    </div>
    <div class="waves-bg-img home-bg">
        <div class="container">
            <div class="owl-carousel owl-theme main-slider">
                <div class="item">
                    <div class="row align-items-center">
                        <div class="col-lg-6">

                            <div class="content-fadeInUp">
                                <h2 class="heading">
                                    تريد تطوير تجارتك الإلكترونية من خلال الإنفتاح على الأسواق الإفريقيا؟
                                </h2>
                                <p class="para-txt">
                                    أنت في المكان الصحيح، COD AFRICA أفضل شريك للنجاح داخل القارة السمراء.
                                </p>
                                <div class="learn-more">
                                    <a href="{{route('site.join_us')}}" class="btn btn-white rounded-pill text-white">إبدأ الآن
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="img-fadeInRight">
                                <img src="{{asset('assets/site/custom/images/slider-img/02.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="item">
                     <div class="row align-items-center">
                         <div class="col-lg-6">
                             <div class="content-fadeInUp">
                                 <h2 class="heading">
                                    يلينسكي .. من وجه كوميدي تلفزيوني إلى رئيس يتصدى للجيش الروسي
                                 </h2>
                                 <p class="para-txt">
                                    يلينسكي .. من وجه كوميدي وني إلى رئيس يتصدى للجيش الروسي
                                 </p>
                                 <div class="learn-more">
                                     <a href="#aboutus" class="btn btn-white rounded-pill text-white">Learn More</a>
                                 </div>
                             </div>
                         </div>
                         <div class="col-lg-6">
                             <div class="img-fadeInRight">
                                 <img src="images/slider-img/02.png" class="img-fluid" alt="">
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     -->
</section>
<!-- Home End -->
<!-- Start About -->
<section class="section features-section overflow-hidden" id="aboutus">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-5 d-flex">
                <div class=" mb-30 m-md-0 position-relative wow fadeIn" data-wow-duration="1500ms">
                    <img src="{{asset('assets/site/custom/images/video-1-1.jpg')}}" class="w-100 shape-radius" alt="">
                    <a href="{{asset('assets/site/custom/images/video.mp4')}}" class="video-link video-btn d-flex align-items-center justify-content-center"><i class="mdi mdi-play"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-7">
                <div class="wow fadeIn" data-wow-duration="1500ms">
                    <div class="section-title text-left">
                        <p>لماذا COD AFRICA ؟  </p>
                        <h3>لماذا أختار الشراكة مع COD AFRICA ؟</h3>
                    </div>
                    <div class="box-wrap">
                        <h1 class=" font-20 mb-4">ننقدم لكم مجموعة من الخدمات الإحترافية التي تتطو بإستمرار من أجل مساعدتكم على النمو </h1>
                        <div class="info-box">
                            <div class="ico-bg">
                                <i class="icon mdi mdi-rocket"></i>
                            </div>
                            <div class="content-txt">
                                <h3>نسبة تحويل مرتفعة</h3>
                                <p>
                                    بفضل إحترافية مركز إتصالنا و فريق التوصيل نقدم لكم معدل تأكيد و توصيل طلبيات ممتاز و متطور بإستمرار

                                </p>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="ico-bg">
                                <i class="icon mdi mdi-collage"></i>
                            </div>
                            <div class="content-txt">
                                <h3>خدمات ذات جودة بأفضل سعر</h3>
                                <p>
                                    نقدم لكم خدمات بجودة ممتازة بأسعار تنافسية غير موجودة في السوق
                                </p>
                            </div>
                        </div>
                        <div class="info-box">
                            <div class="ico-bg">
                                <i class="icon mdi mdi-bullhorn"></i>
                            </div>
                            <div class="content-txt">
                                <h3>أفضل خدمة دعم و تطوير مستمر للخدمات</h3>
                                <p>
                                    نقدم لكم مجموعة من الخدمات الإحترافية التي نطورها بإستمرار من أجل مساعدتكم على تطوير تجارتكم
                                </p>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('site.join_us')}}" class="btn btn-sm theme-btn mt-5">إبدأ الآن</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About -->
<!-- Start Services-->
<section class="section bg-light pb-60" id="services">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="service-box-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="service-box">
                                <div class="steps-hover-thumb"></div>
                                <div class="service-txt z-index-9">
                                    <div class="service-icon">
                                        <i class="mdi mdi-desktop-mac-dashboard"></i>
                                    </div>
                                    <h3>توريد</h3>
                                    <p class="m-0">
                                        نوفر لكم موردين من المغرب و الإمارات و الصين بالإضافة إلى الشحن و الجمركة
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-box">
                                <div class="steps-hover-thumb"></div>
                                <div class="service-txt z-index-9">
                                    <div class="service-icon">
                                        <i class="mdi mdi-responsive"></i>
                                    </div>
                                    <h3>تخزين</h3>
                                    <p class="m-0">
                                        نوفر لكم خدمة إستقبال التخزين و التغليف السلع مجانا
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-box">
                                <div class="steps-hover-thumb"></div>
                                <div class="service-txt z-index-9">
                                    <div class="service-icon">
                                        <i class="mdi mdi-rocket"></i>
                                    </div>
                                    <h3>فريق توصيل الطلبيات</h3>
                                    <p class="m-0">
                                        نقدم لكم خدمة توصيل سريع وإحترافي في أقل من 24 ساعة وبسعر تنافسي بالإضافة إلى أنك لاتفع إلا مقابل الطلبات المسلمة
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="service-box">
                                <div class="steps-hover-thumb"></div>
                                <div class="service-txt z-index-9">
                                    <div class="service-icon">
                                        <i class="mdi mdi-headphones-settings"></i>
                                    </div>
                                    <h3>مركز إتصال  </h3>
                                    <p class="m-0">
                                        نقدم لكم خدمة تأكيد طلبيات إحترافية وفعالة وبسعر تنافسي بالإضافة إلى أنك لاتفع إلا مقابل الطلبات المسلمة

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="section-title text-left">
                    <p>خدماتنا</p>
                    <h3>
                        نقدم لك خدمات متميزة بأسعار مميزة
                    </h3>
                </div>
                <p>
                    نقدم لكم مجموعة من الخدمات الإحترافية التي تتطو بإستمرار من أجل مساعدتكم على النمو بالإضافة إلى نسب تحويل عالية و كل هذا مقابل أسعار غير قابلة للمنافسة
                </p>
                <a href="{{route('site.join_us')}}" class="btn btn-sm theme-btn mt-md-5 mt-4">إبدأ الآن</a>
            </div>

        </div>
    </div>
</section>
<!-- End Services -->
<!-- Start How-it-Work -->
<section class="section" id="howitworks">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <p>ماهي طريقة الإشتغال معكم؟</p>
                    <h3>الأمر سهل</h3>
                </div>
            </div>
        </div>
        <div class="how-works-block">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="how-works-box mb-4 m-md-0 wow fadeInUp" data-wow-duration="1500ms">
                        <img src="{{asset('assets/site/custom/images/works/1.png')}}" class="img-fluid mx-auto d-block" alt="">
                        <div class="text-center">
                            <h4 class="mt-4">1 أطلق حملتك الإشهارية</h4>
                            <!--
                            <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                        -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="how-works-box mb-4 m-md-0 wow fadeInUp" data-wow-duration="1500ms">
                        <img src="{{asset('assets/site/custom/images/works/2.png')}}" class="img-fluid mx-auto d-block" alt="">
                        <div class="text-center">
                            <h4 class="mt-4">2 تابع تأكيد و تسليم الطلبيات</h4>
                            <!--
                                                            <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                                                        -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="how-works-box m-box-0 wow fadeInUp" data-wow-duration="1500ms">
                        <img src="{{asset('assets/site/custom/images/works/3.png')}}" class="img-fluid mx-auto d-block" alt="">
                        <div class="text-center">
                            <h4 class="mt-4">3 إستلم أموالك</h4>
                            <!--
                            <p class="mb-0">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                        -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End How-it-Work -->
<!-- Start Counter -->
<!---
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box mb-30 m-md-0">
                    <div class="counter-icons d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-collage"></i>
                    </div>
                    <h3>
                        <span class="counter odometer" data-count="2500">0</span>+
                    </h3>
                    <p>Project</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box mb-30 m-md-0">
                    <div class="counter-icons d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-account-group"></i>
                    </div>
                    <h3><span class="counter odometer" data-count="2000">0</span>+</h3>
                    <p>Satisfied Clients</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box mb-30 m-sm-0">
                    <div class="counter-icons d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-trophy"></i>
                    </div>
                    <h3>
                        <span class="counter odometer" data-count="100">0</span>
                    </h3>
                    <p>Win Awards</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6">
                <div class="counter-box">
                    <div class="counter-icons d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-account-outline"></i>
                    </div>
                    <h3><span class="counter odometer" data-count="100">0</span>+</h3>
                    <p>Team Member</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Counter -->
<!-- Start Testimonial -->
<!--
<section class="section parallax-section" id="client">
   <div class="container">
       <div id="particles-js1">
       </div>
       <div class="container">
           <div class="row">
               <div class="col-lg-12">
                   <div class="section-title text-center ">
                       <p class="text-white">OUR TESTIMONIALS</p>
                       <h3 class="text-white">
                           Our Client’s Say
                       </h3>
                   </div>
               </div>
           </div>
           <div class="row">
               <div class="col-lg-12">
                   <div class="owl-carousel owl-theme testimonial-slider wow fadeIn" data-wow-duration="1000ms">
                       <div class="item">
                           <div class="testimonial-card shadow-md">
                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                           </div>
                           <div class="user-txt">
                               <div class="user-pics"><img src="images/testi/testi-1.png" alt=""></div>
                               <div class="use-info">
                                   <h6 class="heading text-white">Jack Jordan</h6>
                                   <p class="sub-heading text-white">Mediapp User</p>
                               </div>
                           </div>
                       </div>
                       <div class="item">
                           <div class="testimonial-card shadow-md">
                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                           </div>
                           <div class="user-txt">
                               <div class="user-pics"><img src="images/testi/testi-1.png" alt=""></div>
                               <div class="user-info">
                                   <h6 class="heading text-white">Jack Jordan</h6>
                                   <p class="sub-heading text-white">Mediapp User</p>
                               </div>
                           </div>
                       </div>
                       <div class="item">
                           <div class="testimonial-card shadow-md">
                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                           </div>
                           <div class="user-txt">
                               <div class="user-pics"><img src="images/testi/testi-1.png" alt=""></div>
                               <div class="user-info">
                                   <h6 class="heading text-white">Jack Jordan</h6>
                                   <p class="sub-heading text-white">Mediapp User</p>
                               </div>
                           </div>
                       </div>
                       <div class="item">
                           <div class="testimonial-card shadow-md">
                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                           </div>
                           <div class="user-txt">
                               <div class="user-pics"><img src="images/testi/testi-1.png" alt=""></div>
                               <div class="user-info">
                                   <h6 class="heading text-white">Jack Jordan</h6>
                                   <p class="sub-heading text-white">Mediapp User</p>
                               </div>
                           </div>
                       </div>
                       <div class="item">
                           <div class="testimonial-card shadow-md">
                               <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,</p>
                           </div>
                           <div class="user-txt">
                               <div class="user-pics"><img src="images/testi/testi-1.png" alt=""></div>
                               <div class="user-info">
                                   <h6 class="heading text-white">Jack Jordan</h6>
                                   <p class="sub-heading text-white">Mediapp User</p>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
</section>
<!-- End Testimonial -->
<!-- Start Price -->
<section class="section" id="price">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center ">
                    <p>باقاتنا</p>
                    <h3>
                        سعر الإشتراك
                    </h3>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="pricing-item m-lg-0 wow fadeIn" data-wow-delay="0s" data-wow-duration="1500ms">
                    <div class="pricing-deco">
                        <svg class="pricing-deco-img" version="1.1" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="100px" viewBox="0 0 300 100" enable-background="new 0 0 300 100" xml:space="preserve">
                            <path class="deco-layer deco-layer--1" opacity="0.6" fill="#FFFFFF" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729
	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" />















                            <path class="deco-layer deco-layer--2" opacity="0.6" fill="#FFFFFF" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729
	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" />















                            <path class="deco-layer deco-layer--3" opacity="0.7" fill="#FFFFFF" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716
	H42.401L43.415,98.342z" />















                            <path class="deco-layer deco-layer--4" fill="#FFFFFF" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428
	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" />















                        </svg>
                        <div class="pricing-price"><span class="pricing-currency">درهم</span>350<span class="pricing-period">/ للشهر</span></div>
                        <h3 class="pricing-title">الأداء كل شهر</h3>
                    </div>
                    <ul class="pricing-feature-list">
                        <li class="pricing-feature">أستراد</li>
                        <li class="pricing-feature">تخزين</li>
                        <li class="pricing-feature">تغليف</li>
                        <li class="pricing-feature">مركز إتصال</li>
                        <li class="pricing-feature">فريق توصيل</li>
                        <li class="pricing-feature">إرسال أموال أسبوعي</li>
                    </ul>
                    <div class="choose-box">
                        <a class="btn theme-btn d-block w-100" href="{{route('site.join_us')}}">إبدأ الآن</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="pricing-item m-lg-0 wow fadeIn" data-wow-delay="0s" data-wow-duration="1500ms">
                    <div class="pricing-deco">
                        <svg class="pricing-deco-img" version="1.1" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="100px" viewBox="0 0 300 100" enable-background="new 0 0 300 100" xml:space="preserve">
                            <path class="deco-layer deco-layer--1" opacity="0.6" fill="#FFFFFF" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729
	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" />















                            <path class="deco-layer deco-layer--2" opacity="0.6" fill="#FFFFFF" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729
	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" />















                            <path class="deco-layer deco-layer--3" opacity="0.7" fill="#FFFFFF" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716
	H42.401L43.415,98.342z" />















                            <path class="deco-layer deco-layer--4" fill="#FFFFFF" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428
	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" />















                        </svg>
                        <div class="pricing-price"><span class="pricing-currency">درهم</span>300<span class="pricing-period">/ للشهر</span></div>
                        <h3 class="pricing-title">الأداء كل 3 أشهر</h3>
                    </div>
                    <ul class="pricing-feature-list">
                        <li class="pricing-feature">أستراد</li>
                        <li class="pricing-feature">تخزين</li>
                        <li class="pricing-feature">تغليف</li>
                        <li class="pricing-feature">مركز إتصال</li>
                        <li class="pricing-feature">فريق توصيل</li>
                        <li class="pricing-feature">إرسال أموال أسبوعي</li>
                    </ul>
                    <div class="choose-box">
                        <a class="btn theme-btn d-block w-100" href="{{route('site.join_us')}}">إبدأ الآن</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 ">
                <div class="pricing-item m-lg-0 wow fadeIn" data-wow-delay="0s" data-wow-duration="1500ms">
                    <div class="pricing-deco">
                        <svg class="pricing-deco-img" version="1.1" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="300px" height="100px" viewBox="0 0 300 100" enable-background="new 0 0 300 100" xml:space="preserve">
                            <path class="deco-layer deco-layer--1" opacity="0.6" fill="#FFFFFF" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729
	c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" />















                            <path class="deco-layer deco-layer--2" opacity="0.6" fill="#FFFFFF" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729
	c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" />















                            <path class="deco-layer deco-layer--3" opacity="0.7" fill="#FFFFFF" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716
	H42.401L43.415,98.342z" />















                            <path class="deco-layer deco-layer--4" fill="#FFFFFF" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428
	c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" />















                        </svg>
                        <div class="pricing-price"><span class="pricing-currency">درهم</span>250<span class="pricing-period">/للشهر</span></div>
                        <h3 class="pricing-title">الأداء كل 6 أشهر</h3>
                    </div>
                    <ul class="pricing-feature-list">
                        <li class="pricing-feature">أستراد</li>
                        <li class="pricing-feature">تخزين</li>
                        <li class="pricing-feature">تغليف</li>
                        <li class="pricing-feature">مركز إتصال</li>
                        <li class="pricing-feature">فريق توصيل</li>
                        <li class="pricing-feature">إرسال أموال أسبوعي</li>
                    </ul>
                    <div class="choose-box">
                        <a class="btn theme-btn d-block w-100" href="{{route('site.join_us')}}"> إبدأ الآن</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Price -->
<!-- Start FAQ's -->
<section id="faq" class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center ">
                    <p>أسئلة</p>
                    <h3>
                        أسئلة شائعة
                    </h3>
                </div>
            </div>
        </div>
        <div class="row align-items-center">

            <div class="col-md-6">
                <div class="wow fadeIn m-center-img" data-wow-duration="1500ms">
                    <img src="{{asset('assets/site/custom/images/faqs.png')}}" class="w-100" alt="">
                </div>
            </div>
            <div class="col-md-6">
                <div id="accordion" class="faq-accordion-panel wow fadeIn" data-wow-duration="1500ms">
                    <div class="question-card shadow-sm active">
                        <div class="card-header p-0" id="headingOne">
                            <h4 class="mb-0">
                                <button class="btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><span>1. ماهي الدول المتاحة حاليا؟</span><span><i class="mdi mdi-menu-down caret-icon"></i></span></button>
                            </h4>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>حاليا موريتانيا هي أول دولة متاحة و في الأشهر القليلة القادمة ستكون خدمتنا متاحة في دولتين جديدتين هما الآن قيد التجريب
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="question-card shadow-sm">
                        <div class="card-header p-0" id="headingTwo">
                            <h4 class="mb-0">
                                <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><span>2. هل يمكن لشخص ما أن يطلع على بيانات طلبياتي؟</span><span><i class="mdi mdi-menu-down caret-icon"></i></span></button>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    لا يمكن حدوث ذلك قطعا لأن ذلك سيضر بخدمتنا قبل أن يضر بشركائنا ولأن نجاحكم هو نجاحنا
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="question-card shadow-sm">
                        <div class="card-header p-0" id="headingThree">
                            <h4 class="mb-0">
                                <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><span>3. كيف و متى يتم تحويل أموالي؟</span><span><i class="mdi mdi-menu-down caret-icon"></i></span></button>
                            </h4>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    يتم تحويل أمواك بشكل دوري كل  أسبوع مباشرة في حسابكم البنكي كما نقدم لكم فاتورة تفصيلية
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="question-card shadow-sm">
                        <div class="card-header p-0" id="headingFour">
                            <h4 class="mb-0">
                                <button class="btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"><span>4. هل سعر الإشتراك لكل الدول أم فقط لدولة واحدة؟</span><span><i class="mdi mdi-menu-down caret-icon"></i></span></button>
                            </h4>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    الإشتراك هو لكل دول إفريقيا و ليس لمجرد دولة واحدة
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End FAQ's -->
<!-- Start Contact Us -->
<section class="section" id="contactus">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center ">
                    <p>نجيبك في نفس اليوم</p>
                    <h3>
                        تواصل معنا
                    </h3>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="contact-bg mb-30 m-lg-0 wow fadeIn" data-wow-duration="1500ms">
                    <div class="contact-box-inner">
                        <div>
                            <h3>ههل تريد الإشتراك أوتحتاج المساعدة أو لديك أيإستفسار؟</h3>
                            <p>
                                سوف نكون سعداء بالإجابة هاتفيا على مراسلتكم في أقل من 24 ساعة
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <form class="contact-form wow fadeIn" data-wow-duration="1500ms">
                    <h3>المرجوا ملء الإستمارة من أجل التواصل معنا</h3>
                    <p>
                        سوف نتصل بكم في أقل من 24 ساعة
                    </p>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <i class="input-icons mdi mdi-account-outline"></i>
                                <input type="text" class="form-control" name="name" placeholder="الإسم" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <i class="input-icons mdi mdi-email-outline"></i>
                                <input type="text" class="form-control" name="email" placeholder="البريد الإلكتروني " required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <i class="input-icons mdi mdi-chevron-down"></i>
                                <select class="selectpicker form-control" name="service">
                                    <option value="">أريد الإشتراك</option>
                                    <option value="#">أريد الإستفسار</option>
                                    <option value="">أحتاج الدعم الفني</option>
                                    <option value="">أموضوع آخر</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <i class="input-icons mdi mdi-phone-outline"></i>
                                <input type="text" class="form-control" placeholder="الهاتف" name="phone" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <i class="textarea-icons mdi mdi-pencil-outline"></i>
                                <textarea placeholder="يمكنك كتابة التفاصيل هنا" class="form-control" name="message" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button class="btn theme-btn">إرسال</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us -->
<!-- Start Footer -->
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
                    <ul class="footer_menu_list list-unstyled mb-0 mt-4 contact-menu-list" >
                        <!--
                        <li>
                             <i class="md-icon mdi mdi-map-marker"></i>
                             <a href="https://www.google.com/maps" target="_blank">
                                 555 NOrth Orchard Street
                                 Kings Mountain, NY 28086
                             </a>
                         </li>
                         -->
                        <li ><i class="md-icon mdi mdi-email-outline"></i><a href="contact@codafrica.network">contact@codafrica.network</a></li>
                        <li ><i class="md-icon mdi mdi-phone-in-talk"></i><a style="direction: ltr;" href="tel:+212666738995">21 26 66 73 89 95</a></li>
                        <li><i class="md-icon mdi mdi-phone-in-talk"></i><a  style="direction: ltr;" href="tel:+212660497180">21 26 60 49 71 80</a></li>
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
</body>

</html>
