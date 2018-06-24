<?php

namespace App\Http\Controllers;

use App\Model\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        echo Student::destroy(6,7,8,9);//use PK to delete, return the number of rows been deleted
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

}
