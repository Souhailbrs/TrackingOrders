@extends("layouts.delivery")
@section("pageTitle", "Box Orders")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive ">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable"
                                           class="table table-striped dt-responsive nowrap table-vertical"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Shop Name</th>
                                            <th>Products</th>
                                            <th>Customer Details</th>
                                            <th>Status</th>
                                            <th>Deliver Time</th>
                                            <th>Track</th>
                                            <th>Control</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>
                                                    #{{$record->id}}
                                                </td>
                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"  data-toggle="modal" data-target="#exampleModalCenter{{$record->id}}">
                                                        {{$record->shop['title_'.App::getlocale()]}}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"  data-toggle="modal" data-target="#exampleModalCenterProducts{{$record->id}}">
                                                        {{$record->shop['title_'.App::getlocale()]}}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"  data-toggle="modal" data-target="#exampleModalCenterCustomer{{$record->id}}">
                                                        {{$record->customer_name}}
                                                    </a>
                                                </td>

                                                <td>

                                                    @if( $record->status == 0)
                                                        <span class="btn btn-warning" style="width:200px">New Order</span>
                                                    @elseif( $record->status == 1)
                                                        <span class="btn btn-info"  style="width:200px">Call Center Received</span>
                                                    @elseif( $record->status == 2 )
                                                        <span class="btn btn-danger"  style="width:200px">No Answer Call Center</span>
                                                    @elseif ($record->status == 3)
                                                        <span class="btn btn-danger"  style="width:200px">Wrong Answer</span>
                                                    @elseif($record->status == 4)
                                                        <span class="btn btn-success"  style="width:200px">Confirm Order</span>
                                                    @elseif( $record->status == 5)
                                                        <span class="btn btn-secondary"  style="width:200px">Not Confirm Order</span>
                                                    @elseif($record->status == 6)
                                                        <span class="btn btn-success"  style="width:200px">is Ready to be Delivered</span>
                                                    @elseif($record->status == 7)
                                                        <span class="btn btn-success"  style="width:200px">Received by Delivery</span>
                                                    @elseif($record->status == 8)
                                                        <span class="btn btn-danger"  style="width:200px">Delivery Refused Order</span>
                                                    @elseif($record->status == 9)
                                                        <span class="btn btn-primary"  style="width:200px">Customer Recived</span>
                                                    @elseif($record->status == 10)
                                                        <span class="btn btn-danger"  style="width:200px">Customer Refused</span>
                                                    @elseif($record->status ==11)
                                                        <span class="btn btn-danger"  style="width:200px">No Answer Delivery Boy</span>
                                                    @elseif($record->status == 12)
                                                        <span class="btn btn-danger"  style="width:200px">Customer Didn't deliver</span>
                                                    @endif


                                                </td>

                                                <td>
                                                    {{date('m/d/Y h:i A', strtotime($record->delivery_date)) }}
                                                </td>

                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"  target="_blank" href="{{route('delivery.trackOrder',['id'=>$record->id])}}">
                                                        View
                                                    </a>
                                                </td>
                                                <td>

                                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Control
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                    <a class="btn btn-dark col-sm-12"  href="">Customer Received</a>
                                                                    <br>
                                                                    <a class="btn btn-dark col-sm-12"  href="">Customer Did not Receive</a>
                                                                    <br>
                                                                    <a class="btn btn-dark col-sm-12"  href="">Customer Did not Reply</a>
                                                                    <br>
                                                                    <a class="btn btn-dark col-sm-12"  href="">Send Back to call center</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                </td>


                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

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

@endsection
<!-- Name -->
@foreach($records as $record)

    <div class="modal fade" id="exampleModalCenterProducts{{$record['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                Product price
                            </td>
                            <td>
                                amount
                            </td>
                            <td>
                                total price
                            </td>
                        </tr>
                        <?php $price = 0 ?>
                        @foreach($record->product as $pro)
                            <tr>

                                <td>
                                    {{$pro->one_product->product_name}}
                                </td>
                                <td>
                                    {{$pro->one_product->product_price}}
                                </td>
                                <td>
                                    {{$pro->amount}}
                                </td>
                                <td>
                                    {{$pro->one_product->product_price * $pro->amount}}
                                </td>
                                <?php $price += $pro->one_product->product_price * $pro->amount ?>
                            </tr>

                        @endforeach

                    </table>
                    <hr>
                    <h3 class="text-center">
                        total price : {{$price}}
                    </h3>
                    <?php $price =0 ;?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table col-sm-12 table-bordered text-center">
                        <tr>
                            <td>
                                Name Ar
                            </td>
                            <td>
                                Name En
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
                                {{$record->shop['title_ar']}}
                            </td>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                {{$record->customer_phone1}}
                            </td>
                            <td>
                                {{$record->customer_phone1}}
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
