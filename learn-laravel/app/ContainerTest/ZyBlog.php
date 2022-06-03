<?php


namespace App\ContainerTest;


class ZyBlog
{
    private $phone;

    public function __construct(IntelligencePhone $phone)
    {
        $this->phone = $phone;
    }

//    public function setPhone(IntelligencePhone $phone){
//        $this->phone = $phone;
//    }
//
//    public function getPhone(){
//        return $this->phone;
//    }

//    public function ShuaDuanShiPin($phone){
//        $phone->openApp('douyin');
//    }
    public function ShuaDuanShiPin(){
        $this->phone->openApp('douyin');
    }

    public function __invoke()
    {
        echo __CLASS__;
    }
}
