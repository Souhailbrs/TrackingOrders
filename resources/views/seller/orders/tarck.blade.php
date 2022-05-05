@extends("layouts.seller")
@section("pageTitle", "Tracking Order")
@section("style")
    <style>
        .padding {
            padding: 3rem !important
        }

        body {
            background-color: #f9f9fa
        }

        .card {
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
            border: none;
            margin-bottom: 30px
        }

        .card .card-header {
            background-color: transparent;
            border-bottom: none;
            padding: 25px 20px
        }

        .card-block {
            padding: 1.25rem;
            margin-top: -40px
        }

        .card .card-header h5 {
            margin-bottom: 0;
            color: #505458;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-right: 10px;
            line-height: 1.4
        }

        .text-muted {
            margin-bottom: 0px
        }

        .user-activity-card .u-img .cover-img {
            width: 60px;
            height: 60px
        }

        .m-b-25 {
            margin-top: 20px
        }

        .user-activity-card .u-img .profile-img {
            width: 20px;
            height: 20px;
            position: absolute;
            bottom: -5px;
            right: -5px
        }

        .img-radius {
            border-radius: 5px
        }

        .user-activity-card .u-img {
            position: relative
        }

        .m-b-5 {
            margin-bottom: 5px
        }

        h6 {
            font-size: 14px
        }

        .card .card-block p {
            line-height: 25px
        }

        .text-muted {
            color: #919aa3 !important
        }

        .card .card-block p {
            line-height: 25px
        }

        .text-muted {
            color: #919aa3 !important
        }

        .m-r-10 {
            margin-right: 4px
        }

        .feather {
            font-family: 'feather' !important;
            speak: none;
            font-style: normal;
            font-weight: normal;
            font-variant: normal;
            text-transform: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .text-center {
            margin-top: 15px
        }
    </style>
@endsection
@section("content")


    <div class="card user-activity-card">
        <div class="card-header">
            <h4>Tracking Order Number #{{$id}}</h4>
        </div>
        @foreach($records as $record)
            {{--      Old->0  New->0   New Order  --}}
            @if( $record->last_status == 0)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-warning" style="width:200px">New Order</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">Customer Has Just  Add A New Order</p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif( $record->last_status == 1)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-info"  style="width:200px">Call Center Received</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Call Center Has Received the order</p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif( $record->last_status == 2 )
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">No Answer Call Center</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer Did not Answer the Call Center </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif ($record->last_status == 3)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">Wrong Answer</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Call Center has called the customer and it is a wrong number </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 4)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-success"  style="width:200px">Confirm Order</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Call Center has called the customer and the customer confirm the order </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif( $record->last_status == 5)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-secondary"  style="width:200px">Not Confirm Order</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Call Center has called the customer and the customer did not confirm the order </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 6)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">Cancelled Order</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer has canceled his order the order </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 7)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-success"  style="width:200px">Ready to be delivered </span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The order is ready to be delivered  </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 8)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-success"  style="width:200px">Received by delivered </span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The order is received  by delivery   </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 9)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">Delivery Refused Order</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Delivery  has received the order and refuse it  </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 8)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-primary"  style="width:200px">Customer Received</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer has received the order  </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 9)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">Delivery Refused</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Delivery has refused to receive the order  </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 10)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-primary"  style="width:200px">Customer Received</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer has received his order </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 11)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">Customer refused to deliver</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer refused to receive the order </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 12)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">No Answer Delivery</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer did not reply for the delivery </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                </div>
            @elseif($record->last_status == 13)
                <div class="card-block h5">
                    <div class="row m-b-25">
                        <div class="col-auto p-r-0">
                            <div class="u-img">  <span class="btn btn-danger"  style="width:200px">Customer Did not deliver</span>  </div>
                        </div>
                        <div class="col">
                            <p class="text-muted m-b-0">The Customer Did not deliver his order </p>
                            <p class="text-muted m-b-0"><i class="mdi mdi-timer feather icon-clock m-r-10"></i>
                                {{date('m/d/Y h:i A', strtotime($record->created_at)) }}
                            </p>
                        </div>
                    </div>
                    <hr>
                    @endif
                    @endforeach

                </div>


@endsection

