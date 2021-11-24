<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/custom/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/custom/register', [\App\Http\Controllers\Auth\LoginController::class, 'register']);
Route::get('/custom/info', [\App\Http\Controllers\Auth\LoginController::class, 'info'])->middleware('auth:api');

Route::get('/', function () {

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::any('/request', function (\Illuminate\Http\Request $request) {
    $a = $request->input('a', '');
    echo $a; // 1
    \Illuminate\Support\Facades\Log::info('ping this');
    return $a; // 1
});

Route::get('/get/request', function () {
    return 'get';
});

Route::post('/post/request', function () {
    return 'post';
});

Route::get('/put/request', function () {
    return 'put';
});

Route::any('/any/request', function () {
    return 'any';
});

Route::match(['get', 'post'], '/match/request', function () {
    return 'match get or post';
});

Route::get('/get/request/{id}/{name?}', function ($id, $name = '') {
    return 'get:' . $id . ', ' . $name;
})->name('get/request/params')->where(['id' => '[0-9]+', 'name' => '[a-z]+']);

Route::get('/jump', function () {
    $url = route('get/request/params', ['id' => 2, 'name' => 'b']);
    echo $url; // http://laravel8/get/request/2/b
    return redirect()->route('get/request/params', ['id' => 2, 'name' => 'b']);
});

Route::group(['prefix' => 'temp'], function () {
    Route::get('/', function () {
        return '根列表';
    });
    Route::get('/{id}', function ($id) {
        return '详情页，id：' . $id;
    });
    Route::post('/insert', function () {
        return '添加';
    });
    Route::put('/edit', function () {
        return '修改';
    });
    Route::delete('/delete', function () {
        return '删除';
    });
});

Route::get('route/test/{id}', 'App\Http\Controllers\RouteController@test');
Route::get('route/t/{id}', 'App\Http\Controllers\RouteController@test');
Route::get('route/tt/{id}', [\App\Http\Controllers\RouteController::class, 'test']);

Route::get('route/user/{user}', function (\App\Models\User $user) {
    return $user->name;
});

Route::get('test/test', 'App\Http\Controllers\TestController@test');
Route::get('test2/test', 'App\Http\Controllers\Test2Controller');

Route::get('test/test2/{id}', 'App\Http\Controllers\TestController@test2');

Route::resource('test/resource', 'App\Http\Controllers\ResourceTestController');

Route::get('validate/create', 'App\Http\Controllers\ValidateController@create');
Route::post('validate/store', 'App\Http\Controllers\ValidateController@store');
Route::post('validate/store2', 'App\Http\Controllers\ValidateController@store2');

//Route::get('middleware/test', 'App\Http\Controllers\MiddlewareTestController@test')->middleware(\App\Http\Middleware\MiddlewareTest::class);
Route::get('middleware/test', 'App\Http\Controllers\MiddlewareTestController@test')->middleware('middlewaretest');
Route::get('middleware/noroute/test', 'App\Http\Controllers\MiddlewareTestController@test');
Route::get('middleware/noroute/test2', 'App\Http\Controllers\MiddlewareTestController@test2');


Route::get('rawdb/test/insert', function () {
    $data = [
        'Peter' => 1,
        'Tom'   => 1,
        'Susan' => 2,
        'Mary'  => 2,
        'Jim'   => 1,
    ];
    foreach ($data as $k => $v) {
        \Illuminate\Support\Facades\DB::insert('insert into raw_test (name, sex) values (?, ?)', [$k, $v]);
        $insertId = DB::getPdo()->lastInsertId();
        echo $insertId, '<br/>';
    }
});

Route::get('rawdb/test/update', function () {
    $data = [
        'name' => request()->name,
        'sex' => request()->sex,
        'id' => request()->id
    ];

    if($data['id'] < 1 || !$data['name'] || !in_array($data['sex'], [1, 2])){
        echo '参数错误';
    }

    \Illuminate\Support\Facades\DB::update('update raw_test set name=:name,sex =:sex where id = :id', $data);

    echo '修改成功';
});

Route::get('rawdb/test/delete', function () {

    $id = request()->id;
    if($id < 1){
        echo '参数错误';
    }

    \Illuminate\Support\Facades\DB::delete('delete from raw_test where id = :id', ['id'=>$id]);

    echo '删除成功';
});

Route::get('rawdb/test/delete2', function () {

    $id = request()->id;
    if($id < 1){
        echo '参数错误';
    }

    \Illuminate\Support\Facades\DB::insert('delete from raw_test where id = :id', ['id'=>$id]);

    echo '删除成功';
});

Route::get('rawdb/test/show', function () {
    dd(\Illuminate\Support\Facades\DB::select("select * from raw_test"));
});

Route::get('rawdb/laravel8/test', function () {
    \Illuminate\Support\Facades\DB::connection('laravel8')->insert('insert into raw_test (name, sex) values (?, ?)', ['Sam', 1]);
    dd(\Illuminate\Support\Facades\DB::connection('laravel8')->select("select * from raw_test"));
});


Route::get('db/test/insert', function () {
    $data = [
        [
            'name'=>'Peter',
            'sex' => 1,
        ],
        [
            'name'=>'Tom',
            'sex' => 1,
        ],
        [
            'name'=>'Susan',
            'sex' => 2,
        ],
        [
            'name'=>'Mary',
            'sex' => 2,
        ],
        [
            'name'=>'Jim',
            'sex' => 1,
        ],
    ];
    foreach ($data as $v) {
        $insertId = \Illuminate\Support\Facades\DB::table('db_test')->insertGetId($v);
        echo $insertId, '<br/>';
    }
});

Route::get('db/test/update', function () {
    $data = [
        'name' => request()->name,
        'sex' => request()->sex,
        'id' => request()->id
    ];

    if($data['id'] < 1 || !$data['name'] || !in_array($data['sex'], [1, 2])){
        echo '参数错误';
    }

    \Illuminate\Support\Facades\DB::table('db_test')->where('id', '=', $data['id'])->update($data);

    echo '修改成功';
});

Route::get('db/test/delete', function () {

    $id = request()->id;
    if($id < 1){
        echo '参数错误';
    }

    \Illuminate\Support\Facades\DB::table('db_test')->delete($id);

    echo '删除成功';
});


Route::get('db/test/list', function () {
    $where = [];
    if(request()->name){
        $where[] = ['name', 'like', '%' . request()->name . '%'];
    }
    if(request()->sex){
        $where[] = ['sex', '=', request()->sex];
    }

    $list = \Illuminate\Support\Facades\DB::table('db_test')
        ->select(['*'])
        ->where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->get()
        ->toArray();

    \Illuminate\Support\Facades\DB::table('db_test')
        ->select(['*'])
        ->where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->dump();
    // select * from `db_test` where (`name` like ?) order by `id` desc limit 10 offset 0

    dd($list);
});

Route::get('db/test/info', function () {
    $id = (int)request()->get('id', 0);

    $info = \Illuminate\Support\Facades\DB::table('db_test')->find($id);

    dd($info);
});

Route::get('db/test/batch/insert', function () {
    $data = [
        [
            'name'=>'Peter',
            'sex' => 1,
        ],
        [
            'name'=>'Tom',
            'sex' => 1,
        ],
        [
            'name'=>'Susan',
            'sex' => 2,
        ],
        [
            'name'=>'Mary',
            'sex' => 2,
        ],
        [
            'name'=>'Jim',
            'sex' => 1,
        ],
    ];
    dd(\Illuminate\Support\Facades\DB::table('db_test')->insert($data));
});

Route::get('db/test/join', function () {
    \Illuminate\Support\Facades\DB::table('db_test', 't')->leftJoin('db_sex as s', 't.sex', '=', 's.id')->dump();
    // "select * from `db_test` as `t` left join `db_sex` as `s` on `t`.`sex` = `s`.`id`"

    \Illuminate\Support\Facades\DB::table('db_test', 't')->leftJoin('raw_test as rt', function($j){
        $j->on('t.name', '=', 'rt.name')->on('t.sex', '=', 'rt.sex');
//        $j->on('t.name', '=', 'rt.name')->orOn('t.sex', '=', 'rt.sex')->where('t.id', '<', 10);
    })->dump();
    // select * from `db_test` as `t` left join `raw_test` as `rt` on `t`.`name` = `rt`.`name` and `t`.`sex` = `rt`.`sex`

    // select * from `db_test` as `t` left join `raw_test` as `rt` on `t`.`name` = `rt`.`name` or `t`.`sex` = `rt`.`sex` and `id` < ?
//    array:1 [
//      0 => 10
//    ]
});


Route::get('model/test/insert', function () {
    $data = [
        [
            'name'=>'Peter',
            'sex' => 1,
        ],
        [
            'name'=>'Tom',
            'sex' => 1,
        ],
        [
            'name'=>'Susan',
            'sex' => 2,
        ],
        [
            'name'=>'Mary',
            'sex' => 2,
        ],
        [
            'name'=>'Jim',
            'sex' => 1,
        ],
    ];
    foreach ($data as $v) {
        $model = new \App\Models\MTest();
        $model->name = $v['name'];
        $model->sex = $v['sex'];

        $insertId = $model->newQuery()->insertGetId($v);
//        $insertId = $model->id;
//        $insertId = \App\Models\MTest::insertGetId($v);

        echo $insertId, '<br/>';
    }
});

Route::get('model/test/update', function () {
    $data = [
        'name' => request()->name,
        'sex' => request()->sex,
        'id' => request()->id
    ];

    if($data['id'] < 1 || !$data['name'] || !in_array($data['sex'], [1, 2])){
        echo '参数错误';
    }

    $model = \App\Models\MTest::find($data['id']);
    $model->name = $data['name'];
    $model->sex = $data['sex'];
    $model->update();

    echo '修改成功';
});

Route::get('model/test/delete', function () {

    $id = request()->id;
    if($id < 1){
        echo '参数错误';
    }

    \App\Models\MTest::destroy($id);

    echo '删除成功';
});

Route::get('model/test/list', function () {
    $where = [];
    if(request()->name){
        $where[] = ['name', 'like', '%' . request()->name . '%'];
    }
    if(request()->sex){
        $where[] = ['sex', '=', request()->sex];
    }

    $list = \App\Models\MTest::where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->get()->toArray();

    dd($list);
});

Route::get('model/test/info', function () {
    $id = (int)request()->get('id', 0);

    $info = \App\Models\MTest::find($id);

    dd($info);
});

Route::get('model/test/relationship', function () {
    $id = (int)request()->get('id', 0);

    $info = \App\Models\MTest::find($id);
    dump($info);
    dump($info->gender);
    dump($info->gender->name); // 女
});

Route::get('model/test/collection', function () {
    $where = [];
    if(request()->name){
        $where[] = ['name', 'like', '%' . request()->name . '%'];
    }
    if(request()->sex){
        $where[] = ['sex', '=', request()->sex];
    }

    $list = \App\Models\MTest::where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->get()
        ->pluck('name', 'id')
        ->toArray();
    print_r($list);
//    Array
//    (
//        [20] => Jim
//        [19] => Mary
//        [18] => Susan
//        [17] => Tom
//        [16] => Peter
//        [15] => Jim
//        [14] => Mary
//        [13] => Susan
//        [12] => Tom
//        [11] => Peter
//    )

    $list = \App\Models\MTest::where($where)
        ->orderBy('id', 'desc')
        ->limit(10)
        ->offset(0)
        ->get()
        ->map(function($item){ return $item->attributesToArray();})
        ->toArray();
    print_r($list);
//    Array
//    (
//        [0] => Array
//        (
//            [id] => 20
//            [name] => Jim
//            [sex] => 1
//        )
//        [1] => Array
//        (
//            [id] => 19
//            [name] => Mary
//            [sex] => 2
//        )
//         ………………
//         ………………
//         ………………
//    )

//    dd($list);
});


Route::get('model/test/bindroute/{mTest}', function(\App\Models\MTest $mTest){
    dump($mTest);
    dump($mTest->name);
});

Route::get('model/test/bindroute/controller/{mTest}', [\App\Http\Controllers\MTestController::class, 'show']);

Route::get('model/test/ser/array', function(){
    $mTest = \App\Models\MTest::find(1);
    dump($mTest->toArray());
    dump($mTest->attributesToArray());
});

Route::get('model/test/ser/json', function(){
    $mTest = \App\Models\MTest::find(1);
    dump($mTest->toJson());
    dump($mTest->toJson(JSON_PRETTY_PRINT));
});

Route::get('ms/test/insert', function(){
    \Illuminate\Support\Facades\DB::connection('mysql2')->table('db_test')->insert(['name'=>'Lily', 'sex'=>2]);
    dd( \Illuminate\Support\Facades\DB::connection('mysql2')->table('db_test')->get()->toArray());
});

Route::get('ms/test/list', function(){
    dd( \Illuminate\Support\Facades\DB::connection('mysql2')->table('db_test')->get());
});

Route::get('db/tran/insert', function(){
    \Illuminate\Support\Facades\DB::beginTransaction();
    try {
        \Illuminate\Support\Facades\DB::table('db_test')->insert(['name' => 'Lily', 'sex' => 2]);
        \Illuminate\Support\Facades\DB::table('db_test_no')->insert(['name' => 'Lily', 'sex' => 2]);
        \Illuminate\Support\Facades\DB::commit();
    }catch(Exception $e){
        \Illuminate\Support\Facades\DB::rollBack();
        dd($e->getMessage());
    }
});

Route::get('db/collection/list', function(){
    dump( \Illuminate\Support\Facades\DB::connection('mysql3')->table('db_test')->get()->toArray());
    dump(\Illuminate\Support\Facades\DB::connection('mysql3')->getPdo());
//    attributes: {
//      CASE: NATURAL
//      ERRMODE: EXCEPTION
//      AUTOCOMMIT: 1
//      PERSISTENT: false
//      DRIVER_NAME: "mysql"
//      SERVER_INFO: "Uptime: 266035  Threads: 5  Questions: 635  Slow queries: 0  Opens: 251  Flush tables: 3  Open tables: 191  Queries per second avg: 0.002"
//      ORACLE_NULLS: NATURAL
//      CLIENT_VERSION: "mysqlnd 5.0.12-dev - 20150407 - $Id: 7cc7cc96e675f6d72e5cf0f267f48e167c2abb23 $"
//      SERVER_VERSION: "8.0.17"
//      EMULATE_PREPARES: 0
//      CONNECTION_STATUS: "127.0.0.1 via TCP/IP"
//      DEFAULT_FETCH_MODE: ASSOC
//    }
    dump( \Illuminate\Support\Facades\DB::connection('mysql')->table('db_test')->get()->toArray());
});

Route::get('redis/set', function(){
    \Illuminate\Support\Facades\Redis::connection('default')->client()->set('test', 1);
});

Route::get('redis/get', function(){
    echo \Illuminate\Support\Facades\Redis::connection('default')->client()->get('test');
});

Route::get('redis/lpush', function(){
    \Illuminate\Support\Facades\Redis::connection('default')->client()->rpush('LeftQueue', date('Y-m-d H:i:s'));
});

Route::get('redis/lpop', function(){
    echo \Illuminate\Support\Facades\Redis::connection('default')->client()->lpop('LeftQueue');
});

Route::get('cache/default/set', function(){
    \Illuminate\Support\Facades\Cache::set('a', '1');
});
Route::get('cache/default/get', function(){
    echo \Illuminate\Support\Facades\Cache::get('a');
});

Route::get('cache/redis/set', function(){
    \Illuminate\Support\Facades\Cache::set('a', '1');
});
Route::get('cache/redis/get', function(){
    dump(\Illuminate\Support\Facades\Cache::get('a'));

    dump(\Illuminate\Support\Facades\Redis::connection('default')->client()->get('a'));
    dump(\Illuminate\Support\Facades\Redis::connection('cache')->client()->get('laravel_cache:a'));
});

Route::get('cache/store/set', function(){
    \Illuminate\Support\Facades\Cache::store('file')->set('a', '1');
    \Illuminate\Support\Facades\Cache::store('redis')->set('a', '2');
});
Route::get('cache/store/get', function(){
    dump(\Illuminate\Support\Facades\Cache::store('file')->get('a')); // 1
    dump(\Illuminate\Support\Facades\Cache::store('redis')->get('a')); // 2
});

Route::get('blade/test', function(){
    $title = '测试文章';

    $content = <<<EOF
<div>
<p>
　　“半决赛就是我的决赛。”中国男子短跑名将苏炳添在东京奥运会男子100米预赛结束后曾这样说。昨日站上半决赛的赛场，苏炳添也的确拼出了全力，并以9.83秒的成绩刷新亚洲纪录，排名半决赛首位成功闯入决赛。决赛场，第一次有中国选手站上奥运会男子100米决赛的跑道。苏炳添最终以9.98秒的成绩获得第六名，创造了中国田径新的历史。赛后他身披国旗，十分激动地说：“我完成了自己的梦想！”</p>

<p>
　　苏炳添8月29日就将迎来自己32岁的生日，虽然去年一度受到伤病的困扰，但他还是逐步恢复状态，在今年初再度跑进10秒之内。出战东京奥运会，苏炳添的第一个目标就是站上男子100米决赛跑道，因此他在昨日傍晚的半决赛中也拼出了全力。9.83秒的成绩不仅让他稳稳进入决赛，也创造了黄种人跑进9.9秒的新纪录。两小时之后，苏炳添站在了奥运会男子飞人决赛的跑道上。或许是半决赛拼得太凶，或许是被决赛中英国选手抢跑打乱了节奏，苏炳添的起跑反应时并不理想，最终以9.98秒的成绩获得第六名。但这依然书写了属于他、属于中国田径的崭新历史。</p>

<p>
　　完成决赛，苏炳添身披国旗在东京新国立竞技场内享受着属于自己的荣耀时刻。他说：“对我来说，通过这么多年的努力，终于可以站在奥运会100米决赛的跑道上，我完成了自己的梦想，也实现了中国田径历代前辈对我们的期待与祝福。半决赛到决赛这么短时间还能突破10秒，我已经非常开心了，达到了我自己的目标，这将是我一辈子最好的回忆。我拿到了奥运会第六名，我希望以此给予年轻运动员一个非常大的鼓励。比赛成绩应该说没有让大家失望，我也希望在几天后的接力比赛中继续展现中国速度。”</p>
</div>
EOF;

    $menu = ["首页", "文章", "视频", "评论", "留言", "关于"];


    return view('Blade.test', [
        'title' => $title,
        'content' => $content,
        'menu'=>$menu
    ]);
});


Route::get('blade/test2', function(){
    $title = '测试文章2';

    $content = <<<EOF
<div>
<p>
　　“半决赛就是我的决赛。”中国男子短跑名将苏炳添在东京奥运会男子100米预赛结束后曾这样说。昨日站上半决赛的赛场，苏炳添也的确拼出了全力，并以9.83秒的成绩刷新亚洲纪录，排名半决赛首位成功闯入决赛。决赛场，第一次有中国选手站上奥运会男子100米决赛的跑道。苏炳添最终以9.98秒的成绩获得第六名，创造了中国田径新的历史。赛后他身披国旗，十分激动地说：“我完成了自己的梦想！”</p>

<p>
　　苏炳添8月29日就将迎来自己32岁的生日，虽然去年一度受到伤病的困扰，但他还是逐步恢复状态，在今年初再度跑进10秒之内。出战东京奥运会，苏炳添的第一个目标就是站上男子100米决赛跑道，因此他在昨日傍晚的半决赛中也拼出了全力。9.83秒的成绩不仅让他稳稳进入决赛，也创造了黄种人跑进9.9秒的新纪录。两小时之后，苏炳添站在了奥运会男子飞人决赛的跑道上。或许是半决赛拼得太凶，或许是被决赛中英国选手抢跑打乱了节奏，苏炳添的起跑反应时并不理想，最终以9.98秒的成绩获得第六名。但这依然书写了属于他、属于中国田径的崭新历史。</p>

<p>
　　完成决赛，苏炳添身披国旗在东京新国立竞技场内享受着属于自己的荣耀时刻。他说：“对我来说，通过这么多年的努力，终于可以站在奥运会100米决赛的跑道上，我完成了自己的梦想，也实现了中国田径历代前辈对我们的期待与祝福。半决赛到决赛这么短时间还能突破10秒，我已经非常开心了，达到了我自己的目标，这将是我一辈子最好的回忆。我拿到了奥运会第六名，我希望以此给予年轻运动员一个非常大的鼓励。比赛成绩应该说没有让大家失望，我也希望在几天后的接力比赛中继续展现中国速度。”</p>
</div>
EOF;

    $menu = ["首页", "文章", "视频", "评论", "留言", "关于"];
    e();

    return view('Blade.content', [
        'title' => $title,
        'content' => $content,
        'menu'=>$menu
    ]);
});

Route::get('container/test1', function(){
//    app()->bind('iphone12', function(){
//        return new \App\ContainerTest\iPhone12();
//    });
//    app()->instance('mi11', new \App\ContainerTest\Mi11());
//
//    app()->singleton('zyblog', function(){
//        return new \App\ContainerTest\ZyBlog();
//    });

//    $zyblog = app()->make('zyblog');
//    $zyblog->ShuaDuanShiPin(app()->make('iphone12')); // App\ContainerTest\iPhone12打开douyi

//    [$a, $b] = [1, 2];
//
//    echo $a, $b;

    app()->register(\App\Providers\PhoneServiceProvider::class);
    app()->register(\App\Providers\ZyBlogServiceProvider::class);

    $zyblog = app()->make('zyblog');
    $zyblog->ShuaDuanShiPin(); // App\ContainerTest\Mi11打开douyin

});


Route::get('pipeline/test1', function(){
    $pipes = [
        \App\PipelineTest\EmailChange::class,
        \App\PipelineTest\AddTime::class,
        new \App\PipelineTest\AddDollar(),
        function($text, $next){
            return $next("【".$text."】");
        },
    ];

    return app(\Illuminate\Pipeline\Pipeline::class)
        ->send("测试内容看看替换Email:zyblog@zyblog.ddd")
        ->through($pipes)
        ->then(function ($text) {
            return $text . "end";
        });
    // $【测试内容看看替换Email:zyblog#zyblog.ddd】$end1630978948

});

Route::get('facades/test', function(){
    // 实时 Facades
    Facades\App\Facades\ShowEmail::show();
    // 直接实例
    \App\Facades\ShowTel::show();
    // 别名
    \App\Facades\ShowWebSite::show();
});

Route::get('log/test', function(){
    \Illuminate\Support\Facades\Log::info("记录一条日志");

    \Illuminate\Support\Facades\Log::info("记录一条日志，加点参数", ['name'=>'ZyBlog']);

    $message = '记录一条日志';
    \Illuminate\Support\Facades\Log::emergency($message);
    \Illuminate\Support\Facades\Log::alert($message);
    \Illuminate\Support\Facades\Log::critical($message);
    \Illuminate\Support\Facades\Log::error($message);
    \Illuminate\Support\Facades\Log::warning($message);
    \Illuminate\Support\Facades\Log::notice($message);
    \Illuminate\Support\Facades\Log::info($message);
    \Illuminate\Support\Facades\Log::debug($message);

    \Illuminate\Support\Facades\Log::channel('errorlog')->info($message);
    \Illuminate\Support\Facades\Log::stack(['daily', 'errorlog'])->info($message);


    \Illuminate\Support\Facades\Log::channel('custom')->info($message."custom");
});

Route::get('error/test', function(){

//    try {
    1/0;
//        throw new Exception('test');
//        echo $a;
//    } catch (Exception $e) {
//        report($e);
//    }

    throw new \App\Exceptions\ZyBlogException('又有问题了');

//    abort(404, '没有找到页面哦');
});

Route::get('session/test', function(){
    \Illuminate\Support\Facades\Session::put('a', 'aaaaaaa');
//    echo request()->session()->get('a');
    echo session()->get('a');

    \Illuminate\Support\Facades\Session::flash('b', 'bbb');

    echo request()->session()->get('b');
    echo request()->session()->get('b');
    sleep(10);
    echo \Illuminate\Support\Facades\Session::getId();
})->block($lockSeconds = 10, $waitSeconds = 10);

Route::get('session/test2', function(){
    echo request()->session()->get('b');
})->block($lockSeconds = 10, $waitSeconds = 10);

Route::get('response/test1', function(){
    return response('Hello test1', 200)
        ->header('Content-type', 'application/json')
        ->withHeaders([
            'A'=>'A info',
            'B'=>'B info'
        ])
        ->cookie('oppo', 'o', );
});

Route::get('response/test2', function(){
    return response('Hello test1', 200)
        ->header('Content-type', 'application/json')
        ->withHeaders([
            'A'=>'A info',
            'B'=>'B info'
        ])
        ->cookie('oppo', 'o', );
});



Route::get('response/test2', function(){
//    return redirect('response/test1');
//    return redirect('response/test1',301);
//    return redirect()->route('rt3');
    return redirect()->action([\App\Http\Controllers\TestController::class, 'test2'], ['id'=>1]);

});

Route::name('rt3')->get('response/test3', function(){
    echo 111;
});

Route::get('response/test4', function(){
    return response()->download(\Illuminate\Support\Facades\Storage::path('public/8cb3c505713a1e861169aa227ee1c37c.jpg'));
});

Route::get('crypt', function(){
    $crypt =  \Illuminate\Support\Facades\Crypt::encrypt("aaa");
    echo $crypt, "<br/>"; // eyJpdiI6IjhqWUthVWZ2TFVYU0NCa2JxMlFMTXc9PSIsInZhbHVlIjoiUHYwdlhidEhINW9mOE5qMk1pTDg2QT09IiwibWFjIjoiYzVkZDQ4NjgxNDY5YWUwNTU4Yzk4NGZkYjRmMzI5MTIxNDU3M2MxMmNlODAwMjAzOGEzMmU0MjFhNThiYzdmNyJ9
    echo \Illuminate\Support\Facades\Crypt::decrypt($crypt); // aaa
});

Route::get('hash', function(){
    $hash1 = \Illuminate\Support\Facades\Hash::make("aaa");
    $hash2 = \Illuminate\Support\Facades\Hash::make("aaa", [
        'rounds' => 7,
        'memory' => 1024,
        'time' => 2,
        'threads' => 2,
    ]);

    echo $hash1, "<br/>", $hash2, "<br/>";
    // $2y$10$Ga3mtVuosSEkMztnA6TRleJZL6JqNCnT.sQHbw.jdUrmg1o.NPqDO
    // $2y$07$B1wLnF/5gjMH/GGY/KaYbu7WVdWIvswBcuORAQRsyfxJ46xyOVTOW
    echo \Illuminate\Support\Facades\Hash::check('aaa', $hash1), "<br/>"; // 1
    echo \Illuminate\Support\Facades\Hash::check('aaa1', $hash1), "<br/>"; //

    echo \Illuminate\Support\Facades\Hash::needsRehash($hash1), "<br/>"; //
});

Route::get('event/test1', function(){
    \App\Events\TestEvent::dispatch('aaa');
    \Illuminate\Support\Facades\Event::dispatch(new \App\Events\TestEvent('bbb'));
    event(new \App\Events\TestEvent('ccc'));
});

Route::get('event/test2', function(){
    \App\Events\TestEvent::dispatch('aaa');
    \App\Events\TestEvent2::dispatch();
    \App\Events\TestEvent3::dispatch();

//    aaaThis is AllTestEventaaa
//    This is TestEvent1aaa
//    This is AllTestEvent
//    This is TestEvent2
//    This is AllTestEvent
//    This is TestEvent3
});

Route::get('queue/test1', function(){
    \App\Jobs\Test::dispatch();
    \App\Jobs\Test::dispatch();
    \App\Jobs\Test::dispatch();

    dispatch(function(){
        echo 'callback queue';
        sleep(10);
    });
    dispatch(function(){
        echo 'callback queue';
        sleep(10);
    });
});

Route::get('queue/test2', function(){
    $obj = new stdClass();
    $obj->a = 111;
    \App\Jobs\Test2::dispatch($obj);
    \App\Jobs\Test2::dispatch($obj);
    \App\Jobs\Test2::dispatch($obj);

    dispatch(function() use ($obj){
        echo 'callback queue';
        print_r($obj);
        sleep(10);
    });
    dispatch(function() use($obj){
        echo 'callback queue';
        print_r($obj);
        sleep(10);
    });
});

Route::get('queue/chain', function(){

    \Illuminate\Support\Facades\Bus::chain([
        function(){
            echo 'first';
        },
        new \App\Jobs\Test(),
        function(){
            echo 'third';
        }
    ])->dispatch();
    \Illuminate\Support\Facades\Bus::chain([
        function(){
            echo 'first';
            throw new \Exception("第一个就错了");
        },
        new \App\Jobs\Test(),
        function(){
            echo 'third';
        }
    ])->catch(function(Throwable $e){
        echo "Error:", $e->getMessage();
    })->dispatch();
});
