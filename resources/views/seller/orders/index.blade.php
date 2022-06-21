<?php
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
$type_users =  Auth::guard('seller')->user()->id;
?>
@extends("layouts.seller")
@section("pageTitle", "Products")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive ">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                        <div class="row">

                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">

                                    <div class="col-sm-6 h4" style="font-weight:bolder">
                                        Select  Specific Shop
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control col-sm-6" onchange="ChangePageFilter(this);" >
                                            <option >
                                              Select Shop
                                            </option>
                                            <option value="all">
                                                All Shops
                                            </option>
                                            @foreach($shopTypes as $shop)
                                            <option value="{{$shop->id}}">
                                                {{$shop['title_' . App::getLocale()]}}
                                            </option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-striped table-bordered pt-3"
                                               style="width:auto">
                                            <thead>
                                            <tr class="text-center">
                                                <th>ID</th>
                                                <th style="width: 900px !important;">
                                                    <div class="row text-center">
                                                        <div class="col-sm-1"></div>
                                                        <div class="col-sm-3 text-center" style="margin-right: 10px">
                                                            Image
                                                        </div>
                                                        <div class="col-sm-5 text-center" style="margin-right: 10px">
                                                            Product
                                                        </div>
                                                        <div class="col-sm-2 text-center" style="margin-right: 10px">
                                                            Price
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Customer</th>

                                                <th>Status</th>
                                                <th>Deliver Time</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody style="width:auto">
                                            @foreach($records as $record)

                                                <tr @if($record->deleted == 1)class="bg-light-danger"@endif>

                                                    <td>
                                                        #{{$record->id}}
                                                    </td>
                                                <!--                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"  data-bs-toggle="modal" data-bs-target="#exampleModalCenter{{$record->id}}">
                                                        {{$record->shop['title_'.App::getlocale()]}}
                                                    </a>
                                                </td>-->
                                                    <td style="width: 900px !important;">

                                                        <?php $price = 0;$total=0 ?>

                                                        @foreach($record->product as $pro)
                                                            <div class="row text-center justify-content-center"
                                                                 style="padding-bottom: 5px">
                                                                <div class="col-sm-3 text-center"
                                                                     style="margin-right: 10px">
                                                                    <img style="height:70px;width:70px"
                                                                         src="{{asset('assets/admin/products/'. $pro->one_product->image)}}"
                                                                         alt="">
                                                                </div>
                                                                <div class="col-sm-5 text-center"
                                                                     style="margin-right: 10px;overflow: hidden;white-space:nowrap;text-overflow:ellipsis;display:inline-block">
                                                                    <span class="btn-secondary" style="padding:2px;margin: 4px">
                                                                          {{$pro->amount}}
                                                                    </span>
                                                                    <br>

                                                                    {{$pro->one_product->name}}
                                                                </div>

                                                                @if($total != 1)
                                                                    <div class="col-sm-2 text-center"
                                                                         style="margin-right: 10px">
                                                                        @foreach($record->product as $pro)
                                                                            <?php $price += intval($pro->price);
                                                                            $total = 1;
                                                                            ?>

                                                                        @endforeach
                                                                        {{$price}}
                                                                    </div>
                                                                @else
                                                                    <div class="col-sm-2 text-center"
                                                                         style="margin-right: 10px">
                                                                    </div>
                                                                @endif

                                                            </div>
                                                        @endforeach

                                                    </td>
                                                    <td class="text-center">


                                                        <div class="col- m-1 p-1 pr-2 pl-2 btn btn-success " style="display:inline-block;width:100% ">
                                                            <a href="tel:+ {{$record->customer_phone1}}" target="_blank"  height="40" width="40"
                                                               class=" text-white text-decoration-none">
                                                                <i class="fa fa-phone"> </i>
                                                                {{$record->customer_phone1}}
                                                            </a>

                                                        </div>
                                                        <br>

                                                        {{$record->customer_name}}


                                                    </td>

                                                    <td class="text-center">
                                                        <a
                                                            target="_blank"
                                                            href="{{route('admin.site.trackOrder',['id'=>$record->id])}}">


                                                            @if( $record->status == 0)
                                                                <span class=" btn btn-light" style="width: 200px;" >{{__('orders.new_order')}}</span>
                                                            @elseif( $record->status == 1)
                                                                <span class="btn btn-light" style="width: 200px;"> {{__('orders.call_center_received')}}</span>
                                                            @elseif( $record->status == 2 )
                                                                <span class=" btn btn-warning" style="width: 200px;" >  {{__('orders.no_answer_call_center')}}</span>
                                                            @elseif ($record->status == 3)
                                                                <span class="btn btn-dark" style="width: 200px;">  {{__('orders.wrong_answer')}}</span>
                                                            @elseif($record->status == 4)
                                                                <span class="btn btn-blue" style="width: 200px;">  {{__('orders.confirm_order')}}</span>
                                                            @elseif( $record->status == 5)
                                                                <span class="btn btn-secondary" style="width: 200px;"> {{__('orders.not_confirm_order')}}</span>
                                                            @elseif($record->status == 6)
                                                                <span class="btn btn-danger" style="width: 200px;">  {{__('orders.canceled_order')}}</span>
                                                            @elseif($record->status == 7)
                                                                <span class="btn btn-info" style="width: 200px;">  {{__('orders.ready_to_be_delivered')}}</span>
                                                            @elseif($record->status == 8)
                                                                <span class="btn btn-info" style="width: 200px;">{{__('orders.received_by_delivery')}}</span>
                                                            @elseif($record->status == 9)
                                                                <span class="btn btn-danger" style="width: 200px;"> {{__('orders.delivery_refused_order')}}</span>
                                                            @elseif($record->status == 10)
                                                                <span class="btn btn-success" style="width: 200px;" > {{__('orders.customer_received')}}</span>
                                                            @elseif($record->status == 11)
                                                                <span class="btn btn-danger" style="width: 200px;">{{__('orders.canceled_order')}}</span>
                                                            @elseif($record->status == 12)
                                                                <span class="btn btn-warning" style="width: 200px;"> {{__('orders.no_answer_delivery_boy')}}</span>
                                                            @elseif($record->status == 13)
                                                                <span class="btn btn-danger" style="width: 200px;">  {{__('orders.customer_didnot_deliver')}}</span>
                                                            @endif



                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        @if($record->delivery_date)
                                                            {{date('m/d/Y', strtotime($record->delivery_date)) }}
                                                        @else
                                                            {{'Unknown'}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <center>

                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Control
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                    <a class="dropdown-item col-sm-12 d-block"  href="">View</a>
                                                                    <a class="dropdown-item  col-sm-12 d-block"  href="">Edit</a>
                                                                    @if($record->deleted == 1)
                                                                        <a class="dropdown-item col-sm-12 d-block"  href="">Restore</a>
                                                                    @endif
                                                                    <a class="dropdown-item col-sm-12 d-block"  href="">Delete</a>


                                                                </div>
                                                            </div>

                                                        </center>
                                                    </td>

                                                </tr>

                                            @endforeach

                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- container-fluid -->

                {{--
                                    {{ $data->links() }}
                --}}
            </div>
        </div>
    </div> <!-- end col -->
    </div>
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>

<!-- Name -->
@foreach($records as $record)

<div class="modal fade" id="exampleModalCenterProducts{{$record['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table col-sm-12 table-bordered text-center">
                        <tr>
                            <td>
                                Product name
                            </td>
                            <td>
                                total price
                            </td>
                            <td>
                                 amount
                            </td>

                        </tr>
                        <?php $price = 0 ?>
                        @foreach($record->product as $pro)
                        <tr>

                            <td>

                              {{$pro->one_product->name}}
                            </td>
                            <td>
                                {{$pro->price}}
                            </td>
                            <td>
                                {{$pro->amount}}
                            </td>

                        </tr>

                        @endforeach

                    </table>

                </div>

            </div>
        </div>
    </div>

<div class="modal fade" id="exampleModalCenter{{$record['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Shop Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center">
                    <tr>
                        <td>
                            Name
                        </td>
                        <td>
                            Shop Type
                        </td>
                        <td>
                            Shop Url
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{$record->shop['title_en']}}
                        </td>
                        <td>
                            {{$record->shop->shopType['title_'. App::getLocale()]}}
                        </td>
                        <td>
                            {{$record->shop['shop_url']}}
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenterCustomer{{$record['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Customer Details </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center">
                    <tr>
                        <td>
                            Customer Name
                        </td>
                        <td>
                           Phone 1
                        </td>


                    </tr>
                    <tr>
                        <td>
                            {{$record->customer_name}}
                        </td>
                        <td>
                            {{$record->customer_phone1}}
                        </td>

                    </tr>
                </table>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenterAddress{{$record['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center">
                    <tr>
                        <td>
                            Country
                        </td>
                        <td>
                            City
                        </td>
                        <td>
                          Zone
                        </td>
                        <td>
                            District
                        </td>
                        <td>
                            Address
                        </td>

                    </tr>
                    <tr>
                        @if($record->country)
                        <td>
                            {{$record->country['title_'. App::getLocale()]}}
                        </td>
                        @else
                            <td>
                                There is no country yet!
                            </td>
                        @endif
                            @if($record->city)
                            <td>
                            {{$record->city['title_'. App::getLocale()]}}
                        </td>
                            @else
                                <td>
                                    There is no city yet!
                                </td>
                                @endif
                            @if($record->zone)
                            <td>
                            {{$record->zone['title_'. App::getLocale()]}}
                        </td>
                            @else
                                <td>
                                    There is no zone yet!
                                </td>
                                @endif
                            @if($record->district)
                                <td>
                                    {{$record->district['title_'. App::getLocale()]}}
                                </td>
                            @else
                                <td>
                                    There is no district yet!
                                </td>
                            @endif
                        <td>
                            {{$record->address}}
                        </td>

                    </tr>
                </table>

            </div>

        </div>
    </div>
</div>
@endforeach

<script>
    function ChangePageFilter(sel){
        value = sel.value;
        if(value == 'all'){
            window.location.href = 'https://codafrica.network/en/seller/orders/filter/products/all';
        }else{
            window.location.href = 'https://codafrica.network/en/seller/orders/filter/products/' + value;
        }
    }
</script>
@endsection
