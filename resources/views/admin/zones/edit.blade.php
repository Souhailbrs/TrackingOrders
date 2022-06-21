@extends("layouts.admin")
@section("pageTitle", "Edit Zone")
@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="{{route('zones.update',['zone'=>$record->id])}}" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Title English')}}</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_en" value="{{$record->title_en}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Title Arabic')}}</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_ar" value="{{$record->title_ar}}">
                            </div>
                        </div>
                        @if(Auth::guard('admin')->user()->is_super_admin)
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-10">

                                <select class="form-control"  name="country_id" id="country_id" required>
                                    <option value="{{$record->city->country->id}}">{{$record->city->country['title_' . App::getLocale()]}}</option>
                                    @foreach($countries as $rec)
                                        @if($rec->id != $record->city->country->id)
                                            <option value="{{$rec->id}}">{{$rec['title_'. App::getlocale() ]}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-10">
                                <select class="form-control"   name="city_id"  id="city_id" required>
                                    @foreach($cities as $rec)
                                        <option value="{{$rec->id}}">{{$rec['title_'. App::getlocale() ]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">{{__('Save Changes')}}</button>
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
                    cities.innerHTML = "<option>Select City</option>";
                    data.forEach(city => cities.innerHTML += "<option value=" + city.id + ">" + city['title_ar'] + "</option>");
                    //console.log(typeof data);

                    // console.log(data);
                }
            });

        });


    });

</script>
