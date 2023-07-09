<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\QuestionTag;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index(Request $request){

        if(!empty($request->search) && $request->search !== 'all'){

            if($request->search == 'undefined' ){
                //タグが未定義の問題表示
                $question = Question::doesntHave('tags')->where('user_id',auth()->id())->get();
                //dd('未定義',$question);
            }else{
                //タグで絞り込む場合
            //絞り込みがされていない又は全て表示が選択された場合、全件表示
               $question = Question::with('tags')->whereHas('tags',function($query) use($request){
                    $query->where('id',$request->search);
                })->where('user_id',auth()->id())->get();
                //dd('tag',$question);
            }
           
        }else{
            //絞り込みがされていない又は全て表示が選択された場合、全件表示
            $question = Question::with('tags')->where('user_id',auth()->id())->get();
            //dd($question);
        }

      $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
      return view('questionindex',compact('question','tags'));
    }


    public function create(){
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
       
        return view('/questionregister',compact('tags'));
    }


    public function store(QuestionRequest $request){
       // dd($request);
        DB::transaction(function() use($request) {
            
            //questionテーブルに保存
           $question_id = Question::insertGetId(['question' => $request->question,
             'answer' => $request->answer,
            'user_id' => auth()->id(),
            ]);
                
               //既存タグとの紐づけ（中間テーブルへの保存）
            if(!empty($request->tag)){   
                    QuestionTag::create([
                        'question_id' => $question_id,
                            'tag_id' => $request->tag
                    ]);
            }
            
        });

       return back()->with('message','保存しました');
    }


    public function edit($id){
        $value = Question::find($id);
        //ログインユーザーと問題のユーザーIDが同じかチェック
        Gate::authorize('access', $value->user_id);
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
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
            Question::where('id',$question_id)->update(['question' => $request->question,
                                                    'answer' => $request->answer,
                                            ]);
            //カードと紐づいているタグ（中間テーブル）を削除
            QuestionTag::where('question_id',$question_id)->delete();
            //タグが選択されていたら紐付ける
            if(!empty($request->tag)){
                    QuestionTag::create([
                        'question_id' => $question_id,
                        'tag_id' => $request->tag
                    ]);
             }

        });

            $request->session()->flash('message','更新しました');
            return back();
    }

    public function destroy(Request $request ,$question_id){
        $question = Question::find($question_id);
        $question->delete();
        $request->session()->flash('message', '削除しました');
        return redirect('questionindex');
    }

    
}
