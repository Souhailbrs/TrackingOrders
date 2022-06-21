@extends("layouts.supporter")
@section("pageTitle", "Sells Channels")
@section("style")
@endsection
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatable"
                               class="table table-striped dt-responsive nowrap table-vertical"
                               style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th colspan="7">
                                    <h2 class="text-center">
                                        Work Days
                                    </h2>
                                </th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Start Work At</th>
                                <th>End Work At</th>
                                <th>Finished</th>
                                <th>Orders Number</th>
                                <th>View Orders</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1 ?>
                            @foreach($records as $record)
                                <tr>
                                    <td>
                                        #{{$i}}
                                    </td>

                                    <td>
                                        {{date('m/d/Y h:i:s A', strtotime($record->started_at)) }}
                                    </td>
                                    <td>
                                        {{date('m/d/Y h:i:s A', strtotime($record->finished_at)) }}
                                    </td>
                                    <td>
                                        @if($record->completed == 0)
                                            {{'Working'}}
                                        @else
                                            {{'Finished'}}
                                        @endif
                                    </td>
                                    <td>
                                        {{count($record->day_orders) . ' Orders'}}
                                    </td>

                                    <td>
                                        <a class="btn btn-dark col-sm-12 d-block" target="_blank"
                                           href="{{route('supporter.orders.viewWorkDayOrders',['day'=>$record->id])}}">
                                            View
                                        </a>
                                    </td>

                                </tr>
                                <?php $i++ ?>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
