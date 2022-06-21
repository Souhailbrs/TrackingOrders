@extends("layouts.admin")
@section("pageTitle", "Packages")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive " >


                        <div class="container-fluid">



                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Details</th>
                                                    <th>Features</th>
                                                    <th>Price</th>
                                                    <th>Duration</th>
                                                    <th>Requests</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <img src="{{asset('assets/site/images/all-img/App-01.png')}}" alt="" style="width:100px;height:100px">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        50 USD
                                                    </td>
                                                    <td>
                                                        20 Days
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View <span style="color:red;font-weight:bolder">[</span>3 <span style="color:red;font-weight:bolder">]</span>
                                                        </button>
                                                    </td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <img src="{{asset('assets/site/images/all-img/App-01.png')}}" alt="" style="width:100px;height:100px">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        50 USD
                                                    </td>
                                                    <td>
                                                        20 Days
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View <span style="color:red;font-weight:bolder">[</span>3 <span style="color:red;font-weight:bolder">]</span>
                                                        </button>
                                                    </td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <img src="{{asset('assets/site/images/all-img/App-01.png')}}" alt="" style="width:100px;height:100px">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        50 USD
                                                    </td>
                                                    <td>
                                                        20 Days
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View <span style="color:red;font-weight:bolder">[</span>3 <span style="color:red;font-weight:bolder">]</span>
                                                        </button>
                                                    </td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <img src="{{asset('assets/site/images/all-img/App-01.png')}}" alt="" style="width:100px;height:100px">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View
                                                        </button>
                                                    </td>
                                                    <td>
                                                        50 USD
                                                    </td>
                                                    <td>
                                                        20 Days
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalCenter">
                                                            View <span style="color:red;font-weight:bolder">[</span>3 <span style="color:red;font-weight:bolder">]</span>
                                                        </button>
                                                    </td>
                                                    <td><span class="badge badge-success">Active</span></td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <a href="javascript:void(0);" class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                                    </td>
                                                </tr>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center" >
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center" >
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center" >
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
