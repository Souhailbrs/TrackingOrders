@extends('layouts.supporter')

@section('pageTitle', $action . ' ' . $page)
@section('content')
    <div class="card col-sm-12">
        <div class="card-body">
            @include('admin.includes.messages')
            <br>
            @if ($action == 'store')
                <form method="post" action="{{ route('supporter.' . $pages . '.' . $action) }}" id="myForm">
                @else
                    <form method="post" action="{{ route('supporter.' . $pages . '.' . $action, ['order' => $data->id]) }}"
                        id="myForm">
                        @method('PUT')
            @endif
            @csrf
            <div class="row">
                <a style="display:block;color:white" target="_blank"
                    href="{{ route('supporter.site.trackOrder', ['id' => $data->id]) }}"
                    class="col-sm-2 btn btn-dark h6 pt-2">
                    Track Order
                </a>

                <div class="col-sm-8">
                    <?php $last_status = \App\Models\OrderTrack::where('sales_channele_order', $data->id)->get();
                    if (count($last_status) - 2 < 0) {
                        $index = 0;
                    } else {
                        $index = count($last_status) - 2;
                        if ($index < 0) {
                            $index = 0;
                        }
                    }
                    $last_status = $last_status[$index];
                    
                    ?>

                    <div class="col-sm-12 h6 text-center">
                        @if ($last_status->last_status == 0)
                            <span class="btn btn-warning" style="width:500px"> # {{ $data->id }} is New Order</span>
                        @elseif($last_status->last_status == 1)
                            <span class="btn btn-info" style="width:500px"># {{ $data->id }} is Call Center
                                Received</span>
                        @elseif($last_status->last_status == 2)
                            <span class="btn btn-danger" style="width:500px"> # {{ $data->id }} is No Answer Call
                                Center</span>
                        @elseif ($last_status->last_status == 3)
                            <span class="btn btn-danger" style="width:500px"> # {{ $data->id }} is Wrong Answer</span>
                        @elseif($last_status->last_status == 4)
                            <span class="btn btn-success" style="width:500px"> # {{ $data->id }} is Confirm Order</span>
                        @elseif($last_status->last_status == 5)
                            <span class="btn btn-secondary" style="width:500px"> # {{ $data->id }} is Not Confirm
                                Order</span>
                        @elseif($last_status->last_status == 6)
                            <span class="btn btn-danger" style="width:500px"># {{ $data->id }} Cancelled Order</span>
                        @elseif($last_status->last_status == 7)
                            <span class="btn btn-success" style="width:500px"> # {{ $data->id }} is Ready to be
                                Delivered</span>
                        @elseif($last_status->last_status == 8)
                            <span class="btn btn-success" style="width:500px"> # {{ $data->id }} is Received by
                                Delivery</span>
                        @elseif($last_status->last_status == 9)
                            <span class="btn btn-danger" style="width:500px"># {{ $data->id }} is Delivery Refused
                                Order</span>
                        @elseif($last_status->last_status == 10)
                            <span class="btn btn-primary" style="width:500px"> # {{ $data->id }} is Customer
                                Received</span>
                        @elseif($last_status->last_status == 11)
                            <span class="btn btn-danger" style="width:500px"># {{ $data->id }} is Customer
                                Refused</span>
                        @elseif($last_status->last_status == 12)
                            <span class="btn btn-danger" style="width:500px"># {{ $data->id }} is No Answer Delivery
                                Boy</span>
                        @elseif($last_status->last_status == 13)
                            <span class="btn btn-danger" style="width:500px"> # {{ $data->id }} is Customer Didn't
                                deliver</span>
                        @endif
                    </div>




                </div>

                {{-- <a style="display:block;color:white"
                    href="{{ route('supporter.end.order_state', ['order' => $data->id, 'old' => $data->status, 'new' => 7]) }}"
                    class="col-sm-2 btn btn-danger h6 pt-2">
                    Next Order
                </a> --}}

            </div>


            <br>
            <div class="form-control text-center" style="border: 0 solid black">
                <div class="col-sm-1 mr-1">
                </div>
                <a class="col-sm-2 mr-1 btn btn-dark h6"
                    href="{{ route('supporter.change.order_state', ['order' => $data->id, 'old' => $data->status, 'new' => 2]) }}"
                    style="color:white">
                    No Answer
                </a>

                <a class="col-sm-2 mr-1 btn btn-dark h6"
                    href="{{ route('supporter.change.order_state', ['order' => $data->id, 'old' => $data->status, 'new' => 3]) }}"
                    style="color:white">

                    Wrong Number
                </a>

                <a data-bs-toggle="modal" data-bs-target="#exampleModalCenterConfirmed"
                    class="col-sm-2 mr-1 btn btn-dark h6" style="color:white" href="">
                    Confirmed
                </a>

                <a class="col-sm-2 mr-1 btn btn-dark h6"
                    href="{{ route('supporter.change.order_state', ['order' => $data->id, 'old' => $data->status, 'new' => 5]) }}"
                    style="color:white">
                    Not Confirmed
                </a>
                <a data-bs-toggle="modal" data-bs-target="#exampleModalCenterNotConfirmed"
                    class="col-sm-2 mr-1 btn btn-dark h6" style="color:white" href="">
                    Cancelled
                </a>
            </div>
            <br>
            <div class="form-control text-center" style="border: 0 solid black">



                <a style="display:inline-block;margin-right: 30px" href="{{ $data->url }}" target="_blank"
                    class=" ">
                    <img src="{{ asset('assets/site/images/url.jpg') }}" height="40" width="40" alt="...">
                </a>

                <?php
                $product_name = '';
                foreach ($data->product as $or) {
                    $product_name .= $or->one_product->name . ' , ';
                }
                
                $whats = 'مرحبا (' . $data->customer_name . ') معكم فريق تأكيد الطلبات نتصل بكم بخصوص منتوجكم ( ' . $product_name . ')،  اتصلنا بكم ولم وتردو ...سنتصل بكم مرة أخرى لتوصيل طلبيتكم ...';
                $whats .= ' رابط المنج' . $data->url;
                ?>
                <a style="display:inline-block;margin-right: 30px"
                    href="https://api.whatsapp.com/send?phone=+{{ $data->customer_phone1 }}&text={{ $whats }}"
                    data-action="share/whatsapp/share" target="_blank" class=" ">
                    <img src="{{ asset('assets/site/images/Flat-logo-WhatsApp-PNG.png') }}" height="40" width="40"
                        alt="...">
                </a>


                <div class="col- m-1 p-1 pr-2 pl-2 btn btn-success" style="display:inline-block">
                    <a href="tel:+{{ $data->customer_phone1 }}" target="_blank" height="40" width="40"
                        class=" text-white text-decoration-none"> <i class="fa fa-phone"> </i> </a>
                    {{-- <a href="tel:+900300400">Phone: 900 300 400</a> --}}
                </div>



            </div>



            <hr>
            <div class="row">

                <div class="col-sm-12 text-center">

                    <input class="form-control btn-dark text-center" type="button" id="example-text-input" value="Add More"
                        onClick="clone()">

                </div>

            </div>

            <div id="product_id_original">
                <div class="row">
                </div>
                <br>

                @if ($action == 'update')
                    @foreach ($data->product as $pro)
                        <div id="product_id1">
                            <div class="row mt-2">
                                <div class="col-sm-2">
                                    <button data-toggle="modal"
                                        data-target="#exampleModalCenterProduct{{ $pro->one_product->id }}"
                                        class="btn btn-primary col-sm-12" type="button">View image</button>
                                </div>
                                <div class="col-sm-3 ">
                                    <select class="form-control products_id product_id_view" name="products_id[]"
                                        required>
                                        <option value="{{ $pro->one_product->id }}">{{ $pro->one_product->name }}
                                        </option>

                                        @foreach ($data->shop->products as $proo)
                                            @if ($proo->product->id != $pro->one_product->id)
                                                <option value="{{ $proo->product->id }}">{{ $proo->product->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="text" id="example-text-input"
                                        name="products_price[]" placeholder="Price" required
                                        value="{{ $pro->price }}">
                                </div>
                                <div class="col-sm-3">
                                    <input class="form-control" type="text" id="example-text-input" required
                                        name="products_amount[]" placeholder="Amount" value="{{ $pro->amount }}">
                                </div>
                                <div id="i" type="button" class="col-sm-1 btn btn-danger"
                                    onclick="removeClone(this)" q>remove
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div id="product_id" style="display:none;">
                @if (count($data->product) > 0)
                    <div class="row mt-2">
                        <div class="col-sm-2">
                            <button data-toggle="modal"
                                data-target="#exampleModalCenterProduct{{ $pro->one_product->id }}"
                                class="btn btn-primary col-sm-12" style="color:black" type="button">View image</button>
                        </div>
                        <div class="col-sm-3 ">
                            <select class="form-control products_id product_id_view" name="products_id[]">
                                <option value="{{ $pro->one_product->id }}">{{ $pro->one_product->name }}</option>

                                @foreach ($data->shop->products as $proo)
                                    @if ($proo->product->id != $pro->one_product->id)
                                        <option value="{{ $proo->product->id }}">{{ $proo->product->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" id="example-text-input" name="products_price[]"
                                placeholder="Price" value="{{ $pro->price }}">
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" id="example-text-input" name="products_amount[]"
                                placeholder="Amount" value="{{ $pro->amount }}">
                        </div>
                        <div id="i" type="button" class="col-sm-1 btn btn-danger" onclick="removeClone(this)">
                            remove
                        </div>

                    </div>
                @endif
            </div>
            <hr>
            <!--     Customer Details                               -->
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __('Customer Name') }}</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="example-text-input" required disabled
                        name="customer_name" @if ($action == 'update') value="{{ $data->customer_name }}" @endif>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __('Customer Phone1') }}</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="example-text-input" required disabled
                        name="customer_phone1"
                        @if ($action == 'update') value="{{ $data->customer_phone1 }}" @endif>
                </div>
            </div>
            <div class="form-group row">
                <label for="example-text-input" class="col-sm-2 col-form-label">{{ __('Seller Notes') }}</label>
                <div class="col-sm-10">
                    <textarea class="form-control" type="text" id="example-text-input" disabled name="customer_notes">
@if ($action == 'update')
{{ $data->customer_notes }}
@endif
</textarea>
                </div>
            </div>


            <br>
            <div class="form-group row">
                <div class="col-12 text-center">
                    @if ($action == 'store')
                        <button type="submit" class="btn btn-dark w-25">{{ __('admin/general.add_new') }}</button>
                    @else
                        <button type="submit" class="btn btn-dark w-25">{{ __('admin/general.edit_details') }}</button>
                    @endif
                </div>
            </div>
            <br>

            </form>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenterConfirmed" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Confirmed Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>


                </div>
                <div class="modal-body">
                    <form method="post"
                        action="{{ route('supporter.' . $pages . '.' . $action, ['order' => $data->id]) }}"
                        id="myForm">
                        @method('PUT')
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-sm-3 col-form-label">{{ __('admin/fields.country') }}</label>
                            <div class="col-sm-9">
                                {{ $data->country['title_' . App::getLocale()] }}
                            </div>
                        </div>

                        <?php
                        
                        $cities = \App\Models\City::where('country_id', $data->shop->country->id)->get();
                        $zones = \App\Models\Zone::get();
                        $districts = \App\Admin\District::get();
                        
                        ?>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-sm-3 col-form-label">{{ __('admin/fields.city') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="city_id" id="city_id" required>

                                    <option value="">Select City</option>

                                    @foreach ($cities as $city)
                                        <option value="{{ $city['id'] }}">{{ $city['title_' . App::getLocale()] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-sm-3 col-form-label">{{ __('admin/fields.zone') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="zone_id" id="zone_id" required>
                                    @if ($data->zone)
                                        <option value="{{ $data->zone['id'] }}">
                                            {{ $data->zone['title_' . App::getLocale()] }}</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-sm-3 col-form-label">{{ __('admin/fields.district') }}</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="district_id" id="district_id" required>
                                    @if ($data->district)
                                        <option value="{{ $data->district['id'] }}">
                                            {{ $data->district['title_' . App::getLocale()] }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-sm-3 col-form-label">{{ __('admin/fields.address') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" type="text" id="example-text-input" required name="customer_address">
@if ($action == 'update')
{{ $data->address }}
@endif
</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input"
                                class="col-sm-3 col-form-label">{{ __('Delivery Date') }}</label>
                            <div class="col-sm-9">

                                <input class="form-control"
                                    value="{{ date('YYYY-MM-DD', strtotime($data['delivery_date'])) }}" type="date"
                                    id="example-text-input" required name="delivery_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label">{{ __('Notes') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" type="text" id="example-text-input" name="notes">
@if ($action == 'update')
{{ $data->notes }}
@endif
</textarea>
                            </div>
                        </div>

                        <input type="hidden" name="change" value="1">

                        <input type="hidden" name="state" value="4">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <center>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </center>

                            </div>

                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalCenterNotConfirmed" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cancelled Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form method="post"
                        action="{{ route('supporter.' . $pages . '.' . $action, ['order' => $data->id]) }}"
                        id="myForm">
                        @method('PUT')
                        @csrf

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label">{{ __('Notes') }}</label>
                            <div class="col-sm-9">
                                <input type="hidden" name="cancelled_order" value="1">
                                <textarea class="form-control" type="text" id="example-text-input" required name="notes">
@if ($action == 'update')
{{ $data->notes }}
@endif
</textarea>
                            </div>
                        </div>
                        <input type="hidden" name="change" value="1">

                        <input type="hidden" name="state" value="6">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <center>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </center>

                            </div>

                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>
    @foreach ($data->product as $pro)
        <div class="modal fade" id="exampleModalCenterProduct{{ $pro->one_product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Product Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('assets/admin/products/' . $pro->one_product->image) }}" alt=""
                            style="height: 500px;width:100%">
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function clone() {
            var original = document.getElementById("product_id");
            original.style.display = 'block';
            var clone = original.cloneNode(true);
            clone.removeAttribute("id");
            document.getElementById("product_id_original").appendChild(clone);
            original.style.display = 'none';

        }

        function removeClone(el) {
            var element = el;
            $(el).parent().remove();
        }


        $(document).ready(function() {
            $('#country_id').on('change', function() {
                var id = $(this).val();
                //alert(id);
                $.ajax({
                    url: '{{ route('site.getCities') }}',
                    method: "get",
                    data: {
                        country_id: id
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        var cities = document.getElementById('city_id');

                        cities.innerHTML = "<option>Select City</option>";

                        data.forEach(city => cities.innerHTML += "<option value=" + city.id +
                            ">" + city['title_en'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
            $('#city_id').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    url: '{{ route('site.getZones') }}',
                    method: "get",
                    data: {
                        city_id: id
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        var zones = document.getElementById('zone_id');
                        zones.innerHTML = "<option>Select Zone</option>";


                        data.forEach(zone => zones.innerHTML += "<option value=" + zone.id +
                            ">" + zone['title_en'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
            $('#zone_id').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    url: '{{ route('site.getDistricts') }}',
                    method: "get",
                    data: {
                        zone_id: id
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        var zones = document.getElementById('district_id');
                        zones.innerHTML = "<option>Select District</option>";

                        data.forEach(zone => zones.innerHTML += "<option value=" + zone.id +
                            ">" + zone['title_en'] + "</option>");
                        //console.log(typeof data);
                        // console.log(data);


                    }
                });

            });
            $('#shop_id').on('change', function() {
                var id = $(this).val();
                //  alert(id);
                $.ajax({
                    url: '{{ route('site.getProducts') }}',
                    method: "get",
                    data: {
                        shop_id: id
                    },
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log(data);
                        var shops = document.getElementsByClassName('product_id_view');
                        if (shops.length != 0) {
                            for (var i = 0; i < shops.length; i++) {
                                shops[i].innerHTML = "";
                                data.forEach(shop => shops[i].innerHTML += "<option value=" +
                                    shop['product_id'] + ">" + shop['product_name'] +
                                    "</option>");
                            }
                        } else {
                            shops.innerHTML = "<option > There is no records yet!</option>";
                        }

                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });

        });
    </script>
@endsection
