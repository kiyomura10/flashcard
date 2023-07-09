<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\QuestionTag;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        return view('tag',compact('tags'));
    }

    public function store(Request $request){
        $request->validate([
            'tagName' => ['required','max:10','unique:tags,name']
            
        ]);
        Tag::create([
            'name' => $request->tagName,
            'user_id' => auth()->id()
        ]);
        return back()->with('message','保存しました');
    }

    public function destroy(Request $request){
        //dd($request->tag_id);
        $request->validate([
            'tag_id' => ['required']
            
        ]);
        $tag = Tag::find($request->tag_id);
        $tag->delete();
        $request->session()->flash('message', '削除しました');
        return redirect('tag');
    }

    //タグの新規追加
    public function tagajax(Request $request){
        $request->validate([
            'tag' => ['required','max:10','unique:tags,name']
            
        ]);

        $tag = $request->input('tag');
        Tag::create([
            'user_id'=> auth()->id(),
            'name'=> $tag
        ]);
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        echo json_encode($tags);
    }


    public function tagindexajax(){
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();

        echo json_encode($tags);
    }

    public function tageditajax($id){
        
        $tags = Tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        $include_tags = Tag::whereHas('questions',function($query) use($id){
            $query->where('id',$id);
        })->where('user_id',auth()->id())->get();
        $value = ['tags' => $tags,'include_tags' => $include_tags];
        echo json_encode($value);
    }

    
}
