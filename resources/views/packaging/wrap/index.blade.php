@extends("layouts.packaging")
@section("pageTitle", "Sells Channels")
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

                                            <td colspan="8">
                                                <input type="button" class="btn btn-dark col-sm-12" value="Print All" onclick="printAll('allInvoices');">

                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ID</th>
                                            <th>Shop Name</th>
                                            <th>Products</th>
                                            <th>Customer Details</th>
                                            <th>Status</th>
                                            <th>Deliver Time</th>
                                            <th>Track</th>
                                            <th>Labels</th>
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
                                                       Show Products
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
                                                        <span class="btn btn-danger"  style="width:200px">is Canceled Order</span>
                                                    @elseif($record->status == 7)
                                                        <span class="btn btn-success"  style="width:200px">is Ready to be Delivered</span>
                                                    @elseif($record->status == 8)
                                                        <span class="btn btn-success"  style="width:200px">Received by Delivery</span>
                                                    @elseif($record->status == 9)
                                                        <span class="btn btn-danger"  style="width:200px">Delivery Refused Order</span>
                                                    @elseif($record->status == 10)
                                                        <span class="btn btn-primary"  style="width:200px">Customer Received</span>
                                                    @elseif($record->status == 11)
                                                        <span class="btn btn-danger"  style="width:200px">Customer Refused</span>
                                                    @elseif($record->status ==12)
                                                        <span class="btn btn-danger"  style="width:200px">No Answer Delivery Boy</span>
                                                    @elseif($record->status == 13)
                                                        <span class="btn btn-danger"  style="width:200px">Customer Didn't deliver</span>
                                                    @endif


                                                </td>

                                                <td>
                                                    @if($record->delivery_date)
                                                        {{date('m/d/Y', strtotime($record->delivery_date)) }}
                                                    @else
                                                        {{'Unknown'}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"  target="_blank" href="{{route('packaging.trackOrder',['id'=>$record->id])}}">
                                                        View
                                                    </a>
                                                </td>

                                                <td>
                                                    <a class="btn btn-dark col-sm-12 d-block"   data-toggle="modal" data-target="#exampleModalCenterPrint{{$record->id}}">
                                                        Print
                                                    </a>
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
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>
    <div id="allInvoices" style="display:none">
        @foreach($records as $record)
        <div class="modal-body" id="printLabel{{$record->id}}">
            <style>
                @media print {
                    body {transform: scale(1);}
                    table {page-break-inside: avoid;}
                }
            </style>
            <center>
                <table class="table text-center justify-content-center h5">
                    <thead>
                    <tr>
                        <th class="h4" scope="col" colspan="2"> Order Id #{{$record->id}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <th style="width:40%">Name</th>
                        <th>{{$record->customer_name}}</th>

                    </tr>
                    <tr>
                        <th style="width:40%">Phone</th>
                        <th>{{$record->customer_phone1}}</th>
                    </tr>



                    <tr>
                        <th style="width:40%">  City</th>
                        <th>{{$record->city['title_'. App::getLocale()]}}</th>
                    </tr>
                    <tr>
                        <th style="width:40%">  Zone</th>
                        <th>{{$record->zone['title_'. App::getLocale()]}}</th>
                    </tr>

                    <tr>
                        <th style="width:40%">  Address</th>
                        <th>{{$record->address}}</th>
                    </tr>
                    <tr>
                        <th style="width:40%">  Total price</th>
                        <?php $products = $record->product;
                        $count =0;
                        foreach($products as $pro){
                            $count += $pro->price;
                        }
                        ?>

                        <th>{{$count}}</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table class="text-center table-bordered">
                                <tr>
                                    <th colspan="3">
                                        Orders
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:40%">Product Name</th>
                                    <th style="width:40%">Total Price</th>
                                    <th style="width:40%">Quantity</th>
                                </tr>
                                @foreach($record->product as $pro)
                                    <tr>
                                        <th>{{$pro->one_product->product_name}}</th>
                                        <th>{{$pro->price}}</th>
                                        <th>{{$pro->amount}}</th>

                                    </tr>
                                @endforeach

                            </table>
                        </td>
                    </tr>



                    <tr>
                        <td colspan="2">
                            <center>
                                <img style="width:1.75in;height:1.75in" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{123}}&choe=UTF-8" />
                            </center>

                        </td>
                    </tr>


                    </tbody>
                </table>

            </center>
        </div>
        @endforeach
    </div>
@endsection
<!-- Name -->
@foreach($records as $record)
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenterPrint{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="printLabel{{$record->id}}">
                    <style>
                        @media print {
                            body {transform: scale(1);}
                            table {page-break-inside: avoid;}
                        }
                    </style>
                    <center>
                        <table class="table text-center justify-content-center h5">
                            <thead>
                            <tr>
                                <th class="h4" scope="col" colspan="2"> Order Id #{{$record->id}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <th style="width:40%">Name</th>
                                <th>{{$record->customer_name}}</th>

                            </tr>
                            <tr>
                                <th style="width:40%">Phone</th>
                                <th>{{$record->customer_phone1}}</th>
                            </tr>


                            <tr>
                                <th style="width:40%">  City</th>
                                <th>{{$record->city['title_'. App::getLocale()]}}</th>
                            </tr>
                            <tr>
                                <th style="width:40%">  Zone</th>
                                <th>{{$record->zone['title_'. App::getLocale()]}}</th>
                            </tr>

                            <tr>
                                <th style="width:40%">  Address</th>
                                <th>{{$record->address}}</th>
                            </tr>
                            <tr>
                                <th style="width:40%">  Total price</th>
                                <?php $products = $record->product;
                                $count =0;
                                foreach($products as $pro){
                                    $count += $pro->price;
                                }
                                ?>
                                <th>{{$count}}</th>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    <table class="text-center table-bordered">
                                        <tr>
                                            <th colspan="3">
                                                Orders
                                            </th>
                                        </tr>
                                            <tr>
                                                <th style="width:40%">Product Name</th>
                                                <th style="width:40%">Price</th>
                                                <th style="width:40%">Quantity</th>
                                            </tr>
                                        @foreach($record->product as $pro)
                                        <tr>
                                            <th>{{$pro->one_product->name}}</th>
                                            <th>{{$pro->price}}</th>
                                            <th>{{$pro->amount}}</th>

                                            </tr>
                                        @endforeach

                                    </table>
                                </td>
                            </tr>



                            <tr>
                                <td colspan="2">
                                    <center>
                                        <img style="width:1.75in;height:1.75in" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{123}}&choe=UTF-8" />
                                    </center>

                                </td>
                            </tr>


                            </tbody>
                        </table>

                    </center>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-primary" onclick="printContent('printLabel{{ $record->id }}');">Print</button>
                    </center>
                </div>
            </div>
        </div>
    </div>

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
                                <?php $price += $pro->price ?>

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
                                {{$record->customer_name}}
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
<script>
    function printContent(el){
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        $('body').empty().html(printcontent);

        window.print();
        $('body').html(restorepage);
        var ell = moka(el);
        document.location.href = 'https://codafrica.network/en/packaging/change_order_state_supporter/' + ell + '/4/8';
    }

    function printAll(el){
        console.log(el);
        var restorepage = $('body').html();
        var printcontent = $('#' + el).clone();
        printcontent.css('display','block');
        $('body').empty().html(printcontent);
        window.print();
        $('body').html(restorepage);
       printcontent.css('display','none');
        document.location.href = 'https://codafrica.network/en/packaging/change_order_state_all/8';

    }
    function moka(x){
        var length = 10;
        var trimmedString = x.substring(9999, length);
        return parseInt(trimmedString);
    }
    moka();
   </script>

