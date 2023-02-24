<?php

use App\Models\Order;
use App\Models\SalesChannels;
use App\Models\Seller;
use Illuminate\Support\Carbon;

function getSellerNeeds($seller)
{
    $seller = Seller::find($seller);
    $shops = SalesChannels::where('owner_email', $seller->email)->get();

    $orders = [];
    foreach ($shops as $shop) {
        if (empty($dateS) || empty($dateE)) {
            $orders[] = Order::where('sales_channel', $shop->id)
                ->where('status', 10)
                ->get();
        } else {
            $orders[] = Order::whereBetween('created_at', [$dateS->format('Y-m-d'), $dateE->format('Y-m-d')])
                ->where('sales_channel', $shop->id)
                ->where('status', 10)
                ->get();
        }
    }
    $orders_res = [];
    foreach ($orders as $order) {
        foreach ($order as $ord) {
            $orders_res[] = $ord;
        }
    }
    $orders = $orders_res;
    $total = 0;
    foreach ($orders as $ord) {
        foreach ($ord->product as $pro) {
            $total += intval($pro->price);
        }
    }

    return $total;
}
?>
@extends('layouts.admin')
@section('pageTitle', 'Users Page')
@section('style')
@endsection
@section('content')

    <div class="page-content">

        <!--start breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <form class="page-breadcrumb d-none d-sm-flex align-items-center mb-3" action="{{ route('earningsFromTo') }}"
                method="GET">
                <div class="breadcrumb-title pe-3">Reports</div>

                <div class="ps-3">

                    <nav aria-label="breadcrumb">
                        <span class="d-block">
                            From
                        </span>
                        <input type="date" name="from"
                            @if (!empty($dateS)) value="{{ $dateS->format('Y-m-d') }}" @endif
                            class="btn btn-outline-primary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                    </nav>

                </div>
                <div class="ps-3">

                    <nav aria-label="breadcrumb">
                        <span class="d-block">
                            To
                        </span>
                        <input type="date" name="to"
                            @if (!empty($dateE)) value="{{ $dateE->format('Y-m-d') }}" @endif
                            class="btn btn-outline-primary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                    </nav>

                </div>
                <div class="ps-3">
                    <span class="d-block">
                        &#160;
                    </span>
                    <nav aria-label="breadcrumb">
                        <input type="submit" class="btn btn-outline-primary ">

                    </nav>

                </div>
            </form>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0 align-items-center">
                        <li class="breadcrumb-item active" aria-current="page">Seller Earnings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!--start shop area-->
        <section class="shop-page">
            <div class="shop-container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive ">


                                <div class="container-fluid">


                                    <div class="row">
                                        <div class="col-12">

                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="example2"
                                                            class="table table-striped table-bordered pt-3 text-center">
                                                            <thead>
                                                                <tr class="text-center">
                                                                    <th>ID</th>
                                                                    <th>Image</th>
                                                                    <th>Name</th>
                                                                    <th>Need</th>
                                                                    <th>Contact</th>
                                                                    <th>View Reports</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($sellers as $record)
                                                                    <tr>
                                                                        <td>#{{ $record->id }}</td>
                                                                        <td>
                                                                            <img style="height:100px;width:100px;"
                                                                                src="{{ asset('assets/admin/users/' . $record->image) }}">
                                                                        </td>
                                                                        <td>#{{ $record->name }}</td>
                                                                        <td>
                                                                            @foreach ($sellers_total as $key => $value)
                                                                                @if ($key == $record->id - 1)
                                                                                    <?php echo "$" . reset($value); ?>
                                                                                @endif
                                                                            @endforeach
                                                                            {{-- $<?php echo getSellerNeeds($record->id); ?> --}}
                                                                        </td>
                                                                        <td>
                                                                            <div class="row">
                                                                                <div class="col-sm-2"></div>
                                                                                <div class="product-wishlist col-sm-4">
                                                                                    <a style="display:inline-block;margin-right: 30px"
                                                                                        href="https://wa.me/{{ '00222' }}?text={{ '' }}"
                                                                                        data-action="share/whatsapp/share"
                                                                                        target="_blank" class=" ">
                                                                                        <img src="{{ asset('assets/site/images/Flat-logo-WhatsApp-PNG.png') }}"
                                                                                            height="40" width="40"
                                                                                            alt="...">
                                                                                    </a>
                                                                                </div>
                                                                                <div class="col-sm-4 m-1 p-1 pr-2 pl-2 btn btn-primary"
                                                                                    style="display:inline-block">
                                                                                    <a href="tel:+" target="_blank"
                                                                                        height="40" width="40"
                                                                                        class=" text-white text-decoration-none">
                                                                                        <i class="fa fa-phone"> </i> </a>
                                                                                    {{-- <a href="tel:+900300400">Phone: 900 300 400</a> --}}
                                                                                </div>
                                                                                <div class="col-sm-2"></div>

                                                                            </div>

                                                                        </td>

                                                                        <td>
                                                                            <a href="{{ route('earningsReports.reports', ['seller' => $record->id, 'type' => 'products']) }}"
                                                                                class="btn btn-primary btn-ecomm"><i
                                                                                    class="bx bxs-add-to-queue"></i>Products</a>
                                                                            <a href="{{ route('earningsReports.reports', ['seller' => $record->id, 'type' => 'orders']) }}"
                                                                                class="btn btn-primary btn-ecomm"><i
                                                                                    class="bx bxs-add-to-queue"></i>Orders</a>
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


            </div>
        </section>
        <!--end shop area-->

    </div>
    <script type="text/javascript">
        window.onload = function() {
            $("#filter").keyup(function() {

                var filter = $(this).val(),
                    count = 0;

                $('.results').each(function() {

                    if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                        $(this).hide();

                    } else {
                        $(this).show();
                        count++;
                    }
                });
            });
        }
    </script>

@endsection
