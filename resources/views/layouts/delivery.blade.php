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
<div >
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->

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


                <div class="dropdown d-inline-block">
                        {{-- <i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> --}}
                        <form class="btn header-item waves-effect  pt-4  btn" action="{{route('logout')}}" method="post">
                            @csrf

                            <input type="submit" value="{{__('layout.logout')}}" class="dropdown-item text-danger">
                        </form>


                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->

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


    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->



    <div class="main-content" style="margin-left: 0;">

        <div class="page-content">
            <div class="container-fluid">
                @if($errors->any())
                    <center><div class="col-sm-12 btn btn-success">{{ implode('', $errors->all()) }}</div></center>
                @endif

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
