@extends("layouts.seller")
@section("pageTitle", "Sells Channels")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive " >
                    @include('admin.includes.messages')

                    <div class="container-fluid">



                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Shop Name</th>
                                                    <th>Shop Type</th>
                                                    <th>Shop Url</th>
                                                    <th>Country</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data as $record)
                                                    <tr>
                                                    <td>
                                                        #{{$record->id}}
                                                    </td>
                                                    <td>
                                                        {{$record['title_'. App::getlocale()]}}
                                                    </td>
                                                    <td>
                                                        {{$record->shopType['title_' . App::getLocale()]}}
                                                    </td>
                                                    <td>
                                                        {{$record->shop_url}}
                                                    </td>
                                                    <td>
                                                        {{$record->country['title_'. App::getLocale()]}}
                                                    </td>

                                                    @if($record->status == 1)
                                                            <td><span class="badge bg-success">Active</span></td>
                                                    @else
                                                            <td><span class="badge bg-danger">Deactivate</span></td>
                                                    @endif
                                                    <td>
                                                        <a href="{{route('seller.sellChannels.edit',['sellChannel'=>$record->id])}}" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                        <form action="{{route('seller.sellChannels.destroy',['sellChannel'=>$record->id])}}" method="post" style="display:inline-block">
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
    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>


<!-- Name -->
@foreach($data as $record)
<div class="modal fade" id="exampleModalCenterOwner{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{$page}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table col-sm-12 table-bordered text-center" >
                    <tr>
                        <td>
                            Email
                        </td>
                        <td>
                            Phone
                        </td>
                    </tr>
                    <tr>

                        <td>
                            {{$record->owner_email}}
                        </td>

                        <td>
                            {{$record->owner_phone}}
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
@endforeach

@endsection
