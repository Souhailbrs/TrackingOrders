@extends("layouts.admin")
@section("pageTitle", "Sells Channels")
@section("style")
@endsection
@section("content")

    <div class="row">
        <div class="col-12">
            <div class="card" style>
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
                        @if($back == 1)
                        <div class="col-sm-6">
                            <a class="btn btn-dark" href="{{route('get.products')}}" >
                                Back to all sellers
                            </a>
                        </div>
                            <div class="col-sm-6 h6 text-center">
                                Number of products : {{count($records)}}
                            </div>
                        @else
                            <div class="col-sm-12 h6 text-center">
                                Number of products : {{count($records)}}
                            </div>
                        @endif

                    </div>
                        <hr>
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
                                            <th>Seller Name</th>
                                            <th>Seller Phone</th>

                                            <th>Name</th>
                                            <th>Received</th>
                                            <th>Amount</th>
                                            <th>Sold</th>
                                            <th>Status</th>
                                            <th>Change Status</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>
                                                    #{{$record->id}}
                                                </td>
                                                <td>
                                                    <a href="{{route('get.seller.products',['id'=>$record->seller->id])}}">
                                                        {{$record->seller->name}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$record->seller->phone}}
                                                </td>
                                                <td>
                                                    {{$record->name}}
                                                </td>
                                                <td>
                                                    {{$record->received}}

                                                </td>
                                                <td>
                                                    {{$record->amount}}

                                                </td>
                                                <td>
                                                    {{$record->sold}}

                                                </td>
                                                @if($record->status == 1)
                                                    <td><span class="badge bg-success">Active</span></td>
                                                @else
                                                    <td><span class="badge bg-danger">De-Activated</span></td>
                                                @endif
                                                <input type="hidden" id="product_id" value="{{$record->id}}">
                                                <td>
                                                <a href="{{route('admin.change.product.status',['id'=>$record->id])}}" class="btn btn-dark" >Change</a>
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



@foreach($records as $record)
    <!-- Details -->
    <div class="modal fade" id="details{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                {{$record->product_name}}
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach




@endsection

