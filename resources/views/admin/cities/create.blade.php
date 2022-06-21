@extends("layouts.admin")
@section("pageTitle", "Add City")
@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="{{route('cities.store')}}" enctype="multipart/form-data">
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
                            <label for="example-text-input" class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-10">
                                <select class="form-control"  id="example-text-input" name="country_id" required>
                                    @foreach($records as $rec)
                                        <option value="{{$rec->id}}">{{$rec['title_'. App::getlocale() ]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="country_id" value="{{Auth::guard('admin')->user()->country_id}}">
                        @endif


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
