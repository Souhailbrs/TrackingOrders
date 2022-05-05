@extends("layouts.admin")
@section("pageTitle", "User Types Privilege")
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

                        <form method="post" action="{{route('users.store')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Type Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Read</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="switch8" switch="sucess" checked/>
                                    <label for="switch8" data-on-label="Yes"
                                           data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Create</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="switch8" switch="sucess" checked/>
                                    <label for="switch8" data-on-label="Yes"
                                           data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Update</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="switch8" switch="sucess" checked/>
                                    <label for="switch8" data-on-label="Yes"
                                           data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Show</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="switch8" switch="sucess" checked/>
                                    <label for="switch8" data-on-label="Yes"
                                           data-off-label="No"></label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-dark w-25">Add New Privilege</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


@endsection
