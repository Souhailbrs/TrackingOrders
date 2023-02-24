@extends('layouts.admin')
@section('pageTitle', 'Sells Channels')
@section('style')
@endsection

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! \Session::get('success') !!}
            <button type="btn btn-outline-secondary" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (\Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {!! \Session::get('error') !!}
            <button type="btn btn-outline-secondary" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive ">


                    <div class="row">
                        <div class="col-12 ">

                            <div class="row ">
                                <div class="col-sm-1"></div>
                                <a href="{{ route('admin.orders.index', ['state' => 'today', 'from' => '1', 'to' => '1']) }}"
                                    class="col-sm-3 mr-1 btn btn-outline-dark" style="margin-right: 10px"> Today
                                    Orders</a>
                                <a href="{{ route('admin.orders.index', ['state' => '7days', 'from' => '1', 'to' => '1']) }}"
                                    class="col-sm-3 mr-1 btn btn-outline-dark" style="margin-right: 10px">Last 7
                                    Days</a>
                                <a data-bs-toggle="modal" data-bs-target="#exampleModalCenterCustom"
                                    class="col-sm-3 btn btn-outline-dark">Custom Date</a>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-8">
                                    <form
                                        action="{{ route('admin.orders.index', ['state' => $state, 'from' => $from, 'to' => $to]) }}"
                                        method="get">
                                        <input value="{{ $search }}" name="search" type="text"
                                            class="col-sm-8 btn-outline-primary"
                                            placeholder="Search with order number or customer phone">
                                        <select class="col-sm-4 btn btn-outline-primary" name="status" onchange="submit()">
                                            <option value="all">Filter With Status</option>
                                            @if (isset($request->status) && $request->status == 0)
                                                <option value="0">{{ __('orders.new_order') }}</option>
                                            @elseif(isset($request->status) && $request->status == 1)
                                                <option value="1"> {{ __('orders.call_center_received') }}</option>
                                            @elseif(isset($request->status) && $request->status == 2)
                                                <option value="2"> {{ __('orders.no_answer_call_center') }}
                                                </option>
                                            @elseif (isset($request->status) && $request->status == 3)
                                                <option value="3"> {{ __('orders.wrong_answer') }}</option>
                                            @elseif(isset($request->status) && $request->status == 4)
                                                <option value="4"> {{ __('orders.confirm_order') }}</option>
                                            @elseif(isset($request->status) && $request->status == 5)
                                                <option value="5"> {{ __('orders.not_confirm_order') }}</option>
                                            @elseif(isset($request->status) && $request->status == 6)
                                                <option value="6"> {{ __('orders.canceled_order') }}</option>
                                            @elseif(isset($request->status) && $request->status == 7)
                                                <option value="7"> {{ __('orders.ready_to_be_delivered') }}
                                                </option>
                                            @elseif(isset($request->status) && $request->status == 8)
                                                <option value="8">{{ __('orders.received_by_delivery') }}</option>
                                            @elseif(isset($request->status) && $request->status == 9)
                                                <option value="9"> {{ __('orders.delivery_refused_order') }}
                                                </option>
                                            @elseif(isset($request->status) && $request->status == 10)
                                                <option value="10"> {{ __('orders.customer_received') }}</option>
                                            @elseif(isset($request->status) && $request->status == 11)
                                                <option value="11">{{ __('orders.canceled_order') }}</option>
                                            @elseif(isset($request->status) && $request->status == 12)
                                                <option value="12"> {{ __('orders.no_answer_delivery_boy') }}
                                                </option>
                                            @elseif(isset($request->status) && $request->status == 13)
                                                <option value="13"> {{ __('orders.customer_didnot_deliver') }}
                                                </option>
                                            @endif


                                            <option value="0">{{ __('orders.new_order') }}</option>
                                            <option value="1"> {{ __('orders.call_center_received') }}</option>
                                            <option value="2"> {{ __('orders.no_answer_call_center') }}</option>
                                            <option value="3"> {{ __('orders.wrong_answer') }}</option>
                                            <option value="4"> {{ __('orders.confirm_order') }}</option>
                                            <option value="5"> {{ __('orders.not_confirm_order') }}</option>
                                            <option value="6"> {{ __('orders.canceled_order') }}</option>
                                            <option value="7"> {{ __('orders.ready_to_be_delivered') }}</option>
                                            <option value="8">{{ __('orders.received_by_delivery') }}</option>
                                            <option value="9"> {{ __('orders.delivery_refused_order') }}</option>
                                            <option value="10"> {{ __('orders.customer_received') }}</option>
                                            <option value="11">{{ __('orders.canceled_order') }}</option>
                                            <option value="12"> {{ __('orders.no_answer_delivery_boy') }}</option>
                                            <option value="13"> {{ __('orders.customer_didnot_deliver') }}</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="col-sm-3">
                                    <form style="display: inline-block"
                                        action="{{ route('admin.orders.index', ['state' => $state, 'from' => $from, 'to' => $to]) }}"
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
                                                    <option value="10000">10000</option>
                                                @endif
                                            @else
                                                <option value="10">10</option>

                                                <option value="50">50</option>

                                                <option value="100">100</option>

                                                <option value="500">500</option>

                                                <option value="1000">1000</option>

                                                <option value="10000">10000</option>
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

                                        <table id="example3" class="table table-striped table-bordered pt-3 text-center"
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
                                                @foreach ($records as $record)
                                                    <tr @if ($record->deleted == 1) class="bg-light-danger" @endif>

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
                                                        <td class="text-center" style="max-width: 200px !important;">


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
                                                                href="{{ route('admin.site.trackOrder', ['id' => $record->id]) }}">


                                                                @if ($record->status == 0)
                                                                    <span class=" btn btn-light"
                                                                        style="width: 200px;">{{ __('orders.new_order') }}</span>
                                                                @elseif($record->status == 1)
                                                                    <span class="btn btn-light" style="width: 200px;">
                                                                        {{ __('orders.call_center_received') }}</span>
                                                                @elseif($record->status == 2)
                                                                    <span class=" btn btn-warning" style="width: 200px;">
                                                                        {{ __('orders.no_answer_call_center') }}</span>
                                                                @elseif ($record->status == 3)
                                                                    <span class="btn btn-dark" style="width: 200px;">
                                                                        {{ __('orders.wrong_answer') }}</span>
                                                                @elseif($record->status == 4)
                                                                    <span class="btn btn-blue" style="width: 200px;">
                                                                        {{ __('orders.confirm_order') }}</span>
                                                                @elseif($record->status == 5)
                                                                    <span class="btn btn-secondary" style="width: 200px;">
                                                                        {{ __('orders.not_confirm_order') }}</span>
                                                                @elseif($record->status == 6)
                                                                    <span class="btn btn-danger" style="width: 200px;">
                                                                        {{ __('orders.canceled_order') }}</span>
                                                                @elseif($record->status == 7)
                                                                    <span class="btn btn-info" style="width: 200px;">
                                                                        {{ __('orders.ready_to_be_delivered') }}</span>
                                                                @elseif($record->status == 8)
                                                                    <span class="btn btn-info"
                                                                        style="width: 200px;">{{ __('orders.received_by_delivery') }}</span>
                                                                @elseif($record->status == 9)
                                                                    <span class="btn btn-danger" style="width: 200px;">
                                                                        {{ __('orders.delivery_refused_order') }}</span>
                                                                @elseif($record->status == 10)
                                                                    <span class="btn btn-success" style="width: 200px;">
                                                                        {{ __('orders.customer_received') }}</span>
                                                                @elseif($record->status == 11)
                                                                    <span class="btn btn-danger"
                                                                        style="width: 200px;">{{ __('orders.canceled_order') }}</span>
                                                                @elseif($record->status == 12)
                                                                    <span class="btn btn-warning" style="width: 200px;">
                                                                        {{ __('orders.no_answer_delivery_boy') }}</span>
                                                                @elseif($record->status == 13)
                                                                    <span class="btn btn-danger" style="width: 200px;">
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
                                                                            href="{{ route('customOrders.show', ['customOrder' => $record->id]) }}">View</a>
                                                                        <a class="dropdown-item  col-sm-12 d-block"
                                                                            href="{{ route('customOrders.edit', ['customOrder' => $record->id]) }}">Edit</a>
                                                                        @if ($record->deleted == 1)
                                                                            <a class="dropdown-item col-sm-12 d-block"
                                                                                href="">Restore</a>
                                                                        @endif
                                                                        <form
                                                                            action="{{ route('customOrders.destroy', ['customOrder' => $record->id]) }}"
                                                                            method="post">
                                                                            @method('delete')
                                                                            @csrf
                                                                            <button class="dropdown-item col-sm-12 d-block"
                                                                                type="submit">Delete
                                                                            </button>
                                                                        </form>


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


                {{ $records->links() }}

            </div>
        </div>
    </div> <!-- end col -->

    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>

    <!-- Name -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenterCustom" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Custom Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.orders.postDate') }}" method="post">
                        @csrf
                        From <input type="date" class="form-control" name="from" required>
                        To <input type="date" class="form-control" name="to" required>
                        <br>
                        <center>
                            <input type="submit" value="submit" class="btn btn-dark">
                        </center>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @foreach ($records as $record)
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
                                    Product Image
                                </td>
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
                            <?php $price = 0; ?>
                            @foreach ($record->product as $pro)
                                <tr style="text-center">
                                    <td style="text-center">
                                        <img style="height:70px;width:70px"
                                            src="{{ asset('assets/admin/products/' . $pro->one_product->image) }}"
                                            alt="">
                                    </td>
                                    <td>
                                        {{ $pro->one_product->product_name }}
                                    </td>
                                    <td>
                                        {{ $pro->price }}
                                    </td>
                                    <td>
                                        {{ $pro->amount }}
                                    </td>

                                </tr>
                            @endforeach

                        </table>

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
                                    Name
                                </td>

                                <td>
                                    Shop Url
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    {{ $record->shop['title_en'] }}
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
                                    {{ $record->customer_phone1 }}
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
                                @if (!empty($record->city))
                                    <td>
                                        {{ $record->city['title_' . App::getLocale()] }}
                                    </td>
                                @else
                                    <td>
                                        There is no city yet!
                                    </td>
                                @endif
                                @if (!empty($record->zone))
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="alert alert-danger" role="alert">
        <h4 class="d-flex justify-content-center">
            Delete History
        </h4>
        <form action="{{ route('admin.orders.deleteOrders') }}" method="post">
            @csrf
            <div class="d-flex justify-content-center">
                <div class="d-inline-flex">

                    <div class="d-flex flex-row">
                        <div class="ps-3">
                            <p>Do you want to delete orders </p>
                        </div>
                        <div class="ps-3">

                            <nav aria-label="breadcrumb">
                                <span class="d-block">
                                    From
                                </span>
                                <input type="date" name="fromDeleted"
                                    class="btn btn-outline-secondary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                            </nav>

                        </div>
                        <div class="ps-3">

                            <nav aria-label="breadcrumb">
                                <span class="d-block">
                                    To
                                </span>
                                <input type="date" name="toDeleted"
                                    class="btn btn-outline-secondary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                            </nav>

                        </div>
                        <span class="d-block">
                            &#160;
                        </span>
                        <nav aria-label="breadcrumb">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#DeleteModal">
                                Delete History Orders
                            </button>
                        </nav>
                    </div>
                    <hr>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confimation</h5>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                if you click on delete please wait until it deleted don't reload the page just be patient
                                until
                                it done!
                                some date intervals have a lot of data so it may take a while!
                            </div>
                            Are you sure you want delete the history of orders between the selected dates ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Yes, i'am sure</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#example2').dataTable({
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
