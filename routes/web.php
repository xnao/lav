<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/**
 * get request route example
 */
Route::get('basic1',function(){
    return "HELLO WORLD";
});
/**
 * post route example
 */
Route::post('basic2',function(){
    return "Hello world2";
});

/**
 * mulity-route example
 */
Route::match(['get','post'],'mulity1',function(){
    echo "Mulity route test";
});

/**
 * any route for any request
 */

Route::any('any',function(){
    return "ANY ROUTE TEST";
});

/**
 * Route parameters
 */

//Route::get('user/{id}',function($id){
//    return "user id is ".$id;
//});

/**
 * set default value for the name
 * ? stand for optional
 */
//Route::get('user/{name?}',function($name = 'sean'){
//    return "user name is ".$name;
//});

/**
 * set reg to filter the result to decided is id or name
 * where is the validate rule to filter the url parameters
 *
 */
//Route::get('user/{name?}',function($name = "david"){
//    return "user name is for: ".$name;
//})->where('name','[A-Za-z]+');

/**
 * for multiple validate conditions
 * the validate rule states the only url fits the validate is
 * user/1234567890/abcz
 * other formats of the url will lead to error
 */
//Route::get('user/{id}/{name?}',function($id,$name='david'){
//    return "user id is : ".$id." user name is ".$name;
//})->where(['id'=>'[0-9]+', 'name'=>'[A-Za-z]+']);

/**
 * Route alias
 * use Route alias to auto-change the url when the url is changed
 */
Route::get('user/member-center',['as'=>'center',function(){
//    return "member-center"; //out member-center
    return route('center');//out: http://lav.com/user/member-center
}]);

/**
 * route Group
 * 1.add prefix
 */

Route::group(['prefix' => 'member'],function(){
    //visit http://lav.com/member/multy2 to access
   Route::get('user/center',function(){
       return "user Center";
   });

   //visit http://lav.com/member/user/center to access
   Route::get('multy2',function(){
      return "Multiple 2";
   });
});

/**
 * route output view
 */

Route::get('view',function(){
    return view("welcome");
});

/**
 * add controller to the response the url
 */
//method 1: add memberController info function to the response the member/info url
//Route::get('member/info', 'MemberController@info');

//method 2: add memberController info function to the response the member/info url
//Route::get('member/info1',['uses'=>'MemberController@info']);

//method 3: use route alias
//Route::any('member/info',[
//    'uses' => 'MemberController@info',
//    'as'   => 'memberinfo'
//]);

//method 4: bind parameters and validater
Route::any('member/info/{id?}',"MemberController@info")
    ->where(['id'=>'[0-9]+']);

/*************************************************************/
Route::any('test1',['uses'=>'StudentController@test1']);
Route::any('query1',"StudentController@query1");
Route::any('query2','StudentController@query2');
Route::any('query3','StudentController@query3');
Route::any('query4','StudentController@query4');
Route::get('query5','studentcontroller@query5');


/*******************orm testing********************/
Route::any('orm1',['uses'=>'StudentController@orm1']);
Route::get('orm2',['uses'=>'studentcontroller@orm2']);
Route::get('orm3',['uses'=>'studentController@orm3']);
Route::get('orm4','studentController@orm4');

/********************VIEW LAYOUT TESTING**************/
Route::get('section1',['uses'=>'studentcontroller@section1']);
Route::any('urlTest',['as'=>'urlAlias','uses'=>'studentController@urlTest']);



include  __DIR__.'/admin/web.php';//包含admin的路由
