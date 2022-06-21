@extends("layouts.admin")
@section("pageTitle", "Add Products To Store")
@section("content")

    <!-- start page content-->
    <div class="page-content">

        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Order Number #000{{$order->id}}</div>
            <div class="mt-2">
                <p id="demo" class="btn btn-outline-primary "></p> &#160;

            </div>
            <span class="h6">Remains To Be Delivered</span>

            <div class="ms-auto">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary">Back</button>

                </div>
            </div>
        </div>
        <!--end breadcrumb-->


        <!--start shop cart-->
        <section class="shop-page">
            <div class="shop-container">

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="shop-cart">
                            <div class="row">
                                <div class="col-12 col-xl-8">
                                    <div class="shop-cart-list">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center g-2">
                                                    <h4>Customer Details</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center g-2 h6">
                                                   <div class="col-sm-6">
                                                       Customer Name
                                                   </div>
                                                    <div class="col-sm-6">
                                                        {{$order->customer_name}}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center g-2 h6">
                                                    <div class="col-sm-6">
                                                        Customer Phone
                                                    </div>
                                                    <div class="col-sm-6">
                                                        {{$order->customer_phone1}}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center g-2 h6">
                                                    <div class="col-sm-6">
                                                        Customer Notes
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if($order->customer_notes)
                                                        {{$order->customer_notes}}
                                                        @else
                                                            {{'Customer Has No Notes'}}
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row align-items-center g-2 h6">
                                                    <div class="col-sm-6">
                                                        Seller Notes
                                                    </div>
                                                    <div class="col-sm-6">
                                                        @if($order->notes)
                                                            {{$order->notes}}
                                                        @else
                                                            {{'Seller Has No Notes'}}
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center g-2">
                                                    <h4>Products Details</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $total = 0;
                                        ?>

                                        @foreach($order->product as $product)
                                        <div class="card text-center">
                                            <div class="card-body text-center">
                                                <div class="row align-items-center g-2 text-center">
                                                    <div class="col-12 col-lg-10">
                                                        <div class="d-lg-flex align-items-center gap-2">
                                                            <div class="cart-img text-center text-lg-start">
                                                                <img src="{{asset('assets/admin/products/' . $product->one_product->image)}}" width="70"  height="70"  alt="">
                                                            </div>
                                                            <div class="cart-detail text-center text-lg-start">
                                                                <h6 class="mb-2">{{$product->one_product->name}}</h6>
                                                                <input type="number" class="btn" value="2" min="1" style="width:70px" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <div class="cart-action text-center">
                                                            <h5 class="mb-0">${{$product->price}}</h5>
                                                            <?php $total += doubleval($product->price); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row align-items-center g-2">
                                                    <div class="col-12 col-lg-10 text-center">
                                                        <h5>Total Price</h5>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <h5>${{$total}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                                <div class="card user-activity-card p-5">

                                                    @foreach($order->track as $record)
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




                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <p class="fs-5 text-center">Order Status</p>
                                                    <div class="input-group text-center">
                                                        @if( $order->status == 0)
                                                            <span class=" btn btn-light  col-sm-12"  >{{__('orders.new_order')}}</span>
                                                        @elseif( $order->status == 1)
                                                            <span class="btn btn-light  col-sm-12"> {{__('orders.call_center_received')}}</span>
                                                        @elseif( $order->status == 2 )
                                                            <span class=" btn btn-warning col-sm-12" >  {{__('orders.no_answer_call_center')}}</span>
                                                        @elseif ($order->status == 3)
                                                            <span class="btn btn-dark col-sm-12">  {{__('orders.wrong_answer')}}</span>
                                                        @elseif($order->status == 4)
                                                            <span class="btn btn-blue col-sm-12" >  {{__('orders.confirm_order')}}</span>
                                                        @elseif( $order->status == 5)
                                                            <span class="btn btn-secondary col-sm-12"> {{__('orders.not_confirm_order')}}</span>
                                                        @elseif($order->status == 6)
                                                            <span class="btn btn-danger col-sm-12">  {{__('orders.canceled_order')}}</span>
                                                        @elseif($order->status == 7)
                                                            <span class="btn btn-info col-sm-12">  {{__('orders.ready_to_be_delivered')}}</span>
                                                        @elseif($order->status == 8)
                                                            <span class="btn btn-info col-sm-12">{{__('orders.received_by_delivery')}}</span>
                                                        @elseif($order->status == 9)
                                                            <span class="btn btn-danger col-sm-12"> {{__('orders.delivery_refused_order')}}</span>
                                                        @elseif($record->status == 10)
                                                            <span class="btn btn-success col-sm-12" > {{__('orders.customer_received')}}</span>
                                                        @elseif($order->status == 11)
                                                            <span class="btn btn-danger col-sm-12">{{__('orders.canceled_order')}}</span>
                                                        @elseif($order->status == 12)
                                                            <span class="btn btn-warning col-sm-12"> {{__('orders.no_answer_delivery_boy')}}</span>
                                                        @elseif($order->status == 13)
                                                            <span class="btn btn-danger col-sm-12">  {{__('orders.customer_didnot_deliver')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="fs-5">Order Location</p>
                                                    <div class="my-3 border-top"></div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Country Name</label>
                                                        <select class="form-select" disabled>
                                                            @if($order->country)
                                                            <option selected>{{$order->country['title_' . App::getLocale()]}}</option>
                                                            @endif
                                                            <option value="1">Australia</option>
                                                            <option value="2">India</option>
                                                            <option value="3">Canada</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">City</label>
                                                        <select class="form-select" disabled>
                                                            @if($order->city)
                                                            <option selected>{{$order->city['title_' . App::getLocale()]}}</option>
                                                            @endif
                                                            <option value="1">Texas</option>
                                                            <option value="2">Canada</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Zone</label>
                                                        <select class="form-select" disabled>
                                                            @if($order->zone)
                                                            <option selected>{{$order->zone['title_' . App::getLocale()]}}</option>
                                                            @endif
                                                            <option value="1">Texas</option>
                                                            <option value="2">Canada</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">District</label>
                                                        <select class="form-select" disabled>
                                                            @if($order->zone)
                                                                <option selected>{{$order->distict['title_' . App::getLocale()]}}</option>
                                                            @endif                                                            <option value="1">Texas</option>
                                                            <option value="2">Canada</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label">Address</label>
                                                        <input type="text" class="form-control" value="@if($order->address){{$order->address}}@else{{''}}@endif" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-0">
                                                <div class="card-body">
                                                    <h5 class="mb-0">Shop Details </h5>
                                                    <hr>
                                                    <div class="mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input class="form-control" value="{{$order->shop->title_ar}}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Phone</label>
                                                        <input class="form-control" value="{{$order->shop->owner_phone}}" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input class="form-control" value="{{$order->shop->owner_email}}" disabled>
                                                    </div>
                                                    <div class="mb-3 text-center">
                                                        <a href="{{$order->shop->shop_url}}" class="btn btn-outline-primary text-center"  target="_blank">
                                                            <label class="">View</label>

                                                        </a>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date('{{\Carbon\Carbon::parse($order->delivery_date)->format('M d,Y h:i:s')}}').getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Get today's date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h "
                + minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
        }, 1000);
    </script>

@endsection
