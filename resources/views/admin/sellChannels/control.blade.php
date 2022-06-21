@extends("layouts.admin")
@section("pageTitle", $action . " "  . $page)
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="row text-center">
                        <div class="col-sm-6 h5">
                            <lable>{{__('admin/fields.import_from_excel')}}</lable>
                        </div>
                        <div class="col-sm-2">
                            <input type="file">
                        </div>
                    </form>

                    <hr>
                    @if($action == 'store')
                        <form method="post" action="{{route($pages .'.'.$action)}}" id="myForm">
                            @else
                                <form method="post"
                                      action="{{route($pages . '.' . $action , [$page =>$data->id])}}"
                                      id="myForm">
                                    @method('PUT')
                                    @endif
                                    @csrf
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.shop_type')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="sales_channel_type_id" required>
                                                @if($action == 'update')
                                                    <option selected value="{{$data->shopType['id']}}">{{$data->shopType['title_' . App::getlocale() ]}}</option>
                                                    @foreach($shopTypes as $shopType)
                                                        @if($shopType->id != $data['shopType']['id'])
                                                            <option value="{{$shopType['id']}}">{{$shopType['title_' . App::getlocale() ]}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach($shopTypes as $shopType)
                                                        <option value="{{$shopType['id']}}">{{$shopType['title_' . App::getlocale() ]}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.title_ar')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="title_ar" required
                                                   @if($action == 'update') value="{{$data->title_ar}}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.title_en')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="title_en" required
                                                   @if($action == 'update') value="{{$data->title_en}}" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.shop_url')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="shop_url" required
                                                   @if($action == 'update') value="{{$data->shop_url}}" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.owner_email')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="owner_email" required>
                                                @if($action == 'update')
                                                    <option value="{{$seller['id']}}">{{$seller['email']}}</option>
                                                    @foreach($sellers as $seller)
                                                        @if($seller['email'] != $data['owner_email'])
                                                        <option value="{{$seller['id']}}">{{$seller['email']}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach($sellers as $seller)
                                                        <option value="{{$seller['id']}}">{{$seller['email']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.countries')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="country_id" required>
                                                @if($action == 'update')
                                                    <option selected value="{{$data->country['id']}}">{{$data->country['title_' . App::getlocale() ]}}</option>
                                                    @foreach($countries as $country)
                                                        @if($country->id != $data['country']['id'])
                                                            <option value="{{$country['id']}}">{{$country['title_' . App::getlocale() ]}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach($countries as $country)
                                                        <option value="{{$country['id']}}">{{$country['title_' . App::getlocale() ]}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

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
