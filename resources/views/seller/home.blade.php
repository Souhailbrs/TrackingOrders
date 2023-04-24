<?php
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

$type_users = Auth::guard('seller')->user()->id;
?>
@extends('layouts.seller')
@if (LaravelLocalization::getCurrentLocale() == 'ar')
    @section('pageTitle', 'الرئيسية')
@else
    @section('pageTitle', 'Home')
@endif

@section('content')
    <div class="container">
        <div class="row">
            <div class="container">
                <form class="row text-center d-flex justify-content-center"
                    action="{{ route('seller.filter.statistics', ['type_users' => $type_users]) }}" method="POST">
                    @csrf
                    <div class="col-sm-1"></div>
                    <div class="col-sm-2 h6 ">
                        <label for="filter">Filter</label> :
                        <select class="form-control" id="filter" name="date">
                            <option value="today" @if ($res['date'] == 'today') selected @endif>Today</option>
                            <option value="yesterday"@if ($res['date'] == 'yesterday') selected @endif>Yesterday</option>
                            <option value="7days" @if ($res['date'] == '7days') selected @endif>Last 7 Days</option>
                            <option value="30days" @if ($res['date'] == '30days') selected @endif>Last 30 Days</option>
                            <option value="all" @if ($res['date'] == 'all') selected @endif>All</option>
                            <option value="from" @if ($res['date'] == 'from') selected @endif>From To</option>
                        </select>
                    </div>
                    <div class="col-sm-2 h6 ">
                        <label for="product">Product</label> :
                        <select class="form-control" id="product" name="product">
                            <option value="all" @if ($res['selected_product'] == 'all') selected @endif>All</option>
                            @foreach ($res['products'] as $product)
                                <option value="{{ $product->id }}"@if ($res['selected_product'] == $product->id) selected @endif>
                                    {{ $product->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-2 h6 ">
                        <label for="from">From</label> : <input type="date" class="form-control" id="from"
                            value="{{ $res['date_from'] }}" name="from">
                    </div>
                    <div class="col-sm-2 h6 ">
                        <label for="from">To</label> : <input type="date" class="form-control" id="to"
                            value="{{ $res['date_to'] }}" name="to">
                    </div>
                    <div class="col-sm-2 h6 ">
                        <label for="from">Country</label> :
                        <select class="form-control" name="country" id="country_id">
                            @foreach ($res['countries'] as $country)
                                <option value="{{ $country['id'] }}" @if ($res['country'] == $country['id']) selected @endif>
                                    {{ $country['title_' . App::getLocale()] }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-sm-2 h6">
                        <label for="from"> &#160;</label>
                        <input class="form-control btn btn-dark" type="submit">

                    </div>

                </form>
            </div>
        </div>
        <hr>
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4">
            <div class="col" style="width: 100% !important">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <div class="fs-5">
                                <ion-icon name="cash-outline"></ion-icon>
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
                                <h5 class="mb-0">{{ $res['total_earnings'] }}
                                    {{ empty($res['current_country'][0]) ? '$' : $res['current_country'][0] }}</h5>
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
                                <ion-icon name="albums-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0"> Orders</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="text-center h5 ">
                                <h5 class="mb-0">{{ $res['all_orders'] }} Orders</h5>
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
                                <ion-icon name="checkmark-done-circle-outline"></ion-icon>
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
                                <h5 class="mb-0">{{ $res['confirmed_orders'] }} Orders</h5>
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
                                <ion-icon name="bag-handle-outline"></ion-icon>
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
                                <h5 class="mb-0">{{ $res['delivered_orders'] }} Orders</h5>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2">
                            <div class="fs-5">
                                <ion-icon name="trash-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0">Canceled Orders</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <ion-icon name="ellipsis-horizontal-sharp"></ion-icon>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <div class="text-center h5 ">
                                <h5 class="mb-0">{{ $res['canceled_orders'] }} Orders</h5>
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
                                <ion-icon name="checkmark-circle-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0"> Confirmation Rate</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <h5 class="mb-0">{{ number_format((float) $res['confirmed_percentage'], 2, '.', '') }}
                                    %</h5>
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
                                <ion-icon name="storefront-outline"></ion-icon>
                            </div>
                            <div>
                                <p class="mb-0">Delivered Rate</p>
                            </div>
                            <div class="fs-5 ms-auto">
                                <h5 class="mb-0">{{ number_format((float) $res['delivered_percentage'], 2, '.', '') }} %
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chart000">
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
                                            class="bx bxs-circle me-1 text-primary opacity-50"></i>Earnings</span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container1">
                            <canvas id="myChart" style="width:100%;max-height:350px"></canvas>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
            var xValues = {!! json_encode($res['xValues']) !!};
            var yValues = {!! json_encode($res['yValues']) !!};
            var calcul = 0;
            if (Math.max(...yValues) == 0) {
                calcul = 50;
            } else {
                calcul = Math.max(...yValues);
            }
            new Chart("myChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: calcul
                            }
                        }],
                    }
                }
            });
        </script>

        {{-- <div class="row">
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

        </div> --}}




        <!-- end row -->


    </div>
@endsection
