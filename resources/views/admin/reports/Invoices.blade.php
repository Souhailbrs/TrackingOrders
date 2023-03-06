@extends('layouts.admin')
@section('pageTitle', 'Users Page')

@section('content')
    <div>
        <!-- CSS Files -->
        <?php $lang = 'en'; ?>
        <link href="{{ asset('assets/admin/' . $lang . '/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/' . $lang . '/css/bootstrap-extended.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/' . $lang . '/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/admin/' . $lang . '/css/icons.css') }}" rel="stylesheet">
        <style>
            .hr-invoice {
                border-top: 10px solid green;
                padding-top: 20px;
            }

            @media print {
                .hr-invoice {
                    background-color: white;
                    height: 100%;
                    width: 100%;
                    position: fixed;
                    top: 0;
                    left: 0;
                    margin: 0;
                    padding: 15px;
                    font-size: 14px;
                    line-height: 18px;
                }
            }
        </style>
        <form class="page-breadcrumb d-none d-sm-flex align-items-center mb-3"
            action="{{ route('earningsReports.reports.post', ['seller' => $seller, 'type' => 'orders', 'country' => $country]) }}"
            method="post">
            @csrf
            <div class="breadcrumb-title pe-3">Reports</div>

            <div class="ps-3">

                <nav aria-label="breadcrumb">
                    <span class="d-block">
                        From
                    </span>
                    <input type="date" name="from"
                        @if (!empty($dateS)) value="{{ $dateS }}" @endif
                        class="btn btn-outline-primary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                </nav>

            </div>
            <div class="ps-3">

                <nav aria-label="breadcrumb">
                    <span class="d-block">
                        To
                    </span>
                    <input type="date" name="to"
                        @if (!empty($dateE)) value="{{ $dateE }}" @endif
                        class="btn btn-outline-primary breadcrumb mb-0 p-0 align-items-center col-sm-12">

                </nav>

            </div>
            <div class="ps-3">
                <span class="d-block">
                    &#160;
                </span>
                <nav aria-label="breadcrumb">
                    <button type="submit" class="btn btn-outline-primary ">Filter</button>

                </nav>

            </div>
        </form>

        <div class="row">
            <div class="col-sm-12 text-center">
                <button style="width:200px" class="btn btn-outline-primary text-center"
                    onclick="PrintElem('hr-invoice')">Print
                </button>
            </div>
            <br><br>
        </div>
        <div id="hr-invoice" class="hr-invoice">

            <h1>CCOD AFRICA NETWORK</h1>
            <br>
            <h6>
                <input type="text"
                    style="
                width: 100px !important;
                padding:0;
                margin:0;
                "
                    class="btn convert_print" id="city" value="Nouakchott"> ,
                {{ App\Models\Country::where('id', $country)->pluck('title_en')->first() }}
                <br>
                (222) 33 60 66 86

            </h6>
            <br><br>
            <h1 style="font-weight:bolder">
                Invoice
            </h1>
            <h5 style="color:red">
                Sent on <?php echo empty($dateE) ? date('d/m/Y') : date('d/m/Y', strtotime($dateE)); ?>

            </h5>
            <br><br>
            <div class="container h6">
                <div class="col">
                    <div class="col-sm-4">
                        Invoice for
                    </div>
                    <br>
                    <div class="col-sm-4">
                        {{ $seller->name }}

                    </div>
                    <div class="col-sm-4">
                        +{{ $seller->phone }}
                    </div>
                    <div class="col-sm-4">
                        {{ $seller->email }}
                    </div>
                </div>

            </div>
            <br>
            <br>

            <table class="table  table-striped ">
                <thead>
                    <tr>
                        <th class="col-sm-6">
                            Description
                        </th>
                        <th class="col-sm-2">
                            Quantity
                        </th>
                        <th class="col-sm-2">
                            Unit price
                        </th>
                        <th class="col-sm-2">
                            Total price
                        </th>

                    </tr>
                </thead>
                <tbody>
                    <?php $total_orders_price = 0; ?>
                    @foreach ($orders as $order)
                        @foreach ($order->product as $pro)
                            <tr>
                                <td>{{ $pro->one_product->name }}</td>
                                <td>{{ $pro->amount }}</td>
                                <td>{{ $pro->price / $pro->amount }} MRO</td>
                                <td>{{ $pro->price }} MRO</td>
                                <?php $total_orders_price += $pro->price; ?>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <br>
            <table style="width:100%">
                <tr>
                    <td colspan="2">
                        Orders Delivered
                    </td>
                    <td>
                        <input type="text" class="btn convert_print" id="CcommandesLivres">
                    </td>
                    <td>

                    </td>
                    <td colspan="2">
                        Subtotal
                    </td>
                    <td>
                        <input id="orders_total_price" type="text" class="btn convert_print"
                            value="{{ $total_orders_price }}" readonly="1">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Items delivered
                    </td>
                    <td>
                        <input type="text" class="btn  convert_print" id="Articleslivres">
                    </td>
                    <td>

                    </td>
                    <td colspan="2">
                        COD FEES
                    </td>
                    <td>
                        <input type="text" value="0" class="btn  convert_print" id="codfees" onchange="myFun1()">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Sourcing products
                    </td>
                    <td>
                        <input type="text" class="btn  convert_print" id="sourcing_product">
                    </td>
                    <td>

                    </td>
                    <td colspan="2">
                        Confirmation fee
                    </td>
                    <td>
                        <input type="text" value="0" class="btn  convert_print" id="frais_confirmat"
                            onchange="myFun1()">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        Shipping products
                    </td>
                    <td>
                        <input type="text" class="btn  convert_print" id="sourcing_product">
                    </td>
                    <td>

                    </td>
                    <td colspan="2">
                        Shipping cost
                    </td>
                    <td>
                        <input type="text" value="0" class="btn  convert_print" id="frais_livraison"
                            onchange="myFun1()">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">

                    </td>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td colspan="3">
                        <input type="text" class="btn  convert_print" id="result" readonly="1">
                    </td>

                </tr>

            </table>

        </div>
    </div>
    <script>
        function PrintElem(elem) {
            var mywindow = window.open('', 'PRINT', 'height=400,width=600');

            mywindow.document.write('<html><head><title>' + document.title + '</title>');
            mywindow.document.write('</head><body >');
            mywindow.document.write('<h1>' + document.title + '</h1>');


            var codfees = document.getElementById('codfees');
            codfees.setAttribute("value", codfees.value);
            codfees.style.border = '0';

            var frais_confirmat = document.getElementById('frais_confirmat');
            frais_confirmat.setAttribute("value", frais_confirmat.value);
            frais_confirmat.style.border = '0';

            var frais_livraison = document.getElementById('frais_livraison');
            frais_livraison.setAttribute("value", frais_livraison.value);
            frais_livraison.style.border = '0';

            var city = document.getElementById('city');
            city.setAttribute("value", city.value);
            city.style.border = '0';

            var result = document.getElementById('result');
            result.setAttribute("value", result.value);
            result.style.border = '0';

            var orders_total_price = document.getElementById('orders_total_price');
            orders_total_price.setAttribute("value", orders_total_price.value);
            orders_total_price.style.border = '0';

            var CcommandesLivres = document.getElementById('CcommandesLivres');
            CcommandesLivres.setAttribute("value", CcommandesLivres.value);
            CcommandesLivres.style.border = '0';

            var Articleslivres = document.getElementById('Articleslivres');
            Articleslivres.setAttribute("value", Articleslivres.value);
            Articleslivres.style.border = '0';


            mywindow.document.write(document.getElementById(elem).innerHTML);
            mywindow.document.write('</body></html>');

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/

            mywindow.print();

        }

        function myFun1() {

            var orders_total_price = parseFloat(document.getElementById('orders_total_price').value);
            var codfees = parseFloat(document.getElementById('codfees').value);
            var frais_confirmat = parseFloat(document.getElementById('frais_confirmat').value);
            var frais_livraison = parseFloat(document.getElementById('frais_livraison').value);
            var result = document.getElementById('result');

            var res = orders_total_price - (frais_confirmat + frais_livraison + (codfees / 100 * orders_total_price));

            result.value = parseFloat(res).toFixed(3) + ' MRO';

        }
    </script>

@endsection
