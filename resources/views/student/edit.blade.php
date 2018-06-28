@extends('common/layouts')

@section('content')

    @include('common/message')



            <!-- 自定义内容区域 -->
            <div class="panel panel-default">
                <div class="panel-heading">修改学生</div>
                <div class="panel-body">
                    @include('student/form');
                </div>
            </div>



@stop
