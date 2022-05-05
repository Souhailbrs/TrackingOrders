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

                        @endforeach

                        @for($i=1;$i<4;$i++)
                            <h6>
                                Frequently Asked Questions  {{$i}}
                            </h6>

                            <div class="container">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title
                                        Arabic</label>
                                    <div class="col-sm-10">
                                        @foreach($values as $val)
                                            @if($val->field == 'headline_title_ar_'.$i)
                                                <input class="form-control" type="text" id="example-text-input" name="headline_title_ar_{{$i}}"
                                                       required value="{{$val->value}}">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Title
                                        English</label>
                                    <div class="col-sm-10">
                                        @foreach($values as $val)
                                            @if($val->field == 'headline_title_en_'.$i)
                                                <input class="form-control" type="text" id="example-text-input" name="headline_title_en_{{$i}}"
                                                       required value="{{$val->value}}">
                                            @endif
                                        @endforeach

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Description
                                        Arabic</label>
                                    <div class="col-sm-10">
                                        @foreach($values as $val)
                                            @if($val->field == 'headline_description_ar_'.$i)
                                                <textarea class="form-control" type="text" id="example-text-input"
                                                          name="headline_description_ar_{{$i}}" required>{{$val->value}}</textarea>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Description
                                        English</label>
                                    <div class="col-sm-10">
                                        @foreach($values as $val)
                                            @if($val->field == 'headline_description_en_'.$i)
                                                <textarea class="form-control" type="text" id="example-text-input"
                                                          name="headline_description_en_{{$i}}" required>{{$val->value}}</textarea>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endfor
                        @if($val['field'] == 'image')

                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="custom-file col-sm-10">
                                    <input name="image" type="file" class="custom-file-input"
                                           id="customFileLangHTML" value="{{$val['value']}}">
                                    <label class="custom-file-label" for="customFileLangHTML"
                                           data-browse="Uplpoad File"></label>
                                </div>
                                <img src="{{asset('assets/site/images/main_images/'.$val['value'])}}" alt=""
                                     style="width:100px;height:100px">
                            </div>
                        @endif
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
