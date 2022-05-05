@extends("layouts.seller")
@section("pageTitle", $action . " "  . $page)
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.includes.messages')
              {{--      <form class="row text-center">
                        <div class="col-sm-6 h5">
                            <lable>{{__('admin/fields.import_from_excel')}}</lable>
                        </div>
                        <div class="col-sm-2">
                            <input type="file">
                        </div>
                    </form>

                    <hr>--}}
                    @if($action == 'store')
                        <form method="post" action="{{route('seller.'.$pages .'.'.$action)}}" id="myForm" enctype="multipart/form-data">
                            @else
                                <form method="post" enctype="multipart/form-data"
                                      action="{{route('seller.'.$pages . '.' . $action , [$page =>$data->id])}}"
                                      id="myForm">
                                    @method('PUT')
                                    @endif
                                    @csrf

                                    <!--  Product Name                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.product_name')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="product_name" required
                                                   @if($action == 'update') value="{{$data->name}}" @endif>
                                        </div>
                                    </div>

                                        <div class="form-group row">
                                            <label for="example-text-input"
                                                   class="col-sm-2 col-form-label">{{__('admin/fields.shop_name')}}</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="sales_channel_id" required>
                                                    @if($action == 'update')
                                                        <option selected
                                                                value="{{$data->shop['id']}}">{{$data->shop['title_' . App::getlocale() ]}}</option>
                                                        @foreach($shops as $shop)
                                                            @if($shop->id != $data['shop']['id'])
                                                                <option
                                                                    value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($shops as $shop)
                                                            <option
                                                                value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Upload Image')}}</label>
                                            <div class="custom-file col-sm-10">
                                                <input name="image" type="file" class="custom-file-input" id="customFileLangHTML1" @if($action == 'store') required @endif   onchange="updateList()">
                                                <label class="custom-file-label" for="customFileLangHTML" data-browse="{{__('Upload Image')}}"></label>
                                                <input id="fileList" disabled style="background:white;border: 0px" >

                                            </div>
                                        </div>

                                    @if($action == 'update')
                                            <br>
                                            <img src="{{asset('assets/admin/products/'. $data->image)}}"  style="height:350px;width:350px">
                                            <hr>
                                        @endif




                                    @if($action == 'update')
                                            <div class="form-group row">
                                                <label for="example-text-input"
                                                       class="col-sm-2 col-form-label">{{__('admin/fields.status')}}</label>
                                                <div class="col-sm-10">
                                                    @if($data['status'] == 1)
                                                        <div class="col-sm-10">
                                                            <input type="checkbox" id="switch8" switch="dark" checked name="status" />
                                                            <label for="switch8" data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </div>
                                                    @else
                                                        <div class="col-sm-10">
                                                            <input type="checkbox" id="switch8" switch="dark"  name="status" />
                                                            <label for="switch8" data-on-label="Yes"
                                                                   data-off-label="No"></label>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <br>
                                    <div class="form-group row">
                                        <div class="col-12 text-center">
                                            @if($action == 'store')
                                                <button type="submit"
                                                        class="btn btn-dark w-25">{{__('admin/general.add_new')}}</button>
                                            @else
                                                <button type="submit"
                                                        class="btn btn-dark w-25">{{__('admin/general.edit_details')}}</button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
<script>
      function updateList() {
        var input = document.getElementById('customFileLangHTML1');
          var output = document.getElementById('fileList');
        output.value ='Select file is : ' + input.files.item(0).name;
    }
</script>
