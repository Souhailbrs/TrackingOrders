@extends("layouts.admin")
@section("pageTitle", "User Types Page")
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

                <form method="post" action="{{route('admin.category.update',['category'=>$category->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('admin/category.Name')}}</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="example-text-input" name="name" value="{{$category->name}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('admin/category.Price')}}</label>
                        <div class="col-sm-10">

                            <input class="form-control" type="number" step="any"  id="example-text-input" name="price" value="{{$category->price}}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('admin/category.Image')}}</label>
                        <div class="custom-file col-sm-10">
                            <input name="image" type="file" class="custom-file-input" id="customFileLangHTML">
                            <label class="custom-file-label" for="customFileLangHTML" data-browse="{{__('admin/category.UplodeImage')}}"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-dark w-25">{{__('admin/category.Update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@endsection
@section("script")
<script src="{{asset("assets/admin/js/app.js")}}"></script>

@endsection
