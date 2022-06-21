@extends("layouts.admin")
@section("pageTitle", "User Types Privilege")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive " >
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

                        <div class="container-fluid">



                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Type ID</th>
                                                    <th>Privilege Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                <tr>
                                                    <td>
                                                        <a href="#" class="font-weight-bold text-muted">#32147851</a>
                                                    </td>
                                                    <td>Manage Users</td>

                                                    <td><span class="badge badge-success">Active</span></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="font-weight-bold text-muted">#32147851</a>
                                                    </td>
                                                    <td>Manage Users</td>

                                                    <td><span class="badge badge-success">Active</span></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div> <!-- container-fluid -->

{{--
                    {{ $data->links() }}
--}}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>
<script>
    function modelDes(x,y){
        document.getElementById('modelImagee').innerHTML =`
            <div class="modal " id="image`+x+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">  {{__('admin/category.Image')}}  </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="group-img-container text-center post-modal">
                                <img  src="{{asset('assets/images/users/`+ y +`')}}" alt="" class="group-img img-fluid" style="width:400px; hieght:400px" ><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                        </div>
                    </div>
                </div>
            </div>
        `
    }

    function modelAddProduct(x){
        document.getElementById('modelAdd').innerHTML =`
            <div class="modal " id="form`+x+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> {{__('admin/category.Image')}} </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('usersTypes.store')}}" >
                            @csrf
                            <input type="hidden" name="category_id" value="`+x+`">
                            <input type="hidden" name="state" value="available">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">{{__('admin/category.Code')}}:</label>
                                    <textarea class="form-control" name="code" id="message-text"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('admin/category.Save')}}</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin/category.Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        `
    }
</script>
@endsection

