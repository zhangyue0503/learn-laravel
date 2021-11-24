<?php


namespace App\Http\Controllers;




use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateController extends Controller
{
    public function create(){
        return view("validate.create");
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'title'=>"required|max:20",
            'author'=>['required','min:2', 'max:20'],
            'age'=>"numeric",
            'body'=>"required"
        ]);
    }

    public function store2(Request $request){
        $validator = Validator::make($request->all(), [
            'title'=>"required|max:20",
            'author'=>['required','min:2', 'max:20'],
            'age'=>"numeric",
            'body'=>"required"
        ], [
            'title.required'=>'请填写标题',
            'title.max'=>'标题最大不超过20个字符',
            'author.required'=>'请填写作者',
            'author.min'=>'作者最少填写2个字符',
            'author.max'=>'作者最大不超过20个字符',
            'age.numeric'=>'年龄必须是数字',
            'body.required'=>'内容必填'
        ]);

        if($validator->fails()){
            return redirect('validate/create')
                ->withErrors($validator)
                ->withInput();
        }
    }
}
