@extends("layouts.admin")
@section("pageTitle", "Stai")
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<link href="{{asset("assets/admin/libs/c3/c3.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>

@section("content")

    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="heart-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0"> Total Earnings</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0"> Dollars</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="heart-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0"> Total Orders</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{$res['all_orders']}} Orders</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="chatbox-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Confirmed Orders</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{$res['confirmed_orders']}} Orders</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Delivered Orders</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{$res['delivered_orders']}} Orders</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="chatbox-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Cancelled CallCenter Orders</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{$res['cancelled_orders_call_center']}} Orders</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="mail-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Cancelled Delivery Orders</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{$res['cancelled_orders_delivery']}} Orders</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="chatbox-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">New Orders</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{$res['new_orders']}} Orders</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--Rate-->
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="chatbox-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Delivered Rate</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{ round($res['delivered_percentage'],2)}} %</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="chatbox-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Confirmation Rate</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{round($res['confirmed_percentage'],2)}} %</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="fs-5">
                            <ion-icon name="chatbox-outline"></ion-icon>
                        </div>
                        <div>
                            <p class="mb-0">Cancelled Rate</p>
                        </div>
                        <div class="fs-5 ms-auto">
                            <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="text-center h5 ">
                            <h5 class="mb-0">{{round($res['cancelled_percentage'],2)}} %</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script src="{{asset("assets/admin/libs/d3/d3.min.js")}}"></script>
    <script src="{{asset("assets/admin/libs/c3/c3.min.js")}}"></script>
    <script src="{{asset("assets/admin/js/app.js")}}"></script>

    <script src="{{asset('assets/admin/libs/peity/jquery.peity.min.js')}}"></script>

    <script src="{{asset('assets/admin/libs/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/pages/widget.init.js')}}"></script>
    <script src="{{asset("assets/admin/js/pages/c3-chart.init.js")}}"></script>
@endsection
