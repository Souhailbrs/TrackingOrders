@extends("layouts.seller")
@section("pageTitle", $action . " "  . $page)
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('admin.includes.messages')
               {{--     <form class="row text-center">
                        <div class="col-sm-6 h5">
                            <lable>{{__('admin/fields.import_from_excel')}}</lable>
                        </div>
                        <div class="col-sm-2">
                            <input type="file">
                        </div>
                    </form>

                    <hr>--}}
                    @if($action == 'store')
                        <form method="post" action="{{route('seller.'.$pages .'.'.$action)}}" id="myForm">
                            @else
                                <form method="post"
                                      action="{{route('seller.'.$pages . '.' . $action , [$page =>$data->id])}}"
                                      id="myForm">
                                    @method('PUT')
                                    @endif
                                    @csrf
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.shop_name')}}</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="sales_channel_id" required id="shop_id">
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
                                                    <option value="">Select Shop</option>
                                                    @foreach($shops as $shop)
                                                        <option
                                                            value="{{$shop['id']}}">{{$shop['title_' . App::getlocale() ]}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <input type="hidden" name="shop_category" value="product">

                                    <!--  Product Name                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.product_name')}}</label>
                                        <div class="col-sm-10">
                                            <select name="product_name" class="form-control product_id_view" >
                                                <option value="">Select Shop First</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--  Country Sent                                   -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Country Sent')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="country_sent" required
                                                   @if($action == 'update') value="{{$data->country_sent}}" @endif>
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
                                                   @if($action == 'update') value="{{$data->company_name}}" @endif>
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
                                                   @if($action == 'update') value="{{$data->company_number}}" @endif>
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
                                                   @if($action == 'update') value="{{$data->boxes_number}}" @endif>
                                        </div>
                                    </div>
                                    <!--   Products Amount                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('admin/fields.product_amount')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" id="example-text-input"
                                                   name="product_amount"
                                                   @if($action == 'update') value="{{$data->product_amount}}" @endif>
                                        </div>
                                    </div>

                                    <!--   Expected Time                                  -->
                                    <div class="form-group row">
                                        <label for="example-text-input"
                                               class="col-sm-2 col-form-label">{{__('Expected Time')}}</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="date" id="example-text-input"
                                                   name="expected_time" required
                                                   @if($action == 'update') value="{{$data->expected_time}}" @endif>
                                        </div>
                                    </div>

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
<script
    src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
    crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>


    $(document).ready(function () {
        $('#shop_id').on('change', function () {
            var id = $(this).val();
            //  alert(id);
            $.ajax({
                url: '{{route('site.getProducts')}}',
                method: "get",
                data: {shop_id: id},
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    console.log(data);
                    var shops = document.getElementsByClassName('product_id_view');
                    for(var i=0;i<shops.length;i++){
                        shops[i].innerHTML = "";
                        data.forEach(shop => shops[i].innerHTML += "<option value=" + shop.product_id + ">" + shop['product_name'] + "</option>");
                    }

                    //console.log(typeof data);

                    // console.log(data);
                }
            });

        });

    });

</script>
