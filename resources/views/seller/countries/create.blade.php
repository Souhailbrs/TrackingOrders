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

                        <form method="post" action="{{route('countries.store')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name Arabic</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="title_ar" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name English</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="title_en" required>
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
