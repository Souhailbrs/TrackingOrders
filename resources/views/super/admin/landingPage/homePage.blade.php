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
                            @if($val['field'] == 'title_ar')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title Arabic</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="title_ar"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                            @if($val['field'] == 'details_ar')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Description
                                        Arabic</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" type="text" id="example-text-input"
                                                  name="details_ar" required>{{$val['value']}}</textarea>
                                    </div>
                                </div>
                            @endif

                            @if($val['field'] == 'title_en')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title
                                        English</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" id="example-text-input" name="title_en"
                                               required value="{{$val['value']}}">
                                    </div>
                                </div>
                            @endif
                            @if($val['field'] == 'details_en')
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Description
                                        English</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" type="text" id="example-text-input"
                                                  name="details_en" required>{{$val['value']}}</textarea>
                                    </div>
                                </div>
                            @endif
                            @if($val['field'] == 'logo_black')

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Logo Black</label>
                                    <div class="custom-file col-sm-10">
                                        <input name="logo_black" type="file" class="custom-file-input"
                                               id="customFileLangHTML" value="{{$val['value']}}">
                                        <label class="custom-file-label" for="customFileLangHTML"
                                               data-browse="Uplpoad File"></label>
                                    </div>
                                    <img src="{{asset('assets/site/images/main_images/'.$val['value'])}}" alt=""
                                         style="width:100px;height:100px">

                                </div>
                            @endif
                            @if($val['field'] == 'logo_white')

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Logo White</label>
                                    <div class="custom-file col-sm-10">
                                        <input name="logo_white" type="file" class="custom-file-input"
                                               id="customFileLangHTML" value="{{$val['value']}}">
                                        <label class="custom-file-label" for="customFileLangHTML"
                                               data-browse="Uplpoad File"></label>
                                    </div>
                                    <img src="{{asset('assets/site/images/main_images/'.$val['value'])}}" alt=""
                                         style="width:100px;height:100px">
                                </div>
                            @endif
                            @if($val['field'] == 'background')

                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Background</label>
                                    <div class="custom-file col-sm-10">
                                        <input name="background" type="file" class="custom-file-input"
                                               id="customFileLangHTML" value="{{$val['value']}}">
                                        <label class="custom-file-label" for="customFileLangHTML"
                                               data-browse="Uplpoad File"></label>
                                    </div>
                                    <img src="{{asset('assets/site/images/main_images/'.$val['value'])}}" alt=""
                                         style="width:100px;height:100px">
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
