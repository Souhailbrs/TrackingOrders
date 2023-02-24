@extends("layouts.admin")
@section("pageTitle", "Order Settings")
@section("content")
    <div class="row">
        <a class="col-sm-3" href="{{route('admin.orders.settings.countries')}}">
            Back To All
        </a>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-12 text-center p-2 h3">
            {{$country_details['title_' . App::getLocale() ]}}
        </div>
        <hr>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">

                    <form action="{{route('admin.orders.update.settings')}}" method="post">
                        @csrf
                        <table class="table table-centered table-hover">
                            <tr>
                                <th> Order Status</th>
                                <th>Number</th>
                                <th>Available</th>
                            </tr>
                            @foreach($records as $record)
                                <tr>
                                    <td>
                                        {{$record->name}}
                                    </td>
                                    <td>
                                        <input type="number" name="numbers[]" value="{{$record->number}}">
                                        <input type="hidden" name="ids[]" value="{{$record->id}}">

                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="available_{{$record->id}}" role="switch"  @if($record->available == 1) checked @endif id="flexSwitchCheckDefault{{$record->id}}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-center">
                                    <input type="submit" value="Save Changes" class="text-center form-control">

                                </td>
                            </tr>
                        </table>
                    </form>
                    <alert class="alert-danger text-center">
                        Through This section we control Showing Orders for Call Centers. <br>
                        Make Sure To Sort Them Correctly!. <br>
                        We Start From 0, For Ex if we have 4 types. <br>
                        0 , 1 , 2 , 3 <br>
                        Not 1 , 2 , 3 , 4

                    </alert>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

@endsection
