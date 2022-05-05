@extends("layouts.delivery")
@section("pageTitle", "Boxes")
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
                        @foreach($records as $record)
                        <div class="card col-sm-12 col-md-4" style="width: 18rem;border-style: outset;">
                            <div class="card-title h5 mt-2 text-center ">
                                   # Box Number {{$record->id}}
                            </div>
                            <div class="card-title h5 mt-2 text-center">
                                {{$record->zone['title_'.App::getLocale()]}} , {{$record->district['title_'.App::getLocale()]}}
                            </div>
                            <hr>
                            <div class="card-body row">
                                <h5 class="card-title col-sm-5">All Orders</h5>
                                <p class="card-text col-sm-4">3 Orders</p>
                                <a class="btn btn-dark col-sm-2" href="{{route('delivery.box.orders',['box_id'=>$record->id])}}">view</a>
                            </div>

                            <hr>
                            <div class="card-body row">
                                <h5 class="card-title col-sm-5">Ready Orders</h5>
                                <p class="card-text col-sm-4">3 Orders</p>
                                <a class="btn btn-dark col-sm-2" href="{{route('delivery.box.orders',['box_id'=>$record->id])}}">view</a>
                            </div>

                            </div>
                        @endforeach

                    </div>



                    </div> <!-- container-fluid -->

                    {{--
                                        {{ $data->links() }}
                    --}}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
    @foreach ($records as $record)

        <div class="modal fade" id="exampleModalCenter{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Box Orders</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table col-sm-12 table-bordered text-center">
                        <tr>
                            <td>
                                Order ID
                            </td>
                            <td>
                                Zone
                            </td>
                            <td>
                                District
                            </td>

                            <td>
                                Action
                            </td>
                        </tr>

                            @if(count($record->orders) > 0)
                            @foreach($record->orders as $order)
                                <tr>
                            <td>
                               {{$order->order->id}}
                            </td>
                            <td>
                                {{$order->order->zone['title_'.App::getLocale()]}}
                            </td>
                                <td>
                                    {{$order->order->district['title_'.App::getLocale()]}}
                                </td>
                                <td>
                                    <a href="{{route('packaging.box.order.remove',['id'=>$order->id])}}">
                                        remove
                                    </a>

                                </td>
                                </tr>
                            @endforeach
                            @else
                                <td colspan="5">
                                    There is no orders !
                                </td>
                            @endif

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="exampleModalCenterbox{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Box Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table col-sm-12 table-bordered text-center">
                            <tr>

                                <td>
                                    Zone
                                </td>
                                <td>
                                    District
                                </td>
                            </tr>

                            <tr>

                                    <td>
                                        {{$record->zone['title_'.App::getlocale()]}}
                                    </td>
                                    <td>
                                        {{$record->district['title_'.App::getlocale()]}}
                                    </td>
                                    <?php
                                    $deliveries =  \App\Models\Delivery::where('zone_id',$record->zone->id)->get();
                                    ?>

                            </tr>

                        </table>


                        <form action="{{route('packaging.box.selectDelivery')}}" method="post" >
                            @csrf
                            <div class="row">
                                <label class="form-control col-sm-3 h6 text-center" >SelectDelivery</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="delivery_id">
                                        @foreach($deliveries as $del)
                                            <option value="{{$del->id}}">{{$del->name}} {{ " =>  ". " ".$del->phone}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="box_id" value="{{$record->id}}">
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <center>
                                        <button type="submit" class="btn btn-dark">Submit</button>

                                    </center>
                                </div>
                            </div>
                        </form>




                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endsection

