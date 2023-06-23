<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Models\tag;
use App\Models\question_tag;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index(Request $request){

        if(!empty($request->search) && $request->search !== 'all'){

            if($request->search == 'undefined' ){
                //タグが未定義の問題表示
                $question = question::doesntHave('tags')->get();
                //dd('未定義',$question);
            }else{
                //タグで絞り込む場合
            //絞り込みがされていない又は全て表示が選択された場合、全件表示
               $question = question::with('tags')->whereHas('tags',function($query) use($request){
                    $query->where('id',$request->search);
                })->where('user_id',auth()->id())->get();
                //dd('tag',$question);
            }
           
        }else{
            //絞り込みがされていない又は全て表示が選択された場合、全件表示
            $question = question::with('tags')->where('user_id',auth()->id())->get();
            //dd($question);
        }

      $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
      return view('questionindex',compact('question','tags'));
    }


    public function create(){
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
       
        return view('/questionregister',compact('tags'));
    }


    public function store(QuestionRequest $request){
       // dd($request);
        DB::transaction(function() use($request) {
            
            //questionテーブルに保存
           $question_id = question::insertGetId(['question' => $request->question,
             'answer' => $request->answer,
            'user_id' => auth()->id(),
            ]);
                
               //既存タグとの紐づけ（中間テーブルへの保存）
            if(!empty($request->tag)){   
                    question_tag::create([
                        'question_id' => $question_id,
                            'tag_id' => $request->tag
                    ]);
            }
            

        });

       return back()->with('message','保存しました');
    }


    public function show($id){
       $value = question::find($id);
       return view('/questionshow',compact('value'));
    }


    public function edit($id){
        $value = question::find($id);
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
       //dd($value->tags);
        $include_tags = [];
        foreach($value->tags as $tag){
            array_push($include_tags,$tag->id);
        }
        //dd($include_tags);
        return view('/questionsedit',compact('value','tags','include_tags'));
    }


    public function update(QuestionRequest $request, $question_id){
        //dd($request);
        DB::transaction(function() use($request,$question_id) {
            question::where('id',$question_id)->update(['question' => $request->question,
                                                    'answer' => $request->answer,
                                            ]);
            //カードと紐づいているタグ（中間テーブル）を削除
            question_tag::where('question_id',$question_id)->delete();
            //タグが選択されていたら紐付ける
            if(!empty($request->tag)){
                    question_tag::create([
                        'question_id' => $question_id,
                        'tag_id' => $request->tag
                    ]);
             }

        });

            $request->session()->flash('message','更新しました');
            return back();
    }

    public function destroy(Request $request ,$question_id){
        $question = question::find($question_id);
        $question->delete();
        $request->session()->flash('message', '削除しました');
        return redirect('questionindex');
    }

    public function test(Request $request){
         $id = $request->input('id');
         $num = $request->input('num');
         if($num == 0){
            $num = 1;
         }else{
            $num = 0;
         }
         question::where('id',$id)->update(['memorize'=>$num]);

       echo json_encode($num);
    }
}
