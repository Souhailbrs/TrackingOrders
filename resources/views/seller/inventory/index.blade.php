@extends("layouts.seller")
@section("pageTitle", "Inventory")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive ">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
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
                                            <th>ID</th>
                                            <th>Shop Name</th>
                                            <th>Product Name</th>
                                            <th>Details</th>
                                            <th>Expected Time</th>
                                            <th>Actual Time</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>
                                                    #{{$record->id}}
                                                </td>
                                                <td>
                                                    {{$record->shop['title_'. App::getlocale()]}}
                                                </td>
                                                <td>
                                                    {{$record->product->name}}
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#details{{$record->id}}">
                                                        View
                                                    </button>

                                                </td>
                                                <td>
                                                    {{$record->Expected_time}}

                                                </td>
                                                <td>
                                                    {{$record->Actual_time}}

                                                </td>
                                                @if($record->status == 0)
                                                    <td><span class="badge bg-warning">Pending</span></td>
                                                @elseif($record->status == 1)
                                                    <td><span class="badge bg-success">Active</span></td>
                                                @else
                                                    <td><span class="badge bg-danger">Refused</span></td>
                                                @endif
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
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>

@foreach($records as $record)
    <!-- Details -->
    <div class="modal fade" id="details{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Product</h6>
                    <table class="table col-sm-12 table-bordered text-center">
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                Boxes Number
                            </td>
                            <td>
                                Amount
                            </td>
                            <th>
                                Delivery Type
                            </th>
                        </tr>
                        <tr>
                            <td>
                                {{$record->product->name}}
                            </td>
                            <td>
                                {{$record->boxes_number}} Box
                            </td>
                            <td>
                                {{$record->product_amount}} 
                            </td>
                            <td>
                                {{$record->delivery_type}}
                            </td>
                        </tr>
                    </table>
                    <h6>Company</h6>
                    <table class="table col-sm-12 table-bordered text-center">
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                Number
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{$record->company_name}}
                            </td>
                            <td>
                                {{$record->company_number}}
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endforeach

@endsection
