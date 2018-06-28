@extends('common/layouts')

@section('content')

@include('common/validator')





    <!-- 自定义内容区域 -->
    <div class="panel panel-default">
        <div class="panel-heading">新增学生</div>
        <div class="panel-body">
            <form class="form-horizontal" action="" method ="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">姓名</label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="name" name="student[name]" value = "{{old('student.name')}}" placeholder="请输入学生姓名">
                    </div>

                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('student.name')}}</p>
                    </div>
                </div>


                {{--testing--}}
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">测试</label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="name" name="test" value = "{{old('test')}}" placeholder="请输入学生姓名">
                    </div>

                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('test')}}</p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="age" class="col-sm-2 control-label">年龄</label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="age" name="student[age]" value = "{{old('student')['age']}}" placeholder="请输入学生年龄">
                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('student.age')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">性别</label>

                    <div class="col-sm-5">
                        @foreach($students->sex() as $key=>$val)

                        <label class="radio-inline">
                            <input type="radio" name="student[sex]"
                                   {{null !== old('student.sex') && old('student.sex')==$key?'checked':''}}
                                   value="{{$key}}"> {{$val}}
                        </label>

                        @endforeach

                    </div>
                    <div class="col-sm-5">
                        <p class="form-control-static text-danger">{{$errors->first('student.sex')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
