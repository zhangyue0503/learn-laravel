<?php

class Container
{
    protected $binds;

    protected $instances;

    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        array_unshift($parameters, $this);

        return call_user_func_array($this->binds[$abstract], $parameters);
    }
}

interface IntelligencePhone{
    public function openApp($name);
}

class iPhone12 implements  IntelligencePhone {
    public function openApp($name){
        echo __CLASS__ . '打开' . $name, PHP_EOL;
    }
}

class Mi11 implements  IntelligencePhone {
    public function openApp($name){
        echo __CLASS__ . '打开' . $name, PHP_EOL;
    }
}

class ZyBlog {
//    public function ShuaDuanShiPin(){
//        $iPhone = new iPhone12();
//        $iPhone->openApp('douyin');
//    }

//    public function ShuaDuanShiPin(){
//        $mi = new Mi11();
//        $mi->openApp('douyin');
//    }

    public function ShuaDuanShiPin(IntelligencePhone $phone){
         $phone->openApp('douyin');
    }
}

// 回调函数问题
//$zy = new ZyBlog();
////var_dump($zy);
//$zy->ShuaDuanShiPin(new Mi11());
//exit;


//$callZy = function(){
//    return new ZyBlog();
//};
//// ……
//// ……
//// ……
//$zy = $callZy();
//var_dump($zy);

//exit;

// 容器使用-回调方式
//$container = new Container();
//
//$container->bind(iPhone12::class, function(){
//    return new iPhone12();
//});
//$container->bind(Mi11::class, function(){
//    return new Mi11();
//});
//$container->bind(ZyBlog::class, function(){
//    return new ZyBlog();
//});
//
//$zyBlog1 = $container->make(ZyBlog::class);
//
//$zyBlog1->ShuaDuanShiPin($container->make(Mi11::class));
//
//$zyBlog2 = $container->make(ZyBlog::class);
//
//var_dump($zyBlog2 === $zyBlog1);
//
//exit;

// 容器使用-单例实例化方式
$container2 = new Container();
$container2->bind(iPhone12::class, new iPhone12());
$container2->bind(Mi11::class, new Mi11());
$container2->bind(ZyBlog::class, new ZyBlog());

$zyBlog1 = $container2->make(ZyBlog::class);

$zyBlog1->ShuaDuanShiPin($container2->make(Mi11::class));

$zyBlog2 = $container2->make(ZyBlog::class);

var_dump($zyBlog2 === $zyBlog1);


