<?php

use App\Models\SalesChannels;
use App\Models\Seller;

 function getSeller($sales_channel_type_id){
    $saleChannel =  SalesChannels::find($sales_channel_type_id);
    $email =$saleChannel->owner_email;
    $seller = Seller::where('email',$email)->first();
    return $seller;
}
?>
@extends("layouts.admin")
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
                            @if($back == 1)
                                <div class="col-sm-6">
                                    <a class="btn btn-dark" href="{{route('get.shipments')}}" >
                                        Back to all shipments
                                    </a>
                                </div>
                                <div class="col-sm-6 h6 text-center">
                                    Number of shipments : {{count($records)}}
                                </div>
                            @else
                                <div class="col-sm-12 h6 text-center">
                                    Number of shipments : {{count($records)}}
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
                                                    <a href="{{route('get.seller.shipments',['id'=>getSeller($record->sales_channel_id)['id']])}}">
                                                    {{getSeller($record->sales_channel_id)['name']}}
                                                    </a>
                                                </td>
                                                <td>
                                                    {{$record->shop['title_'. App::getlocale()]}}
                                                </td>
                                                <td>
                                                    {{$record->product->name}}
                                                </td>

                                                <td>
                                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#details{{$record->id}}">
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
                                                    <td><span class="badge badge-warning">Pending</span></td>
                                                @elseif($record->status == 1)
                                                    <td><span class="badge badge-success">Active</span></td>
                                                @else
                                                    <td><span class="badge badge-danger">Refused</span></td>
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
                                {{\App\Models\ProductSeller::find(intval($record->product_name))->name}}
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
                    <h6>Seller</h6>
                    <table class="table col-sm-12 table-bordered text-center">
                        <tr>
                            <td>
                                Name
                            </td>
                            <td>
                                Number
                            </td>
                            <td>
                                Email
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{$record->product->seller->name}}
                            </td>
                            <td>
                                {{$record->product->seller->phone}}
                            </td>
                            <td>
                                {{$record->product->seller->email}}
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
