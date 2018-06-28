<?php

namespace App\Http\Controllers;

use App\Jobs\sendEmail;
use App\Model\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    /**
     * insert data into table
     */
    public function test1(){
        //insert data into database table
        $return = DB::insert('insert into student(name,age,sex) value(?,?,?)',['sean',18,0]);

        //update data
        $update = DB::update('update student set name=? where id=?',['sean','2']);

        //select data from database table
        $student = DB::select('select * from student where name !=?',['david']);

//          dd($student);

        //delete
        $del = DB::delete('delete from student where name =?',['sean']);
        var_dump($del);
        return $del; //num of rows has been deleted,
    }

    public function query1(){

        /**
         * insert 1 record into table
         * return bool
         */
//        $res = DB::table('student')
//            ->insert(
//                [
//                    'name'  =>  'imooc',
//                    'age'   =>  11,
//                    'sex'   =>  1,
//                ],
//
//            );

        /**
         * insert 1 record into table
         * return insert ID
         */
//        $res = DB::table('student')
//            ->insertGetId(
//                [
//                    'name'  =>  'imooc',
//                    'age'   =>  99,
//                    'sex'   =>  1,
//                ]
//            );

        /**
         * insert multiple lines of records
         */
        $res = DB::table('student')
            ->insert(
                [
                    [
                        'name'  =>  'david2',
                        'age'   =>  22,
                        'sex'   =>  2
                    ],
                    [
                        'name'  =>  'david3',
                        'age'   =>  33,
                        'sex'   =>  2
                    ],
                ]);

        var_dump($res);


    }

    /**
     * update table data
     */
    public function query2(){
        //update data return num of records updated
//           $res = DB::table('student')
//                ->where('id',9)
//                ->update(
//                    ['age'  => 33]
//                );

        //set age auto add/mins 1 or 3 or any
        $res = DB::table('student')
            ->where('id','>',10)
//            ->increment('age',1000)
            ->decrement('age',10,['name'=>'abcd10']);


        var_dump($res);
    }


    /**
     * delete data
     */
    public function query3(){
        $res = DB::table('student')
            ->where('id','>',10)
            ->delete();//if only has delete();then this will delete all data in the table

        return $res;

        //empty the whole table use with caution
        DB::table('student')
            ->truncate();//this function does not have return value


    }

    /**
     * query data
     */
    public function query4(){
        //use get to get all the data of the table
        $student = DB::table('student')
            ->where('id','>=',4)
            ->orderBy('id','desc')
            ->get();
        var_dump($student);

        //use first to get the first record of the query result
        $student = DB::table('student')
            ->where('id','>=',4)
            ->orderBy('id','desc')
            ->first();

        //with multiple conditions
        $student = DB::table('student')
            ->whereRaw('id>? and age>?',[3,14])
            ->get();

        //use pluck to get indicated fields of the data
        //use key as the array_key for the data value
        $student = DB::table('student')
            ->pluck('name','age');

        //use select to query the table to only return the required field into the array
        $student = DB::table('student')
            ->select('id','name','age')
            ->get();

        //chunk to query the table to segments the queried data
        //in this example the query will get every 2 records and return till it runs out
        //within the inside function can processing the data while its returns
        //use return false to stop the query
        //can use if statements to analysis the return data
        $student = DB::table('student')
            ->orderBy('id','desc')
            ->chunk(2,function ($students){
                var_dump($students);
                echo "<hr />";

            });


//        dd($student);

    }

    /**
     * aggregate function to query the data
     */
    public function query5(){
        //count function
        $res = DB::table('student')->count();
        $res = DB::table('student')->max('age');
        $res = DB::table('student')->min('age');
        $res = DB::table('student')->avg('age');
        $res = DB::table('student')->sum('sex');

        return $res;

    }

    /**
     * student Model testing
     */
    public function orm1(){
        //use orm to query

        //use all() to get all the data
        $students = Student::all();

        //use find to query according to pk
        $students = Student::find(2013);

        //use findorfail to query if there are no return data then error it up
//        $students = student::findOrFail(1006);

        //use query builder to query
        $students = Student::first();

        $students = Student::where('id','>',5)
        ->get();

        //use chunk
        $students = Student::chunk(2,function($students){
//           var_dump($students);
           echo "<hr />";
        });

        $students = Student::count();
        $students = Student::where('id','>',4)->sum('age');






        return $students;

    }

    /**
     * orm insert data with model and model create function
     */
    public function orm2(){
        /**
         * use model to insert data with save() function,
         * save() function return bool true/false
         */

        $student = new Student();
        $student->name  = "Ewan"; //assign value to object $student according to the table field
        $student->age   = 18; //assign value to object $student according to the table field
        $student->sex   = 1; //assign value to object $student according to the table field
        $student->save();//insert the data into table
        //with this method, the timestamp has been filled
        $abc = $student->find(1); //query the data
        $def = $student::find(1);//query the data
//        echo $abc->created_at; //show the selected filed or column
//        echo "<hr />";
//        echo $def->created_at;//show the selected filed or column
//        echo "<hr />";
//        echo $student->created_at;//show the selected filed or column


//        var_dump($student);
//        return $def;
//        return $abc;

        /**
         * use model create function to add data
         */
        Student::create(
          ['name'=>'imooc1','age'=>18,'sex'=>2]
        );

        /**
         * firstOrCreate() function
         * find the record, if the record is not existed,then create it
         * for this example, try to find name = 'imooc99', the imooc99 is not in the database
         * it create a new records of it
         * NOTE: if the fields does not have a default value, this will cause error when try to
         * insert the new records
         */
         $student = Student::firstOrCreate(
           ['name'=>'imooc99']
         );
//         return $student;

         /**
          * firstOrNew() function
          * use attribute to find record, if not exist
          * create new instance,
          * use save() to save if applicable
          */

         $student = Student::firstOrNew(
             ['name'=>'bo']
         );
         $student->save();//save the data into table
         return $student;


    }

    /**
     * update data by using model and query for batch update
     */
    public function orm3(){
        //using model to update data
        //eg.update record ID:12 imooc1
        //first step get the record
        $records = Student::find(12);
        $records->name="david-bosun";
        $records->save(); //return bool
        echo $records->name; //output the change

        /**
         * use query to do the batch update
         */
        $students = Student::where('id','>','3')
            ->update(
                [
                    'sex' => 1
                ]
            )
//            ->increment('age')
        ;

    }

    /**
     * delete records by
     * model, pk, defined condition
     */
    public function orm4(){
        /**
         * use model to delete
         */

//        $student = student::find(10)->delete(); //delete the records, return bool
        //if unable to delete e.g. the record doesn't exist, will lead to error
//        var_dump($student);


        /**
         * use PK to delete
         */
        echo Student::destroy(6,7,8,9);//use PK to delete,
        // return the number of rows been deleted
        //or use array to destroy
        echo Student::destroy([4,5]);
        //if the row doesn't exist, will not lead to error

        /**
         * use defined condition to delete
         */
        echo Student::where('id','>',3)->delete(); //return number of rows been deleted



    }

    /**
     *View Layout inherit
     */
    public function section1(){

        $name           = "David";
        $arr            = ['sean','imooc','jake'];
        $message        = "message for sub-view file";
        $students       = Student::get();
        $emptyArrays    = [];

        return view('student/section1',
            [
                'name'       => $name, //assign variable to the view
                'array'      => $arr,
                'message'    => $message, // this variable also can be assigned in the view file
                'students'   => $students,
                'emptyArrays'=> $emptyArrays
            ]);

    }

    /**
     * generate url in template view file
     */
    public function urlTest(){

         return "URLTEST";

    }


    /**
     * file upload testing
     */
    public function upload(Request $request){
        if($request->isMethod('POST')){
//            var_dump($_FILES);
            //get the uploaded file
            $file = $request->file('source');
            //source is the name of the form-control name

            //check if the upload is success
            if($file->isValid()){
                $originName = $file->getClientOriginalName();//get uploaded file org name
                $mime       = $file->getClientMimeType();//get uploaded file's mime
                $ext       = $file->getClientOriginalExtension();//get uploaded file's extension
                $realPath   = $file->getRealPath();//temp file absolute path

                //generate the new file name
                $fileName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;

                $bool = Storage::disk('uploads')->put($fileName,file_get_contents($realPath));

                dd($bool);


            }




            exit;
        }
        return view('student/upload');

    }


    /**
     * mailing funciton testing
     */
    public function mail(){
        /**
         * send raw mail
         */
//        Mail::raw('mainContent',function($message){
//            $message->from('m18736277539@163.com','imooc');
//            $message->subject('this is laravel mailing ');
//            $message->to('m18736277539@163.com');
//        });

        /**
         * send HTML mail
         * ['name']=>'whoisthis' is used for $name in  mail.blade.php
         */
        Mail::send('student/mail',['name'=>'whoisthis'],function($message){
            $message->from('m18736277539@163.com','imooc');
            $message->subject('this is laravel mailing ');
            $message->to('m18736277539@163.com');
        });

    }

    /**
     * cache testing
     * by using: put() add() forever() has() get() pull() forget()
     * put(key,value,expireTimeInt): set cache value, will rewrite if the key exist
     * add(key,value,expireTimeInt): set cache value return true,return false if key exist
     * forever():
     */
    //testing file cache1: used for add/set cache
    public function cacheFile1(){
        //use put() method to set key=key1,value=value1 for 10min?
        $a = Cache::put('key1','value1',10);

        $b= Cache::put('key1','value100',10);

        //use add() method to set/add key=key2,value=value2 for 10min,
        //**Note: add() if try to add value to existing key will cause failure return false

        $c = Cache::add('key1','value10',10);//return false as the key1 already exist
        $d = Cache::add('key2','value2',10);//return true as successed

        //use forever(): permanent store the cache
        $e = Cache::forever('key3','value3');





    }
    //testing file cache2: used for get cache value
    public function cacheFile2(){

        //use get(): to get cache value by defined key
        $val = Cache::get('key1');
        var_dump($val);

        //use has():check if the cache key exist
        if(Cache::has('key3')){
            $val = Cache::get('key3');
            var_dump($val);
        }else{
            echo "key3 cache not exist";
        }

        //use pull(): to get cache value by key AND destroy THE cache key
        $key3 = Cache::pull('key3');
        var_dump($key3);
        var_dump(Cache::get('key3'));

        //use forget(): delete cache by key return bool
        $bl = Cache::forget('key2');



    }

    //laravel DEBUG & log Testing
    public function error(){

        //create log
        Log::info('this is info level log');
        Log::warning('this is warning level log');

        //create log with array value
        log::error('this is array, ERROR level',['name'=>'bo','age'=>18]);






        //debug tesing1
        $student = null;
        if($student==null){
            abort('599','this is the log testing');
            //abort()will look to the resources/errors/code.blade.php to display,e.g. 503.balde.php
            //if the file doesn't exist, the system will display the system default page
            //NOTE: has to use the common code, can not create you own error code
        }


        //debug tesing2
//        $name = 'david';
        var_dump($name);
    }

    //queue testing
    //push the job into queue
    public function queue(){

        //to add the job into database, need to visit the page

        //push the job into queue on the database/jobs table
        dispatch(new sendEmail('m18736277539@163.com'));

        //to execute the job, use php artisan
//        php artisan queue:listen


    }

    //Controller study: request
    public function request1(Request $request){
        //get URL value
        //URL: http://lav.com/request1?name=sean

        //get URL name value
        echo $request->name;//output: sean

        //get value by key
        echo $request->input('name'); //output:sean

        //get the value by key and set default value iff the key is not exist
        echo $request->input('sex','default');
echo "<hr />";

        //use has(): to check if the value exist
        echo $request->has('name');//1
        echo $request->has('unknow');//empty
echo "<hr />";
        if($request->has('name13')){
            echo $request->name;
        }else{
            echo "not exist";
        }
echo "<hr />";
        //use all(): get all the parameters, return array
        $all = $request->all();
        var_dump($all);

        /**
         * check request type
         */
        echo $request->method();
echo "<hr />";
        //use isMethod(): to check if the method is pre-defined method
        if($request->isMethod('get')){//is the method is get/GET method
            echo "yes, it is get method";
        }else{
            echo "NOT GET MEthod";
        }

        //ajax(): check if is ajax request
        $ajax = $request->ajax();//return bool

        //is(): to check the request path fullfill the router rule
        // return bool
        $is = $request->is('student/*');
        //Route::any('request1','studentController@request1'); return FALSE
        //Route::any('request1','studentController@request1'); return TRUE
echo "<hr />";
        //get current URL
        echo $request->url();







    }

    //Controller study: session1
    //set session
    public  function session1(Request $request){
        /**1.
         * HTTP request session(); method
         */

        //put('key','value'): to set session value
        $request->session()->put('key1','value1');

        /**2.
         * session(): helper method
         */
        session()->put('key2','value2');

        /**3.
         * use session class to create session
         */
        Session::put('key3','value3');

        //put array into session
        Session::put(['key4'=>'value4','key5'=>['a','b','c']]);

        //push value into session_array
        Session::push('k1','v1');
        Session::push('k1','v2');

        //forget(): remove one key from session
        Session::forget('key5');

        //flush(): empty session
        Session::flush();

        //flash(): only exist to the first visit,
        //after the first read/visit, it will be destroyed
        Session::flash('key7','key7');



    }

    //Controller study: session2
    //get session
    public function session2(Request $request){

        //get('key'): get session value by key
        echo $request->session()->get('key1');
        echo "<hr />";
        //use helper method to get value
        echo session()->get('key2');
        //use Session class
        echo "<hr />";
        echo Session::get('key3');

        //use Session class with default value if session not exist
        echo "<hr />";
        echo Session::get('key4','default_value4');

        //get key4, key5
        echo Session::get('key4');
        var_dump(Session::get('key5'));

        //get session_array
        var_dump(Session::get('k1'));

        //get session value then delete, also can set default value if not exist
        var_dump(Session::pull('k1','default_value'));

        //get all the values in session
        var_dump(Session::all());
echo "<hr />";
        //has(): use has to check if the key-value exist
        if(Session::has('key5')){
            var_dump(Session::get('key5'));
        }else{
            echo "NOT KEY5 NO";
        }

        //get flash session key7
        var_dump(Session::get('key7'));


    }

    //Controller study: response
    //response Type: string, view, json, redirect

    public function response(){

        //Type:json
        $data = [
            'errCode'   => 0,
            'errMsg'    => 'success',
            'data'      => 'sean',
        ];
        //convert $data into json string
//        return response()->json($data);

        //Type: redirect
//        return redirect('session2');
        //redirect with data
//        return redirect('session2')->with('message','this is the message');
        //NOTE::message will be stored in session with key: message
        //NOTE:: this session['message'] is a flash session, only show once

        //use action() to redirect, also can with flash message
//        return redirect()->action('studentController@session2')->with('flash-message','this is flash-message with action function');

        //use route() to redirect
//        return redirect()->route('jump')->with('route','this is route flash message');

        //back to previous page
        return redirect()->back()->with('back','this is back flash message');

    }

    //Controller study: middleware
    /**
     * scenario :
     * there is a activity only begins on the center date, before the date,
     * before the activity begins, all the visits will be redirected to the promo page
     *
     * to perform this scenario will needs following skills
     * create middleware
     * register middleware
     * use middleware
     * pre/post use middleware
     */

    //promo page of the activity
    public function activity0(){
//        echo date("Y-m-d",time());//2018-06-26
        return "the promo is about to begin";
    }

    public function activity1(){
        return "activity is under going";
    }

    public function activity2(){
        return "thanks for been involved";
    }

    public function activity3(){
        return "activity has successfully finished";
    }

    /**
     * FORM TESTING
     */

    //student list page
    public function index(){
        //get data from database
//        $students = Student::get();

        //use paginate() for paging
        $students = Student::paginate(2);

//        dd($students);//NOTE students is an object of student model class


        return view('student/index',
            [
             'students'  =>  $students,


            ]
        );
    }

    //display create page
    public function create(Request $request){
        if($request->isMethod('GET')){

            return view('student/create',
                ['students'=>new Student()] //put Student Object into template variable(object) student
            );

        }elseif ($request->isMethod('POST')){
            //get form submit value
            $data = $request->input('student');

            //USE CONTROLLER TO VALIDATE THE INPUT
            //as in the form is student[name] array, so here is student.name
            //if in the form is name, then here is name
            //unique:tableName,tableColumn
            //NOTE: with controller, once the template has set the old() value, don't need to
//            $this->validate($request,[
//                'student.name'      =>  'required|between:5,10|unique:students,name',
//                'student.age'      =>  'required|integer|between:18,100',
//                'student.sex'      =>  'required|max:3',
//                'test'             =>   'required|max:3',
//            ],[
//                'required'      => ':attribute 为必填项', //:attribute is the placeholder
//                'min'           => ':attribute 最少为:min',
//                'max'           => ':attribute 最多为:max',
//                'integer'       => ':attribute 必须为整数',
//                'between'       => ':attribute 在:min与:max之间',
//            ],[
//                'student.name' => '姓名',
//                'student.age' => '年龄',
//                'student.sex' => '性别',
//                'test'        => '测试',
//
//            ]);

            /**
             * for the validator
             * if data pass the valid, the code will continue to run
             * if it falls, the laravel framework will throw an exception
             * the exception will be auto-capture and represent on the last page
             */


            //USE VALIDATOR CLASS TO VALIDATE INPUT
            //create the my_validator
            //unique:tableName,tableColumn

            $my_validator = Validator::make($request->input(),
                [//rules
                    'student.name'      =>  'required|between:5,10|unique:students,name',
                    'student.age'       =>  'required|integer|between:18,100',
                    'student.sex'       =>  'required|integer|between:0,3',
                    'test'              =>  'required',
                ],
                [//rule explain
                    'required'      =>  ':attribute 必填',
                    'between'       =>  ':attribute 的值必须在:min ~ :max之间',
                    'integer'       =>  ':attribute 的值必须为整数',
                ],
                [//variable explain
                    'student.name'      =>  '学生姓名',
                    'student.age'       =>  '学生年龄',
                    'student.sex'       =>  '学生性别',
                    'test'              =>  '测试',

                ]
            );

            if($my_validator->fails()){
                //validate fails
                //back to previous page with errors
                //withInput(): keep the user input data
                return redirect()->back()->withErrors($my_validator)->withInput();
            }




            if(Student::create($data)!==false){
                //data create success
                return redirect('index')->with('message','success');
            }else{
                return redirect()->back()->with('message','failed');//redirect to the previous page
            }

        }

    }

    //processing create student form submition
    public function create_submit(Request $request){
      //only processing POST request
        if($request->isMethod('POST')){

            //get post form data
            $input = $request->input('student');

            var_dump($input);

            //insert data into database

            Student::create($input);



        }else{
            return view('student/create');
        }


    }


    //display & processing edit student info

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request,$id=null){
        if($request->isMethod('post')){




            //processing editing
            $v = $this->validate($request,
                [//rules
                    'student.name'      =>  'required|unique:students,name,'.$id.',id|between:3,10',
                    'student.age'       =>  'required|between:18,99|integer',
                    'student.sex'       =>  'required',

                ],
                [//explain rules to front user
                    'required'      =>  ':attribute must fill in',
                    'unique'        =>  ':attribute already has been taken, please choose another :attribute',
                    'between'       =>  'the :attribute must between :min and :max',
                    'integer'       =>  ':attribute must fillin with integer',

                ],
                [//translate variable name into human understanding name
                    'student.name'  =>  'Student Name',
                    'student.age'   =>  'Student Age',
                    'student.sex'   =>  'Student Gender',


                ]);
            $postData = $request->post('student');

            $update = Student::where('id','=',$id)
            ->update($postData);
            if($update){
                return redirect('index')->with('message','success');
            }







        }elseif($request->isMethod('get')){
            //display edit page
            if(isset($id) && $id !==null){
                //get student
                $student = Student::find($id);

                return view('student/edit',
                    [
                        'student' =>$student,

                    ]
                );
            }

        }

    }

    //del function
    public function del($id=null){
        if(Student::destroy($id)){
            return redirect('index')->with('message','success');
        }else{
            return redirect()->back()->with('message','failed');
        }
    }

    //show details of student
    public function details($id=null){
       //get student info by $id
        $student = Student::find($id);
        return view('student/details',
            [
                'student'=>$student,

            ]
        );
    }



}
