@extends("layouts.packaging")
@if(LaravelLocalization::getCurrentLocale() == 'ar')
    @section("pageTitle", "الرئيسية")
@else
    @section("pageTitle", "Home")
@endif
@section('styleChart')
    <link href="{{asset("assets/admin/libs/c3/c3.min.css")}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
@endsection
@section("content")
    {{-- {{ Money::USD(500)}} --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                                        <?php $i=1 ?>
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
                                                    <a class="btn btn-dark col-sm-12 d-block"  target="_blank" href="{{route('supporter.getAllOrders',['state'=>$record->id])}}">
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


                </div> <!-- container-fluid -->

                {{--
                                    {{ $data->links() }}
                --}}
            </div>
        </div>
    </div> <!-- end col -->



    <!-- end row -->
@endsection

