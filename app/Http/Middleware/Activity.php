<?php

namespace App\Http\Middleware;

use Closure;

class Activity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)//this is pre middleware
    {
        //logic code proformed before reponse($next($request)) is pre middleware

        //CONTROLLER - MIDDLEWARE study
        //code for scenario
        $date = strtotime('2018-06-26');
        if($date<=strtotime('2018-06-25')){
            return redirect('activity0');
        }elseif ($date>=strtotime('2018-06-27')){
            return redirect('activity3');
        }else{
            return redirect('activity1');
        }

        return $next($request);
    }


    //there are some problems with this
//    public function handle($request, Closure $next)//this is post middleware
//    {
//        //logic code performed after middleware is post middleware
//
//        $response = $next($request);
//        echo $response;
//        echo "this is post middleware";
//    }
}
