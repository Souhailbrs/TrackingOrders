@extends("layouts.admin")
@section("pageTitle", "Add Products To Store")
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
                                <form class="row text-center">
                                    <div class="col-sm-6 h5">
                                        <lable>Import from excel</lable>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="file">

                                    </div>
                                </form>

                            <hr>
                        <form method="post" action="{{route('users.store')}}" id="myForm">
                            @csrf
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Shop Name</label>
                                <div class="col-sm-10">
                                    <select class="form-control" type="text" id="select_shop_type" name="name" required onchange="select_shop_type()">
                                        <option value="n">Shop1</option>
                                        <option value="e">Shop2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <select class="form-control" type="text" id="select_shop_type" name="name" required onchange="select_shop_type()">
                                        <option value="n">Cat1</option>
                                        <option value="e">Cat2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Product Price</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Product Amount</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Product Status</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" id="example-text-input" name="name" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-dark w-25">Add New Product</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        <script type="javascript">

        function select_shop_type(){
             var select_shop_type=  document.getElementById("select_shop_type").value;
             if(select_shop_type == 'n' ){
                document.getElementById("myForm").style.display = 'none';
             }else{
                document.getElementById("myForm").style.display = 'block';
             }
         }
        </script>
@endsection
