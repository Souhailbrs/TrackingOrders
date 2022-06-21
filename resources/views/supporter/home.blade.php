@extends("layouts.supporter")
@if(LaravelLocalization::getCurrentLocale() == 'ar')
@section("pageTitle", "الرئيسية")
@else
@section("pageTitle", "Home")
@endif
@section('styleChart')
<link href="{{asset("assets/admin/libs/c3/c3.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
@endsection
@section("content")
        <div class="container">

            <div class="row">
                <div class="container">
                    <form class="row text-center" action="" method="POST">
                        @csrf
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2 h6 ">
                            <label for="filter">Filter</label> :
                            <select class="form-control" id="filter" name="date">
                                <option value="today">Today</option>
                                <option value="all">All</option>
                                <option value="from">From To</option>
                            </select>
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from">From</label> : <input type="date" class="form-control" id="from" name="from">
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from">To</label> : <input type="date" class="form-control" id="to" name="to">
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from">Country</label> :
                            <select class="form-control"  name="country" id="country_id">
                                <?php $res['countries'] = [];?>
                                @foreach($res['countries'] as $country)
                                    <option value="{{$country['id']}}">{{$country['title_' . App::getLocale()]}}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-sm-2 h6 ">
                            <label for="from"> &#160;</label>
                            <input class="form-control btn btn-dark" type="submit">

                        </div>
                        <div class="col-sm-1"></div>

                    </form>
                </div>
            </div>
            <hr>
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
                <div class="col">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2">
                                <div class="fs-5">
                                    <ion-icon name="person-add-outline"></ion-icon>
                                </div>
                                <div>
                                    <p class="mb-0">Total Sales</p>
                                </div>
                                <div class="fs-5 ms-auto">
                                    <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <div class="text-center h5 ">
                                    <?php $res['total_earnings'] = '';?>

                                    <h5 class="mb-0">{{$res['total_earnings']}} Dollars</h5>
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
                                    <p class="mb-0"> New Orders</p>
                                </div>
                                <div class="fs-5 ms-auto">
                                    <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                <div class="text-center h5 ">
                                    <?php $res['new_orders'] = '';?>

                                    <h5 class="mb-0">{{$res['new_orders']}} Orders</h5>
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
                                    <h5 class="mb-0">{{$res['new_orders']}} Orders</h5>
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
                                    <?php $res['delivered_orders'] = '';?>

                                    <h5 class="mb-0">{{$res['delivered_orders']}} Orders</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--end row-->
            <div class="row">
                <div class="col-12 col-lg-12 col-xl-12 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0">Statistics</h6>
                                <div class="ms-auto">
                                    <div class="d-flex align-items-center font-13 gap-2">
                      <span class="border px-1 rounded cursor-pointer"><i
                              class="bx bxs-circle me-1 text-primary"></i>Downloads</span>
                                        <span class="border px-1 rounded cursor-pointer"><i
                                                class="bx bxs-circle me-1 text-primary opacity-50"></i>Earnings</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container1">
                                <canvas id="chart5"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 mx-auto">
                    <h6 class="mb-0 text-uppercase">Confirmation Percentage</h6>
                    <hr />
                    <div class="card">
                        <div class="card-body">
                            <div id="chart12"></div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-6 mx-auto">
                    <h6 class="mb-0 text-uppercase">Delivered Percentage</h6>
                    <hr />
                    <div class="card">
                        <div class="card-body">
                            <div id="chart12"></div>
                        </div>
                    </div>
                </div>

            </div>




            <!-- end row -->


        </div>
@endsection

