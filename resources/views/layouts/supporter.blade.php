<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    @if(LaravelLocalization::getCurrentLocale() == 'ar')
        <title>تتبع الطلبات</title>
    @else
        <title>Tracking Orders</title>
        <meta name="_token" content="{{csrf_token()}}" />

    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('styleChart')
<!-- App favicon -->
    <link rel="shortcut icon" href="{{asset("assets/admin/images/logo.png")}}">
    <!-- Bootstrap Css -->
    <link href="{{asset("assets/admin/css/bootstrap.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{asset("assets/admin/css/icons.min.css")}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    @yield("style")
    <link href="{{asset("assets/admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("assets/admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("assets/admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css")}}" rel="stylesheet" type="text/css"/>

    @if(LaravelLocalization::getCurrentLocale() == 'ar')

        <link href="{{asset("assets/admin/css/app-rtl.css")}}" rel="stylesheet" type="text/css"/>
    @else
        <link href="{{asset("assets/admin/css/app.css")}}" rel="stylesheet" type="text/css"/>
        <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    @endif

</head>

<body data-sidebar="dark">

<!-- Loader -->
<div id="preloader">
    <div id="status">
        <div class="spinner"></div>
    </div>
</div>

<!-- Begin page -->
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{route('supporter.home')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset("assets/admin/images/1.png")}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset("assets/admin/images/1.png")}}" alt="" height="36">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                    <i class="mdi mdi-menu"></i>
                </button>

                <div class="d-none d-sm-block ml-2">
                    <h4 class="page-title">@yield('pageTitle')</h4>
                </div>
            </div>

            <!-- Search input -->
            <div class="search-wrap" id="search-wrap">
                <div class="search-bar">
                    <form method="post" action="" enctype="multipart/form-data">
                        @csrf
                        <input class="search-input form-control" name="name" placeholder="Search" />
                    </form>
                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                        <i class="mdi mdi-close-circle"></i>
                    </a>
                </div>
            </div>
            <div class="d-flex">
                <div class="dropdown d-inline-block mr-3 h6">

                    <a class="btn    h3 btn-dark mt-3 mr-4"  style="font-weight: bolder" href="{{route('supporter.getOrder')}}" >
                        Get Order
                    </a>
                </div>
                <div class="dropdown d-inline-block mr-3 h6">
                    <form action="{{route('supporter.workState.sad')}}" method="post" style="font-weight: bolder">
                        @csrf

                        <div class="btn header-item noti-icon waves-effect pt-4" >
                            @if($today_work == 1)
                                <input type="checkbox" id="switch9" checked switch="dark"  onchange="submit()"  name="state"/>
                            @else
                                <input type="checkbox" id="switch9" switch="dark"  onchange="submit()"  name="state"/>
                            @endif
                            <label for="switch9" data-on-label="Yes"
                                   data-off-label="No"></label>
                        </div>
                        Work State

                    </form>

                </div>


                <div class="dropdown d-none d-lg-inline-block mr-2">
                    <button type="button" class="btn header-item toggle-search noti-icon waves-effect" data-target="#search-wrap">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </div>

                <div class="dropdown d-none d-lg-inline-block mr-3">
                    <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                        <i class="mdi mdi-fullscreen"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block mr-3">
                    <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ion ion-md-notifications"></i>
                        <?php  $newNoti = [] ?>
                        <span class="badge badge-danger badge-pill">{{count($newNoti)}}</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0" aria-labelledby="page-header-notifications-dropdown">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="m-0 font-size-14"> {{__('admin/section.Notifications')}} {{count($newNoti)}} </h5>
                                </div>
                            </div>
                        </div>
                        <div data-simplebar style="max-height: 230px;">
                            @foreach($newNoti as $notify)
                                <a href="" class="text-reset notification-item">
                                    <div class="media">
                                        <div class="avatar-xs mr-3">
                                        <span class="avatar-title bg-success rounded-circle font-size-16">
                                            <i class="mdi mdi-cart-outline"></i>
                                        </span>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="mt-0 font-size-15 mb-1">{{$notify->category->name}}</h6>
                                            <a href="{{route('notifications.update.notify.get',['notification'=>$notify->id])}}">
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1">{{__('home.warning_product')}} {{$notify->curent_number}}</p>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                                </a>

                            @endforeach

                        </div>
                        <div class="p-2 border-top">
                            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="">
                                View all
                            </a>
                        </div>
                    </div>
                </div>


                @if(LaravelLocalization::getCurrentLocale() == 'ar')
                    <div class="dropdown d-none d-md-block mr-2">
                        <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16"> العربية </span> <img class="ml-2" src="{{asset('assets/admin/images/ar_flag.png')}}" alt="Header Language" height="16">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="dropdown-item notify-item">
                                <img src="{{asset('assets/admin/images/us_flag.jpg')}}" alt="user-image" height="12"> <span class="align-middle"> English </span>
                            </a>

                        </div>
                    </div>
                @else
                    <div class="dropdown d-none d-md-block mr-2">
                        <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="font-size-16"> English </span> <img class="ml-2" src="{{asset('assets/admin/images/us_flag.jpg')}}" alt="Header Language" height="16">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="dropdown-item notify-item">
                                <img src="{{asset('assets/admin/images/ar_flag.png')}}" alt="user-image" height="12"> <span class="align-middle"> العربية </span>
                            </a>

                        </div>
                    </div>
                @endif

                <div class="dropdown d-none d-md-block mr-2">
                    <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="font-size-16"> {{Session::get('currency')}}  </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">



                        <a href="" class="dropdown-item notify-item">
                            <span class="align-middle"> EGP </span>
                        </a>



                    </div>
                </div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="{{asset('assets/admin/images/logo.png')}}" alt="Header Avatar">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href=""><i class="bx bx-user font-size-16 align-middle mr-1"></i> {{__('layout.profile')}}</a>
                        <a class="dropdown-item d-block" href=""><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> {{__('layout.transactions')}}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#">
                            {{-- <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> --}}
                            <form action="{{route('logout')}}" method="post">
                                @csrf

                                <input type="submit" value="{{__('layout.logout')}}" class="dropdown-item text-danger">
                            </form>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">

        <div data-simplebar class="h-100">
            {{-- @if(LaravelLocalization::getCurrentLocale() == 'ar')
                @include('vendor.sections.sections_ar')
            @else --}}
            @include('supporter.sections')
            {{-- @endif --}}

        </div>
    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    @if($errors->any())
        <center><div class="col-sm-12 btn btn-success">{{ implode('', $errors->all()) }}</div></center>
    @endif

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                @yield("content")

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


        <footer class="footer">
            <div class="container-fluid">
                <div class="row">

                </div>
            </div>
        </footer>
    </div>

    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- JAVASCRIPT -->
<script>
    $(document).ready(function() {
        $('#datatable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
</script>

<script src="{{asset("assets/admin/libs/jquery/jquery.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/metismenu/metisMenu.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/simplebar/simplebar.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/node-waves/waves.min.js")}}"></script>

<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Ecommerce init js -->
<script src="{{asset('assets/js/pages/ecommerce.init.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
@yield("script")
<script>
    $(document).ready(function() {
        $('#datatable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    } );
</script>

<script src="{{asset("assets/admin/libs/datatables.net/js/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/jszip/jszip.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/pdfmake/build/pdfmake.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/pdfmake/build/vfs_fonts.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-buttons/js/buttons.html5.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-buttons/js/buttons.print.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-buttons/js/buttons.colVis.min.j")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js")}}"></script>
<script src="{{asset("assets/admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js")}}"></script>
<script src="{{asset("assets/admin/js/pages/datatables.init.js")}}"></script>
<script src="{{asset("assets/admin/js/app.js")}}"></script>

</body>
</html>
