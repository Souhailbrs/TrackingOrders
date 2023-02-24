@extends('layouts.admin')
@section('pageTitle', 'Add Country')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">



                    <form method="post" action="{{ route('countries.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name English</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_en" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Name Arabic</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="title_ar" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Currency Name</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="currency" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label">Currency Symbol</label>
                            <div class="col-sm-10">
                                <input class="form-control" type="text" id="example-text-input" name="currency_symbol"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-dark w-25">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


@endsection
