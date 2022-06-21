@extends("layouts.admin")
@section("pageTitle", "User Types Page")
@section("content")

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{route('users.store')}}">
                            @csrf
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Type Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Type Status</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="switch8" switch="sucess" checked/>
                                    <label for="switch8" data-on-label="Yes"
                                           data-off-label="No"></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Type Privileges</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <i class=" fas fa-school"></i>
                                            <span>Inventory</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" id="switch9" switch="dark" checked/>
                                            <label for="switch9" data-on-label="Yes"
                                                   data-off-label="No"></label>
                                        </div>
                                        <div class="col-sm-6">
                                            read <input type="checkbox">
                                            write <input type="checkbox">
                                            create <input type="checkbox">
                                            update <input type="checkbox">

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <i class=" fas fa-school"></i>
                                            <span>Inventory</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" id="switch9" switch="dark" checked/>
                                            <label for="switch9" data-on-label="Yes"
                                                   data-off-label="No"></label>
                                        </div>
                                        <div class="col-sm-6">
                                            read <input type="checkbox">
                                            write <input type="checkbox">
                                            create <input type="checkbox">
                                            update <input type="checkbox">

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <i class=" fas fa-school"></i>
                                            <span>Inventory</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" id="switch9" switch="dark" checked/>
                                            <label for="switch9" data-on-label="Yes"
                                                   data-off-label="No"></label>
                                        </div>
                                        <div class="col-sm-6">
                                            read <input type="checkbox">
                                            write <input type="checkbox">
                                            create <input type="checkbox">
                                            update <input type="checkbox">

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <i class=" fas fa-school"></i>
                                            <span>Inventory</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" id="switch9" switch="dark" checked/>
                                            <label for="switch9" data-on-label="Yes"
                                                   data-off-label="No"></label>
                                        </div>
                                        <div class="col-sm-6">
                                            read <input type="checkbox">
                                            write <input type="checkbox">
                                            create <input type="checkbox">
                                            update <input type="checkbox">

                                        </div>


                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <i class=" fas fa-school"></i>
                                            <span>Inventory</span>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="checkbox" id="switch9" switch="dark" checked/>
                                            <label for="switch9" data-on-label="Yes"
                                                   data-off-label="No"></label>
                                        </div>
                                        <div class="col-sm-6">
                                            read <input type="checkbox">
                                            write <input type="checkbox">
                                            create <input type="checkbox">
                                            update <input type="checkbox">

                                        </div>


                                    </div>

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
