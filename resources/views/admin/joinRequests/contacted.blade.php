@extends("layouts.admin")
@section("pageTitle", "Sells Channels")
@section("style")
@endsection
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card" style="min-height: 800px">
                <div class="card-body table-responsive ">

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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Contacted Date</th>
                                            <th>Accepted Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($records) > 0)
                                            @foreach($records as $record)
                                                <tr>
                                                    <td>
                                                        #{{$record->id}}
                                                    </td>
                                                    <td>
                                                        {{$record->name}}
                                                    </td>
                                                    <td>
                                                        {{$record->email}}
                                                    </td>
                                                    <td>
                                                        {{$record->mobile}}
                                                    </td>

                                                    <td>
                                                        {{date_format( $record->created_at,"Y/m/d")}}
                                                    </td>
                                                    <td>
                                                        @if($record->state  == 1)
                                                        {{date_format( $record->updated_at,"Y/m/d")}}
                                                        @else
                                                            {{'Not Accepted Yet!'}}
                                                        @endif
                                                    </td>
                                                    <div class="text-center">
                                                        @if($record->state == 0)
                                                            <td><span class="badge bg-warning p-2" style="width:100%">Pending</span></td>
                                                        @elseif($record->state == 1)
                                                            <td><span class="btn btn-success p-2" style="width:100%">Accepted</span></td>
                                                        @elseif($record->state == 2)
                                                            <td><span class="badge  bg-primary p-2" style="width:100%;">Call Again</span></td>
                                                        @elseif($record->state == 3)
                                                            <td><span class="badge bg-danger p-2" style="width:100%">Ignore</span></td>
                                                        @endif

                                                    </div>

                                                    <td>
                                                        <center>

                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Controll
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                                    <a class="dropdown-item col-sm-12 d-block"  href="{{route('change.requests.state',['requestId'=>$record->id,'state'=>2])}}">Call Again</a>
                                                                    <a class="dropdown-item  col-sm-12 d-block"  href="{{route('change.requests.state',['requestId'=>$record->id,'state'=>3])}}">Ignore</a>

                                                                    <a class="dropdown-item col-sm-12 d-block"  href="{{route('change.requests.accept',['requestId'=>$record->id])}}">Accept</a>
                                                                    <a class="dropdown-item   col-sm-12 d-block"  data-toggle="modal" data-target="#exampleModalCenter{{$record->id}}">Notes</a>

                                                                </div>
                                                            </div>

                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="12 ">
                                                    <center>
                                                        There Is No Records Yet!

                                                    </center>
                                                </td>
                                            </tr>
                                        @endif


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
    </div>

    <div id="modelImagee">

    </div>
    <div id="modelAdd">

    </div>

<!-- Notes -->
@foreach($records as $record)
    <div class="modal fade" id="exampleModalCenter{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Set Notes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="table col-sm-12 table-bordered text-center" action="{{route('change.requests.notes')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="requestId" value="{{$record->id}}">
                                <textarea class="form-control" name="notes" id="" cols="30" rows="10">{{$record->notes}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-dark pt-1">Submit</button>
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
    <div class="modal fade" id="exampleModalCentercreate{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Set Notes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="table col-sm-12 table-bordered text-center" action="{{route('change.requests.file')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="requestId" value="{{$record->id}}">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">File</label>
                                    <div class="custom-file col-sm-10">
                                        <input name="image" type="file" class="custom-file-input" id="customFileLangHTML" required>
                                        <label class="custom-file-label" for="customFileLangHTML" data-browse="Uplpoad File"></label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-dark pt-1">Submit</button>
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
