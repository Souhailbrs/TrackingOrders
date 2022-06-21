@extends("layouts.admin")
@section("pageTitle", "Home Page")
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

                    <form method="post" action="{{route('control.pages.update')}}" enctype="multipart/form-data">
                        @csrf
                        @foreach($values as $val)


                                <div class="form-group row">
                                    <div class="custom-file col-sm-10">
                                        <div class="custom-control custom-switch">
                                            @if($val->value == 1)
                                            <input type="checkbox" class="custom-control-input" id="customSwitches{{$val->id}}" checked name="pages{{$val->id}}" >
                                            @else
                                                <input type="checkbox" class="custom-control-input" id="customSwitches{{$val->id}}" name="pages{{$val->id}}" >
                                            @endif
                                            <label class="custom-control-label" for="customSwitches{{$val->id}}">{{$val->section}}</label>
                                        </div>
                                    </div>

                                </div>
                        @endforeach
                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
