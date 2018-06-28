<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //bind table
    protected $table = 'students';
    //bind pk
    protected $primaryKey = 'id';
    //weather fillin the timestamps when add the data, default true
    public $timestamps = true;
    //set allowed fields to  batch data input e.g. create()
    protected $fillable = ['name','age','sex'];
    //set fields not allowed for batch data input
    protected $guarded = ['sex']; //when set sex is not allowed for data batch input,
    // then the value will be ignored and use the field default value

    //use model to processing data
    const SEX_UNKNOW = 3;
    const  SEX_MALE = 1;
    const SEX_FEMALE = 0;

    //processing sex data
    public function sex($ind=null){
        $arr = [
            self::SEX_UNKNOW => '未知',
            self::SEX_MALE =>'男',
            self::SEX_FEMALE => '女',
        ];


        if($ind !==null){
            return array_key_exists($ind,$arr)?$arr[$ind]:$arr[self::SEX_UN];
        }

        return $arr;
    }


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
