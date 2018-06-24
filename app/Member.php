<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    public static function getMember()
    {
        return "The member name is David";
    }
}
