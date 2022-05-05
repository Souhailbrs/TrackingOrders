@extends("layouts.admin")
@section("pageTitle", "Users Page")
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
                                    <center>
                                        <h3>{{$type}}</h3>
                                    </center>
                                    <div class="card">

                                        <div class="card-body row text-center">

                                            <a class=" col-sm-3 p-3" href="{{route('users.get.type',['type'=>'admins'])}}">
                                                <div class="col-sm-10 btn btn-dark">
                                                    Admins
                                                </div>

                                            </a>
                                            <a class=" col-sm-3 p-3" href="{{route('users.get.type',['type'=>'sellers'])}}">
                                                <div class="col-sm-10 btn btn-dark">
                                                     Sellers
                                                </div>
                                            </a>
                                            <a class=" col-sm-3 p-3" href="{{route('users.get.type',['type'=>'deliveries'])}}">
                                                <div class="col-sm-10 btn btn-dark">
                                                    Deliveries
                                                </div>
                                            </a>
                                            <a class="col-sm-3 p-3" href="{{route('users.get.type',['type'=>'supporters'])}}">
                                                <div class="col-sm-10 btn btn-dark">
                                                       Supporters
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Name </th>
                                                    <th>Email </th>
                                                    <th>Number</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($records as $record)
                                                  <tr>
                                                      <td>
                                                          <img src="" alt="" style="width:80%;height:70px">
                                                      </td>
                                                    <td>
                                                        <a href="#" class="font-weight-bold text-muted">#{{$record->id}}</a>
                                                    </td>
                                                    <td>{{$type}}</td>

                                                    <td>{{$record->name}}</td>
                                                      <td>{{$record->email}}</td>
                                                      <td>{{$record->phone}}</td>
                                                    @if($record->status == 1)
                                                    <td><span class="badge badge-success">Active</span></td>
                                                      @else
                                                          <td><span class="badge badge-danger">Deactivate</span></td>

                                                      @endif
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach

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

