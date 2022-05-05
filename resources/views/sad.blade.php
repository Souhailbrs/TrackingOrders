<form action="{{route('sad.post')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="your_file">
    <input type="submit" value="click me">
</form>
