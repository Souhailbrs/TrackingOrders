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

                    <div class="container-fluid">
                        <div class="card">
                            <div class="card-body">
                                <div class="row text-center">

                                    <div class="col-sm-6 h4" style="font-weight:bolder">
                                        Select  Specific Shop
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control col-sm-6" >
                                            <option value="">
                                                All Shops
                                            </option>
                                            <option value="">
                                                Shop1
                                            </option>
                                            <option value="">
                                                Shop2
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <th>Category</th>
                                            <th>Product</th>
                                            <th>Amount</th>
                                            <th>Price</th>
                                            <th>Sold</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($records as $record)
                                            <tr>
                                            <td>
                                                #{{$record->id}}
                                            </td>
                                            <td>
                                                <a href="">
                                                    Shop Name
                                                </a>
                                            </td>
                                            <td>
                                                Shop Type
                                            </td>
                                            <td>
                                                Url
                                            </td>
                                            <td>
                                                Country
                                            </td>
                                            <td>
                                                City
                                            </td>
                                            <td>
                                                20
                                            </td>
                                            <td><span class="badge badge-success">Active</span></td>
                                            <td>
                                                <a href="javascript:void(0);" class="mr-3 text-muted"
                                                   data-toggle="tooltip" data-placement="top" title=""
                                                   data-original-title="Edit"><i
                                                        class="mdi mdi-pencil font-size-18"></i></a>
                                                <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip"
                                                   data-placement="top" title="" data-original-title="Delete"><i
                                                        class="mdi mdi-close font-size-18"></i></a>
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
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>

@endsection
<!-- Name -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
                <table class="table col-sm-12 table-bordered text-center">
                    <tr>
                        <td>
                            Name Ar
                        </td>
                        <td>
                            Name En
                        </td>
                    </tr>
                    <tr>
                        <td>
                            باقه جديده
                        </td>
                        <td>
                            New Package
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
<!-- Details -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
                <table class="table col-sm-12 table-bordered text-center">
                    <tr>
                        <td>
                            Name Ar
                        </td>
                        <td>
                            Name En
                        </td>
                    </tr>
                    <tr>
                        <td>
                            باقه جديده
                        </td>
                        <td>
                            New Package
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
<!-- Features -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
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
                <table class="table col-sm-12 table-bordered text-center">
                    <tr>
                        <td>
                            Name Ar
                        </td>
                        <td>
                            Name En
                        </td>
                    </tr>
                    <tr>
                        <td>
                            باقه جديده
                        </td>
                        <td>
                            New Package
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
