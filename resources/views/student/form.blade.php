<form class="form-horizontal" action ='' method="post">
    @csrf
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">姓名</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="name" name = "student[name]"
                   value="{{null !== old('student.name')?old('student.name'):$student['name']}}" placeholder="请输入学生姓名">
        </div>
        <div class="col-sm-5">
            <p class="form-control-static text-danger">{{$errors->first('student.name')}}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="age" class="col-sm-2 control-label">年龄</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="age" name = "student[age]"
                   value="{{null !== old('student.age')?old('student.age'):$student['age']}}"placeholder="请输入学生年龄">
        </div>
        <div class="col-sm-5">
            <p class="form-control-static text-danger">{{$errors->first('student.age')}}</p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">性别</label>

        <div class="col-sm-5">
            @foreach($student->sex() as $key=>$val)
            <label class="radio-inline">
                <input type="radio" name="student[sex]" value="{{$key}}"
                {{null !== old('student.sex') && old('student.sex')==$key?'checked':''}}
                {{null !== $student['sex'] && null == old('student.sex') &&$student['sex']==$key?'checked':''}}
                > {{$val}}
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