@extends("layouts.admin")
@section("pageTitle", $action . " "  . $page)
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.includes.messages')
                    <form class="row text-center">
                        <div class="col-sm-6 h5">
                            <lable>{{__('admin/fields.import_from_excel')}}</lable>
                        </div>
                        <div class="col-sm-2">
                            <input type="file">
                        </div>
                    </form>

                    <hr>

                                <form method="post"
                                      action="{{route($pages . '.' . $action , [$page =>$data->id])}}"
                                      id="myForm">
                                    @method('PUT')

                                    @csrf
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.shop_name')}}</label>
                                        <div class="col-sm-10">
                                            {{$data->shop['title_'.App::getLocale()]}}
                                        </div>
                                    </div>

                                    <input type="hidden" name="shop_category" value="product">

                                    <!--  Product Name                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.product_name')}}</label>
                                        <div class="col-sm-10">
                                            {{$data->product->name}}
                                        </div>
                                    </div>
                                    <!--  Country Sent                                   -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Country Sent')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="country_sent"
                                                   value="{{$data->country_sent}}" >
                                        </div>
                                    </div>
                                    <!--  Company name
                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Company Name')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="company_name" required
                                                   value="{{$data->company_name}}" >
                                        </div>
                                    </div>
                                    <!--  Company Number
                 -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Company Number')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="company_number" required
                                                  value="{{$data->company_number}}" >
                                        </div>
                                    </div>
                                    <!--   Delivery Type                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Delivery Type ')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="delivery_type" required>
                                                <option value="land"> Land</option>
                                                <option value="air">Air</option>
                                                <option value="=sea">Sea</option>

                                            </select>
                                        </div>
                                    </div>
                                    <!--   Number Of Boxes                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__(' Boxes Number')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="boxes_number"
                                                 value="{{$data->boxes_number}}" >
                                        </div>
                                    </div>
                                    <!--   Products Amount                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.product_amount')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="product_amount"
                                                   value="{{$data->product_amount}}" >
                                        </div>
                                    </div>

                                    <!--   Expected Time                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Expected Time')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="date" id="example-text-input"
                                                   name="expected_time"
                                                   value="{{date("Y-m-d", strtotime($data->Expected_time))}}"
                                             >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-12 text-center">

                                                <button type="submit"
                                                        class="btn btn-dark w-25">{{__('admin/general.edit_details')}}</button>

                                        </div>
                                    </div>
                                </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
