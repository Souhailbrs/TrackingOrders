@extends("layouts.packaging")
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

                    <form method="post" action="{{route('packaging.boxes.store')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-10">
                                <select class="form-control" type="text"  name="city_id" id="city_id" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">
                                            {{$city['title_'.App::getLocale()]}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Zone</label>
                            <div class="col-sm-10">
                                <select class="form-control" type="text" name="zone_id" id="zone_id" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">District</label>
                            <div class="col-sm-10">
                                <select class="form-control" type="text" name="district_id" id="district_id" required>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                                <input type="submit" value="Submit" class="btn btn-dark">

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



        $(document).ready(function () {
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
                        zones.innerHTML = "";
                        data.forEach(zone => zones.innerHTML += "<option>Select Zone</option><option value=" + zone.id + ">" + zone['title_ar'] + "</option>");
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
                        // alert(1);
                        var districts = document.getElementById('district_id');
                        districts.innerHTML = "";
                        data.forEach(district => districts.innerHTML += "<option>Select district</option><option value=" + district.id + ">" + district['title_ar'] + "</option>");
                        //console.log(typeof data);

                        // console.log(data);
                    }
                });

            });

        });

    </script>

@endsection
