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
//ch06練習一(3): 修改根路由'/'，使之可執行HomeController的indexc函數
Route::get('/', 'HomeController@indexc');

/*
//練習一: 顯示學生的資料與成績
Route::get('student/{student_no}',function ($student_no){
    return '學號：'.$student_no;
});
Route::get('student/{student_no}/score',function ($student_no){
    return '學號：'.$student_no.'的所有成績';
});
*/
/*
//練習二: 提供學生查詢自己的成績
Route::get('student/{student_no}/score/{subject}', function ($student_no,$subject){
    return '學號：'.$student_no.'的'.$subject.'成績';
});
*/
/*
//練習三: 提供學生查詢所有科目或特定科目的成績
Route::get('student/{student_no}/score/{subject?}', function ($student_no,$subject=null){
    return '學號：'.$student_no.'的'.((is_null($subject))?'所有科目':$subject).'成績';
});
*/

/*
//練習四: 正規表達式限制參數
Route::get('student/{student_no}',function ($student_no){
    return '學號：'.$student_no;
}) -> where(['student_no' => 's[0-9]{10}']);
Route::get('student/{student_no}/score/{subject?}', function ($student_no,$subject=null){
    return '學號：'.$student_no.'的'.((is_null($subject))?'所有科目':$subject).'成績';
}) -> where(['student_no' => 's[0-9]{10}','subject' => '(chinese|english|math)']);
*/
/*
//練習五: 用Route的param方法替常用的參數統一限制(可將學號統一進行格式設定，以方便維護路由)
Route::pattern('student_no','s[0-9]{10}');
Route::get('student/{student_no}',function ($student_no){
    return '學號：'.$student_no;
});
Route::get('student/{student_no}/score/{subject?}', function ($student_no,$subject=null){
    return '學號：'.$student_no.'的'.((is_null($subject))?'所有科目':$subject).'成績';
}) -> where(['subject' => '(chinese|english|math)']);
*/
/*
//練習六: 路由群組->透過prefix前綴，將網址前套上student
Route::pattern('student_no','s[0-9]{10}');
Route::group(['prefix' => 'student'],function(){
    Route::get('{student_no}', function ($student_no) {
        return '學號：' . $student_no;
    });
    Route::get('{student_no}/score/{subject?}', function ($student_no, $subject = null) {
        return '學號：' . $student_no . '的' . ((is_null($subject)) ? '所有科目' : $subject) . '成績';
    })->where(['subject' => '(chinese | english | math)']);
});
*/
//練習七: 路由命名
Route::pattern('student_no','s[0-9]{10}');
Route::group(['prefix' => 'student'],function(){
    /*
    Route::get('{student_no}', ['as' => 'student', 'uses' => function ($student_no) {
        return '學號：' . $student_no;
    }
    ]);
    Route::get('{student_no}/score/{subject?}',['as' => 'student.score',
        'uses' => function ($student_no, $subject = null) {
            return '學號：' . $student_no . '的' . ((is_null($subject)) ? '所有科目' : $subject) . '成績';
        }])->where(['subject' => '(chinese | english | math)']);
    */

    //ch06練習二(3): 修改路由，使之可執行StudentController內的getStudentData及getStudentScore函數
    Route::get('{student_no}',['as' => 'student', 'uses' => 'StudentController@getStudentData']);
    Route::get('{student_no}/score/{subject?}',['as' => 'student.score',
        'uses' => 'StudentController@getStudentScore'])->where(['subject' => '(chinese|english|math)']);
});

//ch06練習三(3) : 新增路由'cool'
//Route::get('cool', 'Cool\TestController@indexc');

//ch06練習三(4) : 修改路由'cool'，使之加入namespace路由'Cool'當中
Route::group(['namespace' => 'Cool'],function (){
    Route::get('cool', 'TestController@indexc');
});

//ch07練習二-3 : 增加路由'/board'，使之可執行BoardController的getIndex方法
Route::get('/board', 'BoardController@getIndex');