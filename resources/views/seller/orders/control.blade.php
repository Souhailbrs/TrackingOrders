@extends("layouts.seller")
@section("pageTitle", $action . " "  . $page)
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.includes.messages')
                    <form class="row text-center" action="{{route('seller.import.orders')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-3 h5">
                            <lable>{{__('admin/fields.import_from_excel')}}</lable>
                        </div>
                        <div class="col-sm-6">


                            <select class="btn btn-dark col-sm-4" name="sales_channel_id" required  style="display: inline-block">
                                @foreach($shops as $shop)
                                    <option
                                        value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                @endforeach

                            </select>


                            <input type="file" name="image" required>
                        </div>

                        <div class="col-sm-3">

                        <input class="btn btn-dark mr-2" type="submit" value="Import" >
                        <a type="submit"  download href="{{asset('assets/admin/orders/temp.xlsx')}}">Download Template</a>

                        </div>
                    </form>

                    <hr>
                    @if($action == 'store')
                        <form method="post" action="{{route('seller.'.$pages .'.'.$action)}}" id="myForm">
                            @else
                                <form method="post"
                                      action="{{route('seller.'.$pages . '.' . $action , [$page =>$data->id])}}"
                                      id="myForm">
                                    @method('PUT')
                                    @endif
                                    @csrf
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.shop_name')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="sales_channel_id" required id="shop_id">
                                                <option value="">Select shop</option>
                                                    @foreach($shops as $shop)
                                                        <option
                                                            value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                                    @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">


                                        <div class="col-sm-12">
                                            <center>
                                                <input class="form-control btn-dark" type="button"
                                                       id="example-text-input-mokaaa"
                                                       value="Add More" onClick="clone()">
                                            </center>
                                        </div>

                                    </div>

                                    <div id="product_id_original">
                                        <div class="row">

                                        </div>
                                        <br>
                                    </div>
                                    <div id="product_id" style="display:none;">
                                        <div class="row mt-2">
                                            <div class="col-sm-3">
                                                <select class="form-control products_id product_id_view" name="products_id[]" >
                                                    <!--                                    Products               -->
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <input class="form-control" type="text" id="example-text-input"
                                                       name="products_price[]" placeholder="Price" >
                                            </div>
                                            <div class="col-sm-3">
                                                <input class="form-control" type="text" id="example-text-input"
                                                       name="products_amount[]" placeholder="Amount" >
                                            </div>
                                            <div id="i" type="button" class="col-sm-3 btn btn-danger"
                                                 onclick="removeClone(this)">remove
                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <!--     Customer Details                               -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Customer Name')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input" required
                                                   name="customer_name"
                                                   @if($action == 'update') value="{{$data->customer_name}}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Customer Phone1')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input" required
                                                   name="customer_phone1"
                                                   @if($action == 'update') value="{{$data->customer_phone1}}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Seller Notes')}}</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" type="text" id="example-text-input"
                                                      name="customer_notes">@if($action == 'update'){{$data->customer_notes}}@endif</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Product Url')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input" required
                                                   name="url">
                                        </div>

                                    </div>

                                    <!--                           Address         -->


                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.city')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="city_id"  required id="city_id">

                                            </select>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.address')}}</label>
                                        <div class="col-sm-10">
                                                <textarea class="form-control" type="text" id="example-text-input"
                                                          name="customer_address">@if($action == 'update'){{$data->customer_notes}}@endif</textarea>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <div class="col-12 text-center">
                                            @if($action == 'store')
                                                <button type="submit"
                                                        class="btn btn-dark w-25">{{__('admin/general.add_new')}}</button>
                                            @else
                                                <button type="submit"
                                                        class="btn btn-dark w-25">{{__('admin/general.edit_details')}}</button>
                                            @endif
                                        </div>
                                    </div>


                        </form>
                        </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <script
        src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
        crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(".example-text-input-mokaaa").click(function(e) {
            e.stopPropagation(); // This is the preferred method.
            return false;        // This should not be used unless you do not want
                                 // any click events registering inside the div
        });
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


        $(document).ready(function () {
            $('#country_id').on('change', function () {
                var id = $(this).val();
                //alert(id);
                $.ajax({
                    url: '{{route('site.getCities')}}',
                    method: "get",
                    data: {country_id: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        var cities = document.getElementById('city_id');
                        cities.innerHTML = "";
                        data.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['title_ar'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
            $('#city_id').on('change', function () {
                var id = $(this).val();
                $.ajax({
                    url: '{{route('site.getZones')}}',
                    method: "get",
                    data: {city_id: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        var zones = document.getElementById('zone_id');
                        zones.innerHTML = "<option>Select Zone</option>";
                        data.forEach(zone => zones.innerHTML += "<option value=" + zone.id + ">" + zone['title_en'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });
            $('#zone_id').on('change', function () {
                var id = $(this).val();
                $.ajax({
                    url: '{{route('site.getDistricts')}}',
                    method: "get",
                    data: {zone_id: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        console.log(data);
                        var districts = document.getElementById('district_id');
                        districts.innerHTML = "<option>Select District</option>";
                        data.forEach(district => districts.innerHTML += "<option value=" + district.id + ">" + district['title_en'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });

            $('#shop_id').on('change', function () {
                var id = $(this).val();
                //  alert(id);
                $.ajax({
                    url: '{{route('site.getProducts')}}',
                    method: "get",
                    data: {shop_id: id},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        //console.log(data);
                        var shops = document.getElementsByClassName('product_id_view');

                        for(var i=0;i<shops.length;i++){
                            shops[i].innerHTML = "";
                            data.forEach(shop => shops[i].innerHTML += "<option value=" + shop['product_id'] + ">" + shop['product_name']+ "</option>");
                        }

                        //console.log(typeof data);

                        // console.log(data);
                    }
                });
                $.ajax({
                        url: '{{route('site.getCities.withShopId')}}',
                        method: "get",
                        data: {shop_id: id},
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            console.log(data);
                            var cities = document.getElementById('city_id');
                            cities.innerHTML = "<option>Select City</option>";
                            data.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['title_en'] + "</option>");
                            //console.log(typeof data);

                            // console.log(data);
                        }
                    });

            });
        });

    </script>
@endsection
