@extends('layouts.admin')
@section('pageTitle', 'Edit Country')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">


                    <form method="post" action="{{ route('countries.update', ['country' => $record->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ __('Title English') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_en"
                                    value="{{ $record->title_en }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ __('Title Arabic') }}</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_ar"
                                    value="{{ $record->title_ar }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Currency</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="currency"
                                    value="{{ $record->currency }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Currency Symbol</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="currency_symbol"
                                    value="{{ $record->currency_symbol }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
@section('script')
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>

@endsection
