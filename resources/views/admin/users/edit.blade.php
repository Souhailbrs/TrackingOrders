@extends("layouts.admin")
@section("pageTitle", "User Types Page")
@section("content")

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">


                 <a class="btn btn-outline-primary" href="{{route('users.get.type',['type'=>$types])}}">
                     Back
                 </a>
                    <hr>
                <form method="post" action="{{route('users.update',['user'=>$user->id])}}" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('User Name')}}</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="example-text-input" name="name" value="{{$user->name}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('User Email')}}</label>
                        <div class="col-sm-10">

                            <input class="form-control" id="example-text-input" name="email" value="{{$user->email}}" required>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="{{$type}}">

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('User Phone')}}</label>
                        <div class="col-sm-10">

                            <input class="form-control" type="number" step="any"  id="example-text-input" name="phone" value="{{$user->phone}}" required>
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Status')}}</label>
                        <div class="col-sm-10">


                            <div class="form-check form-switch">
                                @if($user->status == 1)
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked name="status" >
                                @else
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="status" >

                                @endif
                                    <label class="custom-control-label" for="customSwitches" style="cursor:pointer"></label>
                            </div>
                        </div>
                    </div>

                    @if($type == 'delivery')

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Zone ID')}}</label>
                            <div class="col-sm-10">

                                <select class="form-control"   id="example-text-input" name="zone_id"  required>
                                    @if($user->zone->id)
                                        <option value="{{$user->zone->id}}">{{$user->zone['title_'. App::getLocale()]}}</option>
                                    @endif
                                    @foreach($zones  as $zone )
                                        @if($zone->id != $user->zone_id)
                                            <option value="{{$zone->id}}">{{$zone['title_'. App::getLocale()]}}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>

                    @endif


                    @if(Auth::guard('admin')->user()->is_super_admin && $type != 'seller')
                        <div class="form-group row" >
                            <label for="example-text-input"
                                   class="col-sm-2 col-form-label">{{__('admin/fields.country')}}</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="country_id" id="country_id" >
                                    @if($user->country)
                                        @if($user->country->id)
                                            <option value="{{$user->country->id}}">{{$user->country['title_'. App::getLocale()]}}</option>
                                        @endif
                                    @endif
                                    @foreach($countries as $country)
                                            @if($user->country)
                                                @if($user->country->id != $country->id)
                                                    <option value="{{$country['id']}}">{{$country['title_'. App::getLocale()]}}</option>
                                                @endif
                                            @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Upload Image')}}</label>
                        <div class="custom-file col-sm-10">
                            <input name="image" type="file" class="custom-file-input" id="customFileLangHTML1">
                            <label class="custom-file-label" for="customFileLangHTML" data-browse="{{__('Change Image')}}"></label>
                            <input id="fileList" disabled style="background:white;border: 0px" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('Current Image')}}</label>
                        <div class="custom-file col-sm-10">
                            <img src="{{asset('assets/admin/users/'. $user->image)}}"  style="height:100px;width:200px">

                        </div>
                    </div>





                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('New Password')}}</label>
                        <div class="col-sm-10">
                            <input class="form-control"   id="example-text-input" name="new_pas" value="" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-center">
                            <br>
                            <button type="submit" class="btn btn-outline-primary w-25">{{__('Save Changes')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->


@endsection
@section("script")
<script src="{{asset("assets/admin/js/app.js")}}"></script>

@endsection
