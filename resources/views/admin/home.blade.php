@extends("layouts.admin")
@if(LaravelLocalization::getCurrentLocale() == 'ar')
    @section("pageTitle", "الرئيسية")
@else
    @section("pageTitle", "Home")
@endif
@section('styleChart')
    <link href="{{asset("assets/admin/libs/c3/c3.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

@section("content")
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <form class="row text-center" action="{{route('filter.statistics',['type_users'=>'all'])}}" method="POST">
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
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-purple mr-0 float-right"><i
                                    class="mdi mdi-basket"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter text-purple">{{$res['total_earnings']}}</span>
                                Total Sales
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-blue-grey mr-0 float-right"><i
                                    class="mdi mdi-black-mesa"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter text-blue-grey">{{$res['new_orders']}}</span>
                                New Orders
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-brown mr-0 float-right"><i class="mdi mdi-buffer"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter text-brown">{{$res['confirmed_orders']}}</span>
                                Confirmed Orders
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon bg-teal mr-0 float-right"><i class="mdi mdi-coffee"></i></span>
                            <div class="mini-stat-info">
                                <span class="counter text-teal">{{$res['delivered_orders']}}</span>
                                Delivered Orders
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12" style="display:block">

                <div class="row">
                    <div class="col-md-12 monthly-earning-wid">
                        <div class="card" style="height: 480px;">
                            <div class="card-body">
                                <h4 class="card-title">
                                    Total Sales
                                </h4>




                                <canvas id="myChart" style="width:100%;height:100%"></canvas>

                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>


        <div class="row">
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Confirmation Percentage</h4>

                        <div class="text-center" dir="ltr">
                            <input class="knob" data-width="150" data-height="150" data-linecap=round
                                   data-fgColor="#ffbb44" value="{{$res['confirmed_percentage']}}" data-skin="tron"
                                   data-angleOffset="180"
                                   data-readOnly=true data-thickness=".1"/>

                            <div class="clearfix"></div>
                            <ul class="list-inline row mt-5 clearfix mb-0">
<!--                                <li class="col-6">
                                    <p class="mb-1 font-size-18 font-weight-bold">{{$res['all_orders']}}</p>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </li>-->

                                <li class="col-12">
                                    <p class="mb-1 font-size-18 font-weight-bold">{{$res['confirmed_orders']}}</p>
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
                        <h4 class="card-title mb-4">Delivered Percentage</h4>

                        <div class="text-center" dir="ltr">
                            <input class="knob" data-width="150" data-height="150" data-linecap=round
                                   data-fgColor="#ffbb44" value="{{$res['delivered_percentage']}}" data-skin="tron"
                                   data-angleOffset="180"
                                   data-readOnly=true data-thickness=".1"/>

                            <div class="clearfix"></div>
                            <ul class="list-inline row mt-5 clearfix mb-0">
<!--                                <li class="col-6">
                                    <p class="mb-1 font-size-18 font-weight-bold">{{$res['all_orders']}}</p>
                                    <p class="text-muted mb-0">Total Orders</p>
                                </li>-->
    <li class="col-12">
                                    <p class="mb-1 font-size-18 font-weight-bold">{{$res['delivered_orders']}}</p>
                                    <p class="text-muted mb-0">Delivered</p>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- end row -->

        <!-- end row -->


    </div>
@endsection
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@section("script")


    <script>
        $(document).ready(function () {
            $('#country_id').on('change', function () {
                var id = $(this).val();
                //alert(id);
                $.ajax({
                    url: '{{route('site.getCities')}}',
                    method: "get",
                    data: {country_id: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        var cities = document.getElementById('city_id');
                        cities.innerHTML = "<option>Select City</option>";
                        data.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['title_ar'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
        });

        var xValues = [0];
        var yValues = [0];
        <?php $max = 0; ?>

        @foreach($res['graph_earnings'] as $key => $value)
            xValues.push('<?php echo $key ?>');
            yValues.push('<?php echo $value ?>');
            <?php $max +=$value; ?>
        @endforeach
         <?php $node = $max / 10 ; ?>
        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: true,
                    lineTension: 0,
                    backgroundColor: "rgb(190,137,234)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: yValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: {{0}}, max: {{$max}}}}],
                }
            }
        });
    </script>
    <script src="{{asset("assets/admin/libs/d3/d3.min.js")}}"></script>
    <script src="{{asset("assets/admin/libs/c3/c3.min.js")}}"></script>
    <script src="{{asset("assets/admin/js/app.js")}}"></script>

    <script src="{{asset('assets/admin/libs/peity/jquery.peity.min.js')}}"></script>

    <script src="{{asset('assets/admin/libs/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/pages/widget.init.js')}}"></script>
    <script src="{{asset("assets/admin/js/pages/c3-chart.init.js")}}"></script>
    <script>
        var yarab = [];
        var ii = 0;
        <?php $categories = [] ?>
            @foreach( $categories as $course)
            yarab[ii] = "{{$course['name']}}";
        ii++;
        @endforeach
        <?php
            $xx = 0;
            $yy = 0;
            ?>
            !function (e) {
            "use strict";

            function a() {
            }

            a.prototype.init = function () {
                c3.generate({
                    bindto: "#chart", data: {
                        columns: [
                            ["{{__('admin/section.available_products')}}"{{$xx}}],
                            ["{{__('admin/section.sold_products')}}"{{$yy}}],
                        ],
                        type: "bar",
                    },
                    tooltip: {
                        contents: function (d, defaultTitleFormat, defaultValueFormat, color) {
                            var $$ = this, config = $$.config,
                                titleFormat = config.tooltip_format_title || defaultTitleFormat,
                                nameFormat = config.tooltip_format_name || function (name) {
                                    return name;
                                },
                                valueFormat = config.tooltip_format_value || defaultValueFormat,
                                text, i, title, value, name, bgcolor;
                            for (i = 0; i < d.length; i++) {
                                var y = 0;
                                if (!(d[i] && (d[i].value || d[i].value === 0))) {
                                    continue;
                                }

                                if (!text) {
                                    title = titleFormat ? titleFormat(d[i].x) : d[i].x;
                                    var list = document.getElementsByClassName("c3-axis")[0];
                                    list.getElementsByTagName("tspan")[title].innerHTML = yarab[title];
                                    text = "<table class='" + $$.CLASS.tooltip + "'>" + (title || title === 0 ? "<tr><th colspan='2'>" + yarab[title] + "</th></tr>" : "");
                                }

                                name = nameFormat(d[i].name);
                                value = valueFormat(d[i].value, d[i].ratio, d[i].id, d[i].index);
                                bgcolor = $$.levelColor ? $$.levelColor(d[i].value) : color(d[i].id);

                                text += "<tr class='" + $$.CLASS.tooltipName + "-" + d[i].id + "'>";
                                text += "<td class='name'><span style='background-color:" + bgcolor + "'></span>" + name + "</td>";
                                text += "<td class='value'>" + value + "</td>";
                                text += "</tr>";
                                y++;
                            }
                            return text + "</table>";
                        }
                    }

                }),
                    c3.generate({
                        bindto: "#donut-chart",
                        data: {
                            columns: [
                                ["{{__('admin/home.Open')}}", {{1}}],
                                ["{{__('admin/home.Close')}}", {{1}}],
                                ["{{__('admin/home.Accept')}}", {{1}}],
                                ["{{__('admin/home.Refused')}}", {{1}}],
                                ["{{__('admin/home.Pending')}}", {{1}}]
                            ],
                            type: "donut"
                        },
                        donut: {
                            title: "{{__('admin/home.Ticket')}}",
                            width: 30,
                            label: {show: !1}
                        },
                        color: {
                            pattern: ["#ffbb44", "#39325c", "#4ac18e", "#f06292", "#3bc3e9"]
                        }
                    })
            }
            e.ChartC3 = new a, e.ChartC3.Constructor = a
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.ChartC3.init()
        }();

        ////////////
        !function (e) {
            "use strict";

            function a() {
            }

            a.prototype.init = function () {
            c3.generate({
                    bindto: "#chart-with-area-moka",
                    data: {
                        columns: [["SonyVaio", 30, 20, 50, 40, 60, 50], ["iMacs", 200, 130, 90, 240, 130, 220], ["Tablets", 300, 200, 160, 400, 250, 250], ["iPhones", 200, 130, 90, 240, 130, 220], ["Macbooks", 130, 120, 150, 140, 160, 150]],
                        types: {SonyVaio: "bar", iMacs: "bar", Tablets: "spline", iPhones: "line", Macbooks: "bar"},
                        colors: {
                            SonyVaio: "#67a8e4",
                            iMacs: "#4ac18e",
                            Tablets: "#3bc3e9",
                            iPhones: "#ffbb44",
                            Macbooks: "#ea553d"
                        },
                        groups: [["SonyVaio", "iMacs"]]
                    },
                    axis: {x: {type: "categorized"}}
                }), c3.generate({
                    bindto: "#donut-chart",
                    data: {
                        columns: [["Desktops", 78], ["Smart Phones", 55], ["Mobiles", 40], ["Tablets", 25]],
                        type: "donut"
                    },
                    donut: {title: "Candidates", width: 30, label: {show: !1}},
                    color: {pattern: ["#f06292", "#6d60b0", "#5468da", "#009688"]}
                }), c3.generate({
                    bindto: "#pie-chart",
                    data: {
                        columns: [["Desktops", 78], ["Smart Phones", 55], ["Mobiles", 40], ["Tablets", 25]],
                        type: "pie"
                    },
                    color: {pattern: ["#afb42b", "#fb8c00", "#8d6e63", "#90a4ae"]},
                    pie: {label: {show: !1}}
                })
            }, e.ChartC3 = new a, e.ChartC3.Constructor = a
        }(window.jQuery), function () {
            "use strict";
            window.jQuery.ChartC3.init()
        }();
        //////////////////////////////////

    </script>

@endsection
