@extends("layouts.admin")
@section("pageTitle", "Zones")
@section("style")
@endsection
<?php
use App\Models\Delivery;
use App\Models\Zone;
function getOtherDeliveries($id){
    $zone =  Zone::find($id);
    $old_users = json_decode($zone->description);
    $zone_users  = Delivery::where('zone_id',$id)->get();
    foreach($zone_users as $user){
        $old_users [] = $user->id;
    }
    $res= Delivery::whereNotIn('id',$old_users)->get();
    if(count($res)> 0){
        return $res;
    }else{
        return [];
    }
    //Delivery::whereNotIn()
}
function viewAlternative($id){
    $zone =  Zone::find($id);
    $old_users = json_decode($zone->description);
    $res  = Delivery::whereIn('id',$old_users)->get();
    if(count($res)> 0){
        return $res;
    }else{
        return [];
    }
    //Delivery::whereNotIn()
}
?>
@section("content")
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive " >
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



                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-body">
                                        <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name Arabic</th>
                                                <th>Name English</th>
                                                <th>Deliveries</th>
                                                <th>City</th>

                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($records as $record)
                                                <tr>
                                                    <td>#{{$record->id}}</td>
                                                    <td>{{$record->title_ar}}</td>
                                                    <td>{{$record->title_en}}</td>

                                                    <td>
                                                        <input type="button" class="btn btn-dark" value="view"  data-toggle="modal" data-target="#exampleModalZone{{$record->id}}">
                                                    </td>
                                                    <td>
                                                        {{$record->city['title_'. App::getLocale()]}}
                                                    </td>
                                                    <td>
                                                        <a href="{{route('zones.edit',['zone'=>$record->id])}}" class="mr-3 text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>

                                                        <form action="{{route('zones.destroy',['zone'=>$record->id])}}" method="post" style="display:inline-block">
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

    @foreach ($records as $record)
        <div class="modal fade" id="exampleModalZone{{$record->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Zone {{$record['title_' . App::getLocale()]}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tr>
                                <th>
                                    Main Delivery
                                </th>
                                <th>
                                    @if($record->delivery)
                                    {{$record->delivery->name}}
                                    @else
                                    {{'There is no main delivery yet!'}}
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    Status
                                </td>
                                <td>
                                    @if($record->delivery)
                                       @if($record->delivery->status == 1)
                                       <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Disable</span>
                                        @endif
                                    @else
                                        {{'There is no main delivery yet!'}}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">

                                </td>
                            </tr>
                            <tr>

                            </tr>

                        </table>
                        <?php

                        $viewAlternative = viewAlternative($record->id);
                        ?>
                        <table class="table">
                            <tr>
                                <th>
                                    Alternative Delivery
                                </th>
                                <th>
                                   Status
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            <!--          Current Alternatives                  -->
                            @foreach($viewAlternative as $alt)
                            <tr>
                                <td>
                                    {{$alt->name}}
                                </td>
                                <td>
                                    @if($alt->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Disable</span>
                                    @endif

                                </td>
                                <td>
                                    <a type="button" class="btn btn-danger" href="{{route('zone.actionAlternative',['zone_id'=>$record->id,'delivery'=>$alt->id,'action'=>'remove'])}}">remove</a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">

                                </td>
                            </tr>
                            <tr>

                            </tr>

                        </table>
<?php

    $getOtherDeliveries = getOtherDeliveries($record->id);
?>
                        <table class="table">
                            <tr>
                                <td colspan="3">
                                    Add New Alternative Delivery
                                </td>

                            </tr>
                            <tr>
                                <form action="{{route('actionAlternativePost')}}" method="post">
                                    @csrf
                                <td colspan="2">
                                    <input type="hidden" value="{{$record->id}}" name="zone_id">
                                    <input type="hidden" value="{{'add'}}" name="action">

                                    <select type="button" class="btn btn-dark col-sm-12" name="delivery">
                                        @if(count($getOtherDeliveries) > 0)
                                        @foreach($getOtherDeliveries as $getOther)
                                            <option value="{{$getOther['id']}}">{{$getOther['name']}}</option>
                                        @endforeach
                                            @else
                                            <option value="">There is no alternatives</option>

                                        @endif
                                    </select>
                                </td>
                                <td>
                                    @if(count($getOtherDeliveries) > 0)
                                    <input type="submit" class="btn btn-dark" value="Add">
                                        @endif
                                </td>
                                </form>
                            </tr>

                            <tr>

                            </tr>

                        </table>



                    </div>

                </div>
            </div>
        </div>
    @endforeach
        <script>
        function modelDes(x,y){
            document.getElementById('modelImagee').innerHTML =`
            <div class="modal " id="image`+x+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">  {{__('admin/category.Image')}}  </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="group-img-container text-center post-modal">
                                <img  src="{{asset('assets/images/users/`+ y +`')}}" alt="" class="group-img img-fluid" style="width:400px; hieght:400px" ><br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                        </div>
                    </div>
                </div>
            </div>
        `
        }

        function modelAddProduct(x){
            document.getElementById('modelAdd').innerHTML =`
            <div class="modal " id="form`+x+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"> {{__('admin/category.Image')}} </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{route('usersTypes.store')}}" >
                            @csrf
            <input type="hidden" name="category_id" value="`+x+`">
                            <input type="hidden" name="state" value="available">
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">{{__('admin/category.Code')}}:</label>
                                    <textarea class="form-control" name="code" id="message-text"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('admin/category.Save')}}</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('admin/category.Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        `
        }
    </script>
@endsection

