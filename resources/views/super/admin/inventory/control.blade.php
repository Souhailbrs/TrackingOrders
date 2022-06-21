@extends("layouts.admin")
@section("pageTitle", $action . " "  . $page)
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.includes.messages')
                   {{-- <form class="row text-center">
                        <div class="col-sm-6 h5">
                            <lable>{{__('admin/fields.import_from_excel')}}</lable>
                        </div>
                        <div class="col-sm-2">
                            <input type="file">
                        </div>
                    </form>

                    <hr>--}}
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
                                               class="col-sm-2 col-form-label">{{__('admin/fields.shop_name')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="sales_channel_id" required>
                                                @if($action == 'update')
                                                    <option selected value="{{$data->shop['id']}}">{{$data->shop['title_' . App::getlocale() ]}}</option>
                                                    @foreach($shops as $shop)
                                                        @if($shop->id != $data['shop']['id'])
                                                            <option value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach($shops as $shop)
                                                        <option value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.category')}}</label>
                                        <div class="col-sm-10">
                                            <select name="category" class="form-control" type="text" id="example-text-input" required>
                                                @if($action == 'update')
                                                @else
                                                <option value="product">{{__('admin/fields.product')}}</option>
                                                <option value="service">{{__('admin/fields.service')}}</option>
                                                @endif
                                            </select>
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
                                            <input class="form-control" type="email" id="example-text-input"
                                                   name="owner_email" required
                                                   @if($action == 'update') value="{{$data->owner_email}}" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.owner_password')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="owner_password" required
                                                   @if($action == 'update') value="{{$data->owner_password}}" @endif>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.owner_phone')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="owner_phone" required
                                                   @if($action == 'update') value="{{$data->owner_phone}}" @endif>
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
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.cities')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="city_id" required>
                                                @if($action == 'update')
                                                    <option selected value="{{$data->city['id']}}">{{$data->city['title_' . App::getlocale() ]}}</option>
                                                    @foreach($cities as $city)
                                                        @if($city->id != $data['city']['id'])
                                                            <option value="{{$city['id']}}">{{$city['title_' . App::getlocale() ]}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach($cities as $city)
                                                        <option value="{{$city['id']}}">{{$city['title_' . App::getlocale() ]}}</option>
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
