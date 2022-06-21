<?php

use App\Models\Order;
use App\Models\SalesChannels;
use App\Models\Seller;use Illuminate\Support\Carbon;

function getSellerNeeds($seller){
    $seller = Seller::find($seller);
    $shops =  SalesChannels::where('owner_email',$seller->email)->get();
    $orders =[];
    foreach($shops  as $shop){
        $orders []= Order::where('sales_channel', $shop->id)->where('status', 10)->get();
    }
    $orders_res = [];
    foreach($orders as $order){
        foreach($order as $ord) {
            $orders_res  [] = $ord;
        }
    }
    $orders = $orders_res;
    $total =0;
    foreach($orders as $ord){
        foreach($ord->product as $pro){
            $total += intval($pro->price);
        }
    }

    return $total;
}
?>
@extends("layouts.admin")
@section("pageTitle", "Users Page")
@section("style")
@endsection
@section("content")

    <div class="page-content">

        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Seller Earnings</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary">Settings</button>
                    <button type="button" class="btn btn-outline-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                        <a class="dropdown-item" href="javascript:;">Another action</a>
                        <a class="dropdown-item" href="javascript:;">Something else here</a>
                        <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <!--start shop area-->
        <section class="shop-page">
            <div class="shop-container">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row">


                            <div class="col-12 col-xl-12">
                                <div class="product-wrapper">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="position-relative">
                                                <input id="filter" type="text" class="form-control ps-5" placeholder="Search Product...">
                                                <span class="position-absolute top-50 product-show translate-middle-y"><ion-icon name="search-sharp" class="ms-3 fs-6"></ion-icon></span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-grid text-center">
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 text-center" id="myDiv">
                                            @foreach($sellers as $seller)
                                             <div class="col text-center results">
                                                <div class="card product-card text-center">

                                                    <img style="height:250px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOHF8z_QXtdI5IMk5Cv5vLnUwtuN12Z3BMMg&usqp=CAU" class="card-img-top" alt="...">
                                                    <div class="card-header bg-transparent border-bottom-0">
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <a href="javascript:;">

                                                                <div class="product-wishlist">
                                                                    <a style="display:inline-block;margin-right: 30px" href="https://wa.me/{{'00222'}}?text={{''}}" data-action="share/whatsapp/share" target="_blank" class=" ">
                                                                        <img src="{{asset('assets/site/images/Flat-logo-WhatsApp-PNG.png')}}" height="40" width="40" alt="...">
                                                                    </a>
                                                                </div>

                                                                <div class="col- m-1 p-1 pr-2 pl-2 btn btn-success" style="display:inline-block">
                                                                    <a href="tel:+" target="_blank"  height="40" width="40"
                                                                       class=" text-white text-decoration-none"> <i class="fa fa-phone"> </i> </a>
                                                                    {{-- <a href="tel:+900300400">Phone: 900 300 400</a> --}}
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">

                                                        <div class="product-info">

                                                            <a href="ecommerce-product-details.html">
                                                                <h2 class="product-name mb-2">{{$seller->name}}</h2>
                                                            </a>
                                                            <div class="d-flex align-items-center">
                                                                Need :
                                                                    <span class="fs-5">$<?php echo getSellerNeeds($seller->id)?></span>
                                                                </div>

                                                            </div>
                                                            <div class="product-action mt-2">
                                                                <div class="d-grid">
                                                                    <a href="{{route('earnings.reports',['seller'=>$seller->id])}}" class="btn btn-primary btn-ecomm"><i class="bx bxs-add-to-queue"></i>View Reports</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
            </div>
        </section>
        <!--end shop area-->

    </div>
    <script type="text/javascript">
        window.onload=function(){
            $("#filter").keyup(function() {

                var filter = $(this).val(),
                    count = 0;

                $('.results').each(function() {

                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).hide();

                    } else {
                        $(this).show();
                        count++;
                    }
                });
            });
        }
    </script>

@endsection
