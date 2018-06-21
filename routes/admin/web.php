<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/21 0021
 * Time: 22:15
 */
/**
 * 针对后台的路由
 */
Route::get('bc',function(){

    return 'hdphp';
}
);
Route::group(['prefix'=>'admin'],function(){

     Route::get('abc',function(){
         return "HDCMS";
     });
});