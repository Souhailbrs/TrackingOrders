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
                                    <select class="form-control" name="userType" required>
                                        <option value="admin">Admin</option>
                                        <option value="seller">Seller</option>
                                        <option value="delivery">Delivery</option>
                                        <option value="supporter">Supporter</option>
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
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="custom-file col-sm-10">
                                    <input name="image" type="file" class="custom-file-input" id="customFileLangHTML" required>
                                    <label class="custom-file-label" for="customFileLangHTML" data-browse="Uplpoad File"></label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-dark w-25">اضافة</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->


@endsection
