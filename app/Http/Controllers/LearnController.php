<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Models\tag;
use App\Models\question_tag;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\DB;

class LearnController extends Controller
{
    public function index(){
        
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        return view('learnindex',compact('tags'));
    }


    public function show(Request $request){
        $request->validate([ 'tag' => 'required']);
        
      
            //覚えていない問題だけ出題する
            if($request->memories){
                //覚えていない全ての問題を出題
                if($request->tag == 'all'){
                    $value = question::where('user_id',auth()->id())->where('memorize',0)->simplepaginate(1);
                 }else{
                    //個別のタグで出題する
                    $value = question::whereHas('tags',function($query) use($request){
                        $query->where('id',$request->tag);
                    })->where('user_id',auth()->id())->where('memorize',0)->simplepaginate(1);
                 }
                 //dd(1,$value);
            }else{
                //覚えている問題も出題
                //全ての問題を出題
                if($request->tag == 'all'){
                    $value = question::where('user_id',auth()->id())->simplepaginate(1);
                }else{
                    //個別のタグで出題
                    $value = question::whereHas('tags',function($query) use($request){
                        $query->where('id',$request->tag);
                    })->where('user_id',auth()->id())->simplepaginate(1);
                 }
                 //dd(2,$value);
            }
        
        //dd($value);
        return view('learnshow',compact('value'));
    }


    public function learnajax(Request $request){
        
        $id = $request->input('id');
        $correct = $request->input('correct');
        $memorize = $request->input('memorize');

            $question = question::find($id);
        if($correct == 1){
            $question->increment('correct');
        }
            $question->increment('try');
            $question->memorize = $memorize;
            $question->save();

        echo json_encode($id);
    }

   

    public function tagajax(Request $request){
        $request->validate([
            'tag' => ['required','max:10','unique:tags,name']
            
        ]);

        $tag = $request->input('tag');
        tag::create([
            'user_id'=> auth()->id(),
            'name'=> $tag
        ]);
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        echo json_encode($tags);
    }


    public function tagindexajax(){
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();

        echo json_encode($tags);
    }

    public function tageditajax($id){
        
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        $include_tags = tag::whereHas('questions',function($query) use($id){
            $query->where('id',$id);
        })->where('user_id',auth()->id())->get();
        $value = ['tags' => $tags,'include_tags' => $include_tags];
        echo json_encode($value);
    }

    public function dashboard(){
       //解いた問題数、正解数取得
        $sum = question::select(DB::raw('SUM(try) as total_try,sum(correct) as total_correct'))->where('user_id',auth()->id())->get();
        $memorize = question::where('user_id',auth()->id())->where('memorize',1)->count();
        
       return view('dashboard',compact('sum','memorize'));
    }
}
