<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\question;
use App\Models\tag;
use App\Models\question_tag;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function index(){
        $tags = tag::where('user_id',auth()->id())->orderBy('id','DESC')->get();
        return view('tag',compact('tags'));
    }

    public function store(Request $request){
        $request->validate([
            'tagName' => ['required','max:10','unique:tags,name']
            
        ]);
        tag::create([
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
        $tag = tag::find($request->tag_id);
        $tag->delete();
        $request->session()->flash('message', '削除しました');
        return redirect('tag');
    }
}
