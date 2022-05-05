@extends("layouts.admin")
@section("pageTitle", "Home Page")
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

                    <form method="post" action="{{route('landingPage.update')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section" value="{{$name}}">
                        @foreach($values as $val)
                            @if($val['field'] == 'location')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Location </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="location"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'address_ar')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Address Arabic </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="address_ar"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'address_en')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Address English </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="address_en"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'phone1')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Phone 1 </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="phone1"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'phone2')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Phone 2 </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="phone2"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'email1')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email 1 </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="email1"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'email2')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Email 2 </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="email2"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'facebook_account')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Facebook Account   </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="facebook_account"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'twitter_account')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Twitter Account   </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="twitter_account"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'instagram_account')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Instagram Account   </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="instagram_account"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach($values as $val)
                            @if($val['field'] == 'linked_account')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">LinkedIn Account   </label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="linked_account"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
