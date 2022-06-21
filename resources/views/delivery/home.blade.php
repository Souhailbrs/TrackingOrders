@extends("layouts.delivery")
@if(LaravelLocalization::getCurrentLocale() == 'ar')
    @section("pageTitle", "الرئيسية")
@else
    @section("pageTitle", "Home")
@endif
@section('styleChart')
    <link href="{{asset("assets/admin/libs/c3/c3.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
@endsection
@section("content")
    <div class="container">


    {{-- {{ Money::USD(500)}} --}}
    <div class="row">
        <div class="col-12">
            <div class="card" style="min-height:800px">
                <div class="card-body table-responsive ">
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

                    <div class="row">
                        <div class="col-sm-12 text-center h2" >
                            {{__('orders.'.$filter)}}
                            <hr>
                        </div>
                        @if(count($orders) > 0)
                        @foreach($orders as $record)

                        <div class="col-md-4 col-sm-12 card text-center" style="padding:20px">
                            @if( $record->status == 0)
                                <span class="btn btn-warning" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.new_order')}}</span>
                            @elseif( $record->status == 1)
                                <span class="btn btn-info" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.call_center_received')}}</span>
                            @elseif( $record->status == 2 )
                                <span class="btn btn-danger" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.no_answer_call_center')}}</span>
                            @elseif ($record->status == 3)
                                <span class="btn btn-danger" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.wrong_answer')}}</span>
                            @elseif($record->status == 4)
                                <span class="btn btn-success" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.confirm_order')}}</span>
                            @elseif( $record->status == 5)
                                <span class="btn btn-secondary" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.not_confirm_order')}}</span>
                            @elseif($record->status == 6)
                                <span class="btn btn-danger" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.canceled_order')}}</span>
                            @elseif($record->status == 7)
                                <span class="btn btn-success" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.ready_to_be_delivered')}}</span>
                            @elseif($record->status == 8)
                                <span class="btn btn-success" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.received_by_delivery')}}</span>
                            @elseif($record->status == 9)
                                <span class="btn btn-danger" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.delivery_refused_order')}}</span>
                            @elseif($record->status == 10)
                                <span class="btn btn-primary" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.customer_received')}}</span>
                            @elseif($record->status == 11)
                                <span class="btn btn-danger" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.canceled_order')}}</span>
                            @elseif($record->status == 12)
                                <span class="btn btn-danger">{{__('orders.order')}} # {{$record->id}}  {{__('orders.no_answer_delivery_boy')}}</span>
                            @elseif($record->status == 13)
                                <span class="btn btn-danger" >{{__('orders.order')}} # {{$record->id}}  {{__('orders.customer_didnot_deliver')}}</span>
                            @endif



                            <div class="card-body text-center">

                                    <h3 class="text-center">
                                        Mr , {{$record->customer_name}}
                                    </h3>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>
                                                {{__('orders.product')}}
                                            </th>
                                            <th>
                                                {{__('orders.price')}}

                                            </th>
                                            <th>
                                                {{__('orders.quantity')}}
                                            </th>
                                        </tr>
                                        <?php $total = 0; ?>
                                        @foreach($record->product as $pro)
                                        <tr>
                                            <th>
                                                {{$pro->one_product->name}}
                                            </th>
                                            <th>
                                                <?php $total+=$pro->price; ?>
                                                {{$pro->price}}
                                            </th>
                                            <th>
                                                {{$pro->amount}}
                                            </th>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th>
                                                {{__('orders.total_price')}}

                                            </th>
                                            <th colspan="2" class="text-center">
                                                {{$total}}
                                            </th>
                                        </tr>

                                    </table>



                                <a href="tel:+{{$record->customer_phone1}}" class="btn btn-dark">{{__('orders.Call_Customer')}}</a>
                                <a data-bs-toggle="modal" data-bs-target="#exampleModalCenter{{$record->id}}" class="btn btn-dark">{{__('orders.Change_state')}}</a>

                            </div>
                            <div class="card-footer text-muted">
                                {{$record->zone['title_'. App::getLocale()]}} , {{$record->district['title_'. App::getLocale()]}}  , {{$record->address}}
                            </div>
                        </div>
                        @endforeach
                        @else
                            <div class="col-sm-12 card text-center h5" style="border: 5px double black;padding:20px">
                               {{__('orders.There_is_no_orders_yet!')}}
                            </div>
                            @endif
                    </div>
                </div> <!-- container-fluid -->

            </div>
        </div>
    </div> <!-- end col -->
    @foreach($orders as $record)

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Order # {{$record->id}}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('delivery.change.order_state.post')}}" method="post">
                        @csrf
                        <table class="table">
                            <tr>
                                <th>
                                    {{__('orders.State')}}
                                </th>
                                <th>
                                    <select name="state" class="btn btn-dark form-control">
                                        <option value="12">{{__('orders.Dont_Reply')}}</option>
                                        <option value="11">{{__('orders.Cancelled')}}</option>
                                        <option value="10">{{__('orders.Received')}}</option>
                                    </select>
                                    <input type="hidden" name="order_id" value="{{$record->id}}">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <textarea class="col-sm-12 form-control  text-left" name="notes">{{$record->notes}}</textarea>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-center">
                                    <button type="submit" class="btn btn-dark">{{__('orders.Save_changes')}}</button>

                                </th>
                            </tr>
                        </table>

                    </form>
                </div>

            </div>
        </div>
    </div>
    @endforeach
    <!-- end row -->
    </div>
@endsection

