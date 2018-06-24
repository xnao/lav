<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //bind table
    protected $table = 'student';
    //bind pk
    protected $primaryKey = 'id';
    //weather fillin the timestamps when add the data, default true
    public $timestamps = true;
    //set allowed fields to  batch data input
    protected $fillable = ['name','age'];
    //set fields not allowed for batch data input
    protected $guarded = ['sex']; //when set sex is not allowed for data batch input, then the value will be ignored and use the field default value



    /**
     * if want to use UNIX_TIMESTAMP, please unmark the following two function
     * public function getDateFormat() / protected function asDateTime()
     */


    /**
     * @return int|string set the timestamps in unix_timestamp format: int(11)
     * default is timestamp
     * has to be public ....or ....as shown on the tutorial video: protected
     */
//    public  function  getDateFormat(){
//        return time();
//    }

    /**
     * @param mixed $value
     * @return \Illuminate\Support\Carbon|mixed
     * return the unix_timestamp unformated
     */
//    protected  function asDateTime($value)
//    {
//        return $value;
//    }

}
