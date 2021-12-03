<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTest extends Model
{
    use HasFactory;
    protected $table = 'm_test';
    public $timestamps = false;

    public function gender(){
        return $this->belongsTo('App\Models\DbSex', 'sex');
    }

    public static function testCulAdd($a, $b){
        return $a+$b;
    }

}
