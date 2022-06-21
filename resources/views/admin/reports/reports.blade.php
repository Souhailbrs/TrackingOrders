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
                    <ol class="breadcrumb mb-0 p-0 align-items-center col-sm-12">

                        <li class="breadcrumb-item active col-sm-12" aria-current="page">This Month</li>

                    </ol>
                </nav>

            </div>
            <div class="ps-3">

                <nav aria-label="breadcrumb">
                   <span class="d-block">
                       From
                   </span>
                    <input type="date" name="from" class="btn btn-outline-primary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                </nav>

            </div>
            <div class="ps-3">

                <nav aria-label="breadcrumb">
                    <span class="d-block">
                       To
                   </span>
                    <input type="date" name="to" class="btn btn-outline-primary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                </nav>

            </div>
            <div class="ps-3">
<span class="d-block">
                       &#160;
                   </span>
                <nav aria-label="breadcrumb">
                    <input type="submit" class="btn btn-outline-primary ">

                </nav>

            </div>
        </div>

        <section class="shop-page">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-6 col-xl-3">
                            </div>
                            <div class="col-6 col-xl-6">
                                <div class="order-summary">
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="fs-5">Order summary</p>
                                                    <?php
                                                    $total = 0;
                                                    ?>
                                                    @foreach($orders  as $order)
                                                    <div class="my-3 border-top"></div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="ps-2 ">
                                                            <h6 class="mb-1"># {{$order->id}}</h6>
                                                        </div>
                                                        <div class="ps-4 ">
                                                        </div>

                                                        @foreach($order->product as $pro)
                                                            <a class="d-block flex-shrink-0" href="javascript:;">
                                                                <img src="{{asset('assets/admin/products/'.$pro->one_product->image)}}" width="75" alt="Product">
                                                            </a>
                                                            <div class="ps-2">
                                                                <h6 class="mb-1">{{$pro->one_product->name}}</h6>
                                                                <div class="widget-product-meta"><span class="me-2">
                                                                        ${{$pro->price}} <span class="">x {{$pro->amount}}</span>
                                                                        <?php $total += intval($pro->price); ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                            <div class="card mb-0">
                                                <div class="card-body">

                                                    <div class="my-3 border-top"></div>
                                                    <h5 class="mb-0">Order Total: <span class="float-end">${{$total}}</span></h5>
                                                </div>
                                            </div>
                                            <div class="card mb-0">
                                                <button class="btn btn-primary btn-ecomm" type="button">Print</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xl-3">
                            </div>
                        </div>
                    </div>
        </section>
        <!--end breadcrumb-->
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
