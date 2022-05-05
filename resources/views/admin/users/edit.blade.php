@extends("layouts.admin")
@section("pageTitle", "User Types Page")
@section("content")

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
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

                            <div class="custom-control custom-switch" >
                                @if($user->status == 1)
                                    <input type="checkbox" class="custom-control-input" id="customSwitches" checked name="status"  >
                                @else
                                    <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" >
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





                    <div class="form-group row">
                        <label for="example-text-input" class="col-sm-2 col-form-label">{{__('New Password')}}</label>
                        <div class="col-sm-10">

                            <input class="form-control"   id="example-text-input" name="new_pas" value="" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-dark w-25">{{__('Save Changes')}}</button>
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
