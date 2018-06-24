<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    //
    public function info($id=null){

        //use member Model
        return Member::getMember();

//        return "member info";
//        return route('memberinfo');
//          return 'member-info-id-'.$id;
          return view('member/member-info',[
              'name'    =>  'david',
              'age'     =>  '18'
          ]);
    }
}
