@extends("layouts.admin")
@section("pageTitle", "Stai")
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<link href="{{asset("assets/admin/libs/c3/c3.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>

@section("content")

    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Received Orders</h4>

                    <div class="text-center" dir="ltr">
                        <input class="knob" data-width="150" data-height="150" data-linecap=round
                               data-fgColor="#ffbb44" value="12" data-skin="tron"
                               data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row mt-5 clearfix mb-0">


                            <li class="col-12">
                                <p class="mb-1 font-size-18 font-weight-bold">123</p>
                                <p class="text-muted mb-0">Confirmed</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Confirmed Orders</h4>

                    <div class="text-center" dir="ltr">
                        <input class="knob" data-width="150" data-height="150" data-linecap=round
                               data-fgColor="#ffbb44" value="12" data-skin="tron"
                               data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row mt-5 clearfix mb-0">


                            <li class="col-12">
                                <p class="mb-1 font-size-18 font-weight-bold">123</p>
                                <p class="text-muted mb-0">Confirmed</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Delivered Orders</h4>

                    <div class="text-center" dir="ltr">
                        <input class="knob" data-width="150" data-height="150" data-linecap=round
                               data-fgColor="#ffbb44" value="12" data-skin="tron"
                               data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row mt-5 clearfix mb-0">


                            <li class="col-12">
                                <p class="mb-1 font-size-18 font-weight-bold">123</p>
                                <p class="text-muted mb-0">Confirmed</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Canceled Orders</h4>

                    <div class="text-center" dir="ltr">
                        <input class="knob" data-width="150" data-height="150" data-linecap=round
                               data-fgColor="#ffbb44" value="12" data-skin="tron"
                               data-angleOffset="180"
                               data-readOnly=true data-thickness=".1"/>

                        <div class="clearfix"></div>
                        <ul class="list-inline row mt-5 clearfix mb-0">


                            <li class="col-12">
                                <p class="mb-1 font-size-18 font-weight-bold">123</p>
                                <p class="text-muted mb-0">Confirmed</p>
                            </li>
                        </ul>

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
