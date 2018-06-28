

@if(count($errors))
<!-- 所有的错误提示 -->
<div class="alert alert-danger">
    <ul>

        {{--show the first error message--}}
        {{$errors->first()}}
        {{--show all the error message--}}
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif