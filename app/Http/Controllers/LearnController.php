<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\QuestionTag;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\DB;

class LearnController extends Controller
{
    public function index(){
        
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        return view('learnindex',compact('tags'));
    }


    public function show(Request $request){
        $request->validate([ 'tag' => 'required']);
        
      
            //覚えていない問題だけ出題する
            if($request->memories){
                //覚えていない全ての問題を出題
                if($request->tag == 'all'){
                    $value = Question::where('user_id',auth()->id())->where('memorize',0)->simplepaginate(1);
                 }else{
                    //個別のタグで出題する
                    $value = Question::whereHas('tags',function($query) use($request){
                        $query->where('id',$request->tag);
                    })->where('user_id',auth()->id())->where('memorize',0)->simplepaginate(1);
                 }
                 //dd(1,$value);
            }else{
                //覚えている問題も出題
                //全ての問題を出題
                if($request->tag == 'all'){
                    $value = Question::where('user_id',auth()->id())->simplepaginate(1);
                }else{
                    //個別のタグで出題
                    $value = Question::whereHas('tags',function($query) use($request){
                        $query->where('id',$request->tag);
                    })->where('user_id',auth()->id())->simplepaginate(1);
                 }
                 //dd(2,$value);
            }
        
        //dd($value);
        return view('learnshow',compact('value'));
    }

//クイズを解いた時の処理
    public function learnAjax(Request $request){
        
        $id = $request->input('id');
        $correct = $request->input('correct');
        $memorize = $request->input('memorize');

            $question = Question::find($id);
        if($correct == 1){
            $question->increment('correct');
        }
            $question->increment('try');
            $question->memorize = $memorize;
            $question->save();

        return $id;
    }

    public function dashboard(){
        //解いた問題数、正解数取得
         $sum = Question::select(DB::raw('SUM(try) as total_try,sum(correct) as total_correct'))->where('user_id',auth()->id())->get();
         $memorize = Question::where('user_id',auth()->id())->where('memorize',1)->count();
         
        return view('dashboard',compact('sum','memorize'));
     }
}
