@extends("layouts.admin")
@section("pageTitle", "Add District")
@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">



                    <form method="post" action="{{route('districts.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name English</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_en" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name Arabic</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_ar" required>
                            </div>
                        </div>
                        @if(Auth::guard('admin')->user()->is_super_admin)
                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-sm-2 col-form-label">{{__('admin/fields.country')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="country_id" required
                                        id="country_id">

                                    <option value="0">
                                        Select Country
                                    </option>
                                    @foreach($countries as $shop)
                                        <option
                                            value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input"
                                   class="col-sm-2 col-form-label">{{__('admin/fields.city')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="city_id"  required id="city_id">
                                    <option value="0">Select City First</option>
                                </select>
                            </div>
                        </div>
                        @else
                            <div class="form-group row">
                                <label for="example-text-input"
                                       class="col-sm-2 col-form-label">{{__('admin/fields.city')}}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="city_id"  required id="city_id">
                                        @foreach($cities  as $city)
                                        <option value="{{$city->id}}">{{$city['title_' . App::getLocale()]}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Zone</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="zone_id" required id="zone_id" >
                                    @foreach($records as $rec)
                                        <option value="{{$rec->id}}">{{$rec['title_'. App::getlocale() ]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous">
</script>
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
                    cities.innerHTML = "<option value='0'>Select City</option>";
                    data.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['title_en'] + "</option>");
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
                    zones.innerHTML = "<option value='0'>Select Zone</option>";
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
                    districts.innerHTML = "<option value='0'>Select District</option>";
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
                    console.log(data);
                    var shops = document.getElementsByClassName('product_id_view');

                    for(var i=0;i<shops.length;i++){
                        shops[i].innerHTML = "";
                        data.forEach(shop => shops[i].innerHTML += "<option value=" + shop.id + ">" + shop['product_name'] + "</option>");
                    }

                    //console.log(typeof data);

                    // console.log(data);
                }
            });

        });

    });

</script>
