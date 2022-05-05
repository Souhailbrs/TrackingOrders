<!DOCTYPE html>
<html lang='zxx'>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Tracking Orders</title>

    <!-- ==================Start Css Link===================== -->
    <!-- font awesome icon -->
    <!-- fonts -->
    <link href='https://fonts.googleapis.com/css?family=Poppins:100,300,400,500,700' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700' rel='stylesheet'>
    <!-- fav icon -->
    <link rel='shortcut icon' type='image/x-icon' href='{{asset('assets/site/images/all-img/serbg.png')}}'>
    <!-- plugins css link -->
    <link rel='stylesheet' href='{{asset('assets/site/css/plugins.css')}}'>
    <!-- app css -->
    <link rel='stylesheet' href='{{asset('assets/site/css/app.css')}}'>
    <!-- ==================End Css Link===================== -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body>

<!--
site header start
-->
@include('includes.site.header')
<!--
banner area start
-->
@yield('content')


<!--
footer start
-->
@include('includes.site.footer')
@include('includes.site.scripts')


</body>

</html>
