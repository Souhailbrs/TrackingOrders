@extends("layouts.seller")
@section("pageTitle", "Sells Channels")
@section("style")
@endsection
@section("content")
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
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Shop Name</th>
                                            <th>Received</th>
                                            <th>Amount</th>
                                            <th>Sold</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                                <td>
                                                    #{{$record->id}}
                                                </td>
                                                <td>
                                                    <img src="{{asset('assets/admin/products/'. $record->image)}}"  style="height:100px;width:100px">
                                                </td>
                                                <td>
                                                    {{$record->shop['title_' . App::getLocale()]}}
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
                                                    <td><span class="badge badge-success">Active</span></td>
                                                @else
                                                    <td><span class="badge badge-danger">De-Activated</span></td>
                                                @endif
                                                <td>
                                                    <a href="{{route('seller.products.edit',['product'=>$record->id])}}" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>

                                                    <form id="del_product{{$record->id}}" method="post" style="display:inline-block" >
                                                        <input type="hidden" id="del_product{{$record->id}}" value="{{$record->id}}">
                                                        @method('DELETE')
                                                        @csrf
                                                        <span type="submit" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="OnDelete()"> <i class="mdi mdi-close font-size-18"></i> </span>
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



@endsection
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





