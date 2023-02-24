@extends('layouts.packaging')
@section('pageTitle', 'Sells Channels')
@section('style')

@endsection
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-12">
                <div class="card" style="min-height:900px">
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

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <form action="{{ route('packaging.wrapping.index') }}" method="get">
                                            <input value="{{ $search }}" name="search" type="text"
                                                class="col-sm-12 btn-outline-primary"
                                                placeholder="Search with order number or customer phone">
                                        </form>
                                    </div>
                                    <div class="col-sm-3">
                                        <form style="display: inline-block" action="{{ route('packaging.wrapping.index') }}"
                                            method="get">
                                            Show {{ $records->firstItem() }} - {{ $records->lastItem() }}
                                            From {{ $records->total() }}
                                            <select name="entries" id="" onchange="this.form.submit()">
                                                @if ($pagination)
                                                    <option value="{{ $pagination }}">{{ $pagination }}</option>
                                                    @if ($pagination != 10)
                                                        <option value="10">10</option>
                                                    @endif
                                                    @if ($pagination != 50)
                                                        <option value="50">50</option>
                                                    @endif
                                                    @if ($pagination != 100)
                                                        <option value="100">100</option>
                                                    @endif

                                                    @if ($pagination != 500)
                                                        <option value="500">500</option>
                                                    @endif

                                                    @if ($pagination != 1000)
                                                        <option value="1000">1000</option>
                                                    @endif
                                                    @if ($pagination != 10000)
                                                        <option value="1000">10000</option>
                                                    @endif
                                                @else
                                                    <option value="10">10</option>

                                                    <option value="50">50</option>

                                                    <option value="100">100</option>

                                                    <option value="500">500</option>

                                                    <option value="1000">1000</option>

                                                    <option value="1000">10000</option>
                                                @endif
                                            </select>
                                        </form>
                                        <a class="btn btn-primary"
                                            href="{{ route('custom_orders_export', $pagination) }}">Export To
                                            Excel</a>


                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example21" class="table table-striped table-bordered pt-3"
                                                style="width:auto">
                                                <thead>
                                                    <tr>

                                                        <td colspan="6">

                                                            <input type="button" class="btn btn-outline-primary col-sm-12"
                                                                value="Print All" onclick="printAll('allInvoices');">

                                                        </td>
                                                    </tr>
                                                    <tr class="text-center">
                                                        <th>{{ __('main.id') }}</th>
                                                        <th style="width: 900px !important;">
                                                            <div class="row text-center">
                                                                <div class="col-sm-1"></div>
                                                                <div class="col-sm-3 text-center"
                                                                    style="margin-right: 10px">
                                                                    {{ __('main.image') }}
                                                                </div>
                                                                <div class="col-sm-5 text-center"
                                                                    style="margin-right: 10px">
                                                                    {{ __('main.product') }}
                                                                </div>
                                                                <div class="col-sm-2 text-center"
                                                                    style="margin-right: 10px">
                                                                    {{ __('main.price') }}
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th>{{ __('main.customer') }}</th>

                                                        <th>{{ __('main.status') }}</th>
                                                        <th>{{ __('main.deliver_time') }}</th>
                                                        <th>{{ __('main.actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="width:auto">
                                                    @foreach ($records as $record)
                                                        <tr
                                                            @if ($record->deleted == 1) class="bg-light-danger" @endif>

                                                            <td>
                                                                #{{ $record->id }}
                                                            </td>
                                                            <!--                                                <td>
                                                                                    <a class="btn btn-dark col-sm-12 d-block"  data-bs-toggle="modal" data-bs-target="#exampleModalCenter{{ $record->id }}">
                                                                                        {{ $record->shop['title_' . App::getlocale()] }}
                                                                                        </a>
                                                                                    </td>-->
                                                            <td style="width: 900px !important;">

                                                                <?php $price = 0;
                                                                $total = 0; ?>

                                                                @foreach ($record->product as $pro)
                                                                    <div class="row text-center justify-content-center"
                                                                        style="padding-bottom: 5px">
                                                                        <div class="col-sm-3 text-center"
                                                                            style="margin-right: 10px">
                                                                            <img style="height:70px;width:70px"
                                                                                src="{{ asset('assets/admin/products/' . $pro->one_product->image) }}"
                                                                                alt="">
                                                                        </div>
                                                                        <div class="col-sm-5 text-center"
                                                                            style="margin-right: 10px;overflow: hidden;white-space:nowrap;text-overflow:ellipsis;display:inline-block">
                                                                            <span class="btn-secondary"
                                                                                style="padding:2px;margin: 4px">
                                                                                {{ $pro->amount }}
                                                                            </span>
                                                                            <br>

                                                                            {{ $pro->one_product->name }}
                                                                        </div>

                                                                        @if ($total != 1)
                                                                            <div class="col-sm-2 text-center"
                                                                                style="margin-right: 10px">
                                                                                @foreach ($record->product as $pro)
                                                                                    <?php $price += intval($pro->price);
                                                                                    $total = 1;
                                                                                    ?>
                                                                                @endforeach
                                                                                {{ $price }}
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


                                                                <div class="col- m-1 p-1 pr-2 pl-2 btn btn-success "
                                                                    style="display:inline-block;width:100% ">
                                                                    <a href="tel:+ {{ $record->customer_phone1 }}"
                                                                        target="_blank" height="40" width="40"
                                                                        class=" text-white text-decoration-none">
                                                                        <i class="fa fa-phone"> </i>
                                                                        {{ $record->customer_phone1 }}
                                                                    </a>

                                                                </div>
                                                                <br>

                                                                {{ $record->customer_name }}


                                                            </td>

                                                            <td class="text-center">
                                                                <a target="_blank"
                                                                    href="{{ route('packaging.trackOrder', ['id' => $record->id]) }}">


                                                                    @if ($record->status == 0)
                                                                        <span class=" btn btn-light"
                                                                            style="width: 200px;">{{ __('orders.new_order') }}</span>
                                                                    @elseif($record->status == 1)
                                                                        <span class="btn btn-light" style="width: 200px;">
                                                                            {{ __('orders.call_center_received') }}</span>
                                                                    @elseif($record->status == 2)
                                                                        <span class=" btn btn-warning"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.no_answer_call_center') }}</span>
                                                                    @elseif ($record->status == 3)
                                                                        <span class="btn btn-dark" style="width: 200px;">
                                                                            {{ __('orders.wrong_answer') }}</span>
                                                                    @elseif($record->status == 4)
                                                                        <span class="btn btn-blue" style="width: 200px;">
                                                                            {{ __('orders.confirm_order') }}</span>
                                                                    @elseif($record->status == 5)
                                                                        <span class="btn btn-secondary"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.not_confirm_order') }}</span>
                                                                    @elseif($record->status == 6)
                                                                        <span class="btn btn-danger"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.canceled_order') }}</span>
                                                                    @elseif($record->status == 7)
                                                                        <span class="btn btn-info" style="width: 200px;">
                                                                            {{ __('orders.ready_to_be_delivered') }}</span>
                                                                    @elseif($record->status == 8)
                                                                        <span class="btn btn-info"
                                                                            style="width: 200px;">{{ __('orders.received_by_delivery') }}</span>
                                                                    @elseif($record->status == 9)
                                                                        <span class="btn btn-danger"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.delivery_refused_order') }}</span>
                                                                    @elseif($record->status == 10)
                                                                        <span class="btn btn-success"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.customer_received') }}</span>
                                                                    @elseif($record->status == 11)
                                                                        <span class="btn btn-danger"
                                                                            style="width: 200px;">{{ __('orders.canceled_order') }}</span>
                                                                    @elseif($record->status == 12)
                                                                        <span class="btn btn-warning"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.no_answer_delivery_boy') }}</span>
                                                                    @elseif($record->status == 13)
                                                                        <span class="btn btn-danger"
                                                                            style="width: 200px;">
                                                                            {{ __('orders.customer_didnot_deliver') }}</span>
                                                                    @endif


                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($record->delivery_date)
                                                                    {{ date('m/d/Y', strtotime($record->delivery_date)) }}
                                                                @else
                                                                    {{ 'Unknown' }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <center>

                                                                    <div class="btn-group" role="group">
                                                                        <button id="btnGroupDrop1" type="button"
                                                                            class="btn btn-outline-primary dropdown-toggle"
                                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Control
                                                                        </button>
                                                                        <div class="dropdown-menu"
                                                                            aria-labelledby="btnGroupDrop1">

                                                                            <a class="dropdown-item col-sm-12 d-block"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#exampleModalCenterPrint{{ $record->id }}">Print</a>

                                                                            <a class="dropdown-item  col-sm-12 d-block"
                                                                                href="{{ route('packaging.orders.view.update', ['order_id' => $record->id]) }}">Edit</a>
                                                                            @if ($record->deleted == 1)
                                                                                <a class="dropdown-item col-sm-12 d-block"
                                                                                    href="">Restore</a>
                                                                            @endif
                                                                            <a class="dropdown-item col-sm-12 d-block"
                                                                                href="">Delete</a>


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
                    {{ $records->links() }}

                </div>
            </div>
        </div> <!-- end col -->
        <div id="modelImagee">

        </div>
        <div id="modelAdd">

        </div>
        <div id="allInvoices" style="display:none">
            @foreach ($records as $record)
                <div class="modal-body" id="printLabel{{ $record->id }}">
                    <style>
                        @media print {
                            body {
                                transform: scale(1);
                            }

                            table {
                                page-break-inside: avoid;
                            }
                        }
                    </style>
                    <center>
                        <table class="table text-center justify-content-center h5">
                            <thead>
                                <tr>
                                    <th class="h4" scope="col" colspan="2"> Order Id #{{ $record->id }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <th style="width:40%">Name</th>
                                    <th>{{ $record->customer_name }}</th>

                                </tr>
                                <tr>
                                    <th style="width:40%">Phone</th>
                                    <th>{{ $record->customer_phone1 }}</th>
                                </tr>

                                <tr>
                                    <th style="width:40%"> City</th>
                                    @if (!empty($record->city))
                                        <th>{{ $record->city['title_' . App::getLocale()] }}</th>
                                    @else
                                        <th>
                                            There is no zone yet!
                                        </th>
                                    @endif
                                </tr>
                                <tr>
                                    <th style="width:40%"> Zone</th>
                                    @if (!empty($record->zone))
                                        <th>{{ $record->zone['title_' . App::getLocale()] }}</th>
                                    @else
                                        <th>
                                            There is no zone yet!
                                        </th>
                                    @endif
                                </tr>

                                <tr>
                                    <th style="width:40%"> Address</th>
                                    <th>{{ $record->address }}</th>
                                </tr>
                                <tr>
                                    <th style="width:40%"> Total price</th>
                                    <?php $products = $record->product;
                                    $count = 0;
                                    foreach ($products as $pro) {
                                        $count += $pro->price;
                                    }
                                    ?>

                                    <th>{{ $count }}</th>
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
                                                <th style="width:40%">Product</th>
                                                <th style="width:40%">Total Price</th>
                                                <th style="width:40%">Quantity</th>
                                            </tr>
                                            @foreach ($record->product as $pro)
                                                <tr>
                                                    <th>{{ $pro->one_product->name }}</th>
                                                    <th>{{ $pro->price }}</th>
                                                    <th>{{ $pro->amount }}</th>

                                                </tr>
                                            @endforeach

                                        </table>
                                    </td>
                                </tr>


                                <tr>
                                    <td colspan="2">
                                        <center>
                                            <img style="width:1.75in;height:1.75in"
                                                src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ 123 }}&choe=UTF-8" />
                                        </center>

                                    </td>
                                </tr>


                            </tbody>
                        </table>

                    </center>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Name -->
    @foreach ($records as $record)
        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenterPrint{{ $record->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="printLabel{{ $record->id }}">
                        <style>
                            @media print {
                                body {
                                    transform: scale(1);
                                }

                                table {
                                    page-break-inside: avoid;
                                }
                            }
                        </style>
                        <center>
                            <table class="table text-center justify-content-center h5">
                                <thead>
                                    <tr>
                                        <th class="h4" scope="col" colspan="2"> Order Id #{{ $record->id }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <th style="width:40%">Name</th>
                                        <th>{{ $record->customer_name }}</th>

                                    </tr>
                                    <tr>
                                        <th style="width:40%">Phone</th>
                                        <th>{{ $record->customer_phone1 }}</th>
                                    </tr>


                                    <tr>
                                        <th style="width:40%"> City</th>
                                        @if (!empty($record->city))
                                            <th>{{ $record->city['title_' . App::getLocale()] }}</th>
                                        @else
                                            <th>
                                                There is no city yet!
                                            </th>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th style="width:40%"> Zone</th>
                                        @if (!empty($record->zone))
                                            <th>{{ $record->zone['title_' . App::getLocale()] }}</th>
                                        @else
                                            <th>
                                                There is no zone yet!
                                            </th>
                                        @endif
                                    </tr>

                                    <tr>
                                        <th style="width:40%"> Address</th>
                                        <th>{{ $record->address }}</th>
                                    </tr>
                                    <tr>
                                        <th style="width:40%"> Total price</th>
                                        <?php $products = $record->product;
                                        $count = 0;
                                        foreach ($products as $pro) {
                                            $count += $pro->price;
                                        }
                                        ?>
                                        <th>{{ $count }}</th>
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
                                                @foreach ($record->product as $pro)
                                                    <tr>
                                                        <th>{{ $pro->one_product->name }}</th>
                                                        <th>{{ $pro->price }}</th>
                                                        <th>{{ $pro->amount }}</th>

                                                    </tr>
                                                @endforeach

                                            </table>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="2">
                                            <center>
                                                <img style="width:1.75in;height:1.75in"
                                                    src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ 123 }}&choe=UTF-8" />
                                            </center>

                                        </td>
                                    </tr>


                                </tbody>
                            </table>

                        </center>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-primary"
                                onclick="printContent('printLabel{{ $record->id }}');">Print
                            </button>
                        </center>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalCenterProducts{{ $record['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    Product
                                </td>
                                <td>
                                    total price
                                </td>
                                <td>
                                    amount
                                </td>

                            </tr>
                            <?php $price = 0; ?>
                            @foreach ($record->product as $pro)
                                <tr>

                                    <td>
                                        {{ $pro->one_product->name }}
                                    </td>
                                    <td>
                                        {{ $pro->price }}
                                    </td>
                                    <td>
                                        {{ $pro->amount }}
                                    </td>
                                    <?php $price += $pro->price; ?>

                                </tr>
                            @endforeach

                        </table>
                        <hr>
                        <h3 class="text-center">
                            total price : {{ $price }}
                        </h3>
                        <?php $price = 0; ?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModalCenter{{ $record['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    {{ $record->shop['title_ar'] }}
                                </td>
                                <td>
                                    {{ $record->shop['title_en'] }}
                                </td>
                                <td>
                                    {{ $record->shop->shopType['title_' . App::getLocale()] }}
                                </td>
                                <td>
                                    {{ $record->shop['shop_url'] }}
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
        <div class="modal fade" id="exampleModalCenterCustomer{{ $record['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                    {{ $record->customer_name }}
                                </td>
                                <td>
                                    {{ $record->customer_phone1 }}
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
        <div class="modal fade" id="exampleModalCenterAddress{{ $record['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                @if ($record->country)
                                    <td>
                                        {{ $record->country['title_' . App::getLocale()] }}
                                    </td>
                                @else
                                    <td>
                                        There is no country yet!
                                    </td>
                                @endif
                                @if ($record->city)
                                    <td>
                                        {{ $record->city['title_' . App::getLocale()] }}
                                    </td>
                                @else
                                    <td>
                                        There is no city yet!
                                    </td>
                                @endif
                                @if ($record->zone)
                                    <td>
                                        {{ $record->zone['title_' . App::getLocale()] }}
                                    </td>
                                @else
                                    <td>
                                        There is no zone yet!
                                    </td>
                                @endif
                                @if ($record->district)
                                    <td>
                                        {{ $record->district['title_' . App::getLocale()] }}
                                    </td>
                                @else
                                    <td>
                                        There is no district yet!
                                    </td>
                                @endif
                                <td>
                                    {{ $record->address }}
                                </td>

                            </tr>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script>
        function printContent(el) {
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            $('body').empty().html(printcontent);

            window.print();
            $('body').html(restorepage);
            var ell = moka(el);
            document.location.href = 'https://codafrican.com/en/packaging/change_order_state_supporter/' + ell + '/4/8';
        }

        function printAll(el) {
            console.log(el);
            var restorepage = $('body').html();
            var printcontent = $('#' + el).clone();
            printcontent.css('display', 'block');
            $('body').empty().html(printcontent);
            window.print();
            $('body').html(restorepage);
            printcontent.css('display', 'none');
            document.location.href = 'https://codafrican.com/en/packaging/change_order_state_all/8';

        }

        function moka(x) {
            var length = 10;
            var trimmedString = x.substring(9999, length);
            return parseInt(trimmedString);
        }

        moka();
    </script>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#example21').dataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "bAutoWidth": false,
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            });
        });
    </script>
@endsection
