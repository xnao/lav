@extends('layout')

@section('header')
    @parent
    //rewrite header with layout info

    this is the header
@stop

@section('sidebar')
    rewrite the sidebar
    <!-- this is the comments-->
    <!-- output the php code-->
    <p>{{$name}}</p><!-- with php variable-->
    <p>{{date('Y-m-d')}}</p>
    <p>{{in_array($name, $array)?'T':'F'}}</p>
    <p>{{var_dump($array)}}</p>
    <p>{{isset($name)?$name:'Default Name'}}1</p><!-- using default value-->
    <p>{{$name or 'Default Value'}}2</p><!-- using default value-->
    <!-- origin output without convert-->
    <!-- wants to output {{$name}}-->
    <p>@{{ $name }}</p>

    {{--view comment show comment but not show on the source view--}}

    {{--using sub-view : include--}}
    @include('student/comment1',['message'=>'rewrite the message for the sub-view'])
<hr />
    {{--system flow control if/unless/for/foreach--}}
    {{--if statement1--}}
    @if($name=='David')
    i'm davidddd
    @elseif($name=="sean")
    i'm seannnnn
    @else
    who am i?
    @endif
    {{--if statment2--}}
    @if (in_array($name,$array))
    true
    @else
    false
    @endif

<hr />
    {{--unless statement equals if not --}}
    @unless($name =="David")
    I'm david
    @endunless
<hr />
    {{--for statament--}}
    @for ($i=0;$i<3;$i++)
    <p>{{$i}}</p>
    @endfor
<hr />
    {{--Foreach statement--}}
    @foreach($students as $student)
    <p>{{$student->name}}</p>
    @endforeach
<hr />
    {{--Forelse statement: if there is a data, then will be explored, if is empty then will output msg--}}
    @forelse($emptyArrays as $emptyArray)
        <p>{{$emptyArray->abc}}</p>
    @empty
        <p>null</p>
    @endforelse


@stop

@section('content')
    this is new content
@stop

{{--Generate URL in the template View file: url()/action()/route()--}}
{{--url(): use roter name to generate URL--}}
{{--action(): use indicated controller@action generate URL--}}
{{--route(): use route alias generate URL--}}
<a href ="{{url('urlTest')}}">url() generate url {{url('urlTest')}}</a><br />
<a href="{{action('studentController@urlTest')}}">action() generate </a><br />
<a href="{{route('urlAlias')}}">route() generate url {{route('urlAlias')}}</a>




