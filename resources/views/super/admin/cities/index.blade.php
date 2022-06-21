@extends("layouts.admin")
@section("pageTitle", "Cities")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive " >
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif


                    <div class="container-fluid">



                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example2" class="table table-striped table-bordered pt-3">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name Arabic</th>
                                                <th>Name English</th>
                                                <th>Country</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($records as $record)
                                                <tr>
                                                    <td>#{{$record->id}}</td>
                                                    <td>{{$record->title_ar}}</td>
                                                    <td>{{$record->title_en}}</td>

                                                    <td>
                                                        {{$record->country['title_'. App::getLocale()]}}
                                                    </td>
                                                    <td>
                                                        <a href="{{route('cities.edit',['city'=>$record->id])}}" class="mr-3 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>

                                                        <form action="{{route('cities.destroy',['city'=>$record->id])}}" method="post" style="display:inline-block">
                                                            @method('DELETE')
                                                            @csrf
                                                            <span type="submit" class="mr-3 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Delete" onclick="$(this).closest('form').submit();"> <i class="mdi mdi-close font-size-18"></i> </span>

                                                        </form>
                                                     </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                        </div>
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
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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

