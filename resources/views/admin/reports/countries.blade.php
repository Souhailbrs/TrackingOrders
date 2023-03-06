@extends("layouts.admin")
@section("pageTitle", "Invoice")
@section("content")

    <div class="row">
        @foreach($records as $record)
            <a class="card col-sm-4 p-4 m-3 text-center h4" style="cursor:pointer"
               href="{{route('earnings.ByCountry',['country'=>$record->id])}}">
                {{$record['title_' . App::getLocale()]}}
            </a> <!-- end col -->
        @endforeach
    </div> <!-- end row -->


@endsection
