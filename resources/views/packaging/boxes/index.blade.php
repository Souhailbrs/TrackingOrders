@extends("layouts.packaging")
@section("pageTitle", "Countries")
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

                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Zone</th>
                                                <th>District</th>
                                                <th>Orders</th>
                                                <th>Delivery</th>
                                                <th>Status</th>
                                                <th>Track Box</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($records as $record)
                                                <tr>
                                                    <td>#{{$record->id}}</td>
                                                    <td>{{$record->zone['title_'.App::getlocale()]}}</td>
                                                    <td>{{$record->district['title_'.App::getlocale()]}}</td>
                                                    <td >
                                                        <button  class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter{{$record->id}}">
                                                            View
                                                        </button>

                                                    </td>
                                                    @if($record->delivery_id)
                                                    <th>{{$record->delivery->name}}</th>
                                                    @else
                                                        <th>
                                                            <a class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenterbox{{$record->id}}">
                                                              {{'Select a delivery for your box'}}
                                                            </a>
                                                        </th>
                                                    @endif
                                                    <td>
                                                        <a href="{{route('packaging.box.order.status',['id'=>$record->id,'state'=>$record->status])}}">
                                                            @if($record->status == 1)
                                                                Ready
                                                            @else
                                                                Not Ready
                                                            @endif
                                                        </a>
                                                    </td>
                                                    <td>
                                                        View
                                                    </td>
                                                    <td>

                                                        <form action="{{route('countries.destroy',['country'=>$record->id])}}" method="post" style="display:inline-block">
                                                            @method('DELETE')
                                                            @csrf
                                                            <span type="submit" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="$(this).closest('form').submit();"> <i class="mdi mdi-close font-size-18"></i> </span>

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

