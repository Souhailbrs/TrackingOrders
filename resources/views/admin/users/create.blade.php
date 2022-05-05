@extends("layouts.admin")
@section("pageTitle", "User  Page")
@section("content")

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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

                        <form method="post" action="{{route('users.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">User Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="userType" required onchange="ShowZoneField()" id="dropDownData">
                                        <option value="admin">Admin</option>
                                        <option value="seller">Seller</option>
                                        <option value="delivery">Delivery</option>
                                        <option value="supporter">Supporter</option>
                                        <option value="packaging">Packaging</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="phone" required>
                                </div>
                            </div>
                            <div id="showDropDown" style="display:none">
                                <div class="form-group row" >
                                    <label for="example-text-input"
                                           class="col-sm-2 col-form-label">{{__('admin/fields.country')}}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="country_id" id="country_id" >
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country['id']}}">{{$country['title_'. App::getLocale()]}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-sm-2 col-form-label">{{__('admin/fields.city')}}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="city_id" id="city_id" >
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input"
                                           class="col-sm-2 col-form-label">{{__('admin/fields.zone')}}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="zone_id" id="zone_id" >

                                        </select>
                                    </div>
                                </div>
                            </div>
<!--
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="custom-file col-sm-10">
                                    <input name="image" type="file" class="custom-file-input" id="customFileLangHTML" required>
                                    <label class="custom-file-label" for="customFileLangHTML" data-browse="Upload File"></label>
                                </div>
                            </div>-->

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

        <script
            src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
            crossorigin="anonymous">
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            function ShowZoneField(){
                var zone_id =document.getElementById('zone_id');
               var dropDownData =  document.getElementById('dropDownData').value;
                var elements = document.getElementById('showDropDown');
                if(dropDownData === 'delivery') {
                   elements.style.display = 'block';
                    zone_id.required = true;

                }else{
                   elements.style.display = 'none';
                    zone_id.required = false;
               }
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
                            cities.innerHTML = "<option>Select City</option>";
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
                            zones.innerHTML = "<option>Select Zone</option>";

                            data.forEach(zone => zones.innerHTML += "<option value=" + zone.id + ">" + zone['title_en'] + "</option>");
                            //console.log(typeof data);

                            // console.log(data);
                        }
                    });

                })

            });
        </script>


@endsection
