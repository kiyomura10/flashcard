
<x-app-layout>
<div id="app" class="bg-white py-6 sm:py-8 lg:py-12">
  <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
    <div class="mb-10 md:mb-16">
      <h2 class="mb-4 text-center text-2xl font-bold text-gray-800 md:mb-6 lg:text-3xl">クイズ一覧</h2>
    </div>
    <div class="p-4 md:w-1/2 border-black border" >
      <P class="text-center text-lg mb-2">クイズを絞り込む</p>
      <form method="GET" action="{{route('index')}}" >
          <div class="mb-2">
            <input  type="radio" id="all" name="search" value="all">
            <label class="mr-2" for="all">全てのクイズを表示</label>
            <input type="radio" id="undefined" name="search" value="undefined">
            <label class="mr-2" for="undefined">タグが未定義の問題を表示</label>
          </div>
          <p class="text-center">タグで絞り込む</p>
          @foreach($tags as $tag)
          <label class="mr-2 whitespace-nowrap" for="{{$tag->id}}"><input type="radio" id="{{$tag->id}}" name="search" value="{{$tag->id}}">{{$tag->name}}</label>
          @endforeach
          <div class="text-center mt-4">
            <input type="submit" class="py-2 px-8 text-white bg-red-500 hover:bg-red-700 cursor-pointer rounded-2xl" value="絞り込む">
          </div>
      </form>
    </div>
    
    @if(empty($question[0]))
        <p>該当のクイズはありません</p>
        @endif

    <div class="mt-8 grid gap-8 md:grid-cols-2 xl:grid-cols-3">
      <!-- question - start -->
      @foreach($question as $q)
      <div class="relative rounded-lg bg-gray-100 px-12 py-8">
      <div class="text-right">
                    <form @submit="btn" method="post" action="{{route('destroy',[$q->id])}}">
                                @csrf
                                @method('delete')
                                <input  class="py-1 px-4 text-white bg-red-300 hover:bg-red-700 cursor-pointer rounded-lg" type="submit" value="削除">
                    </form>
                  </div>
        <div class="mb-3 text-lg font-semibold text-gray-600  ">問題<p class="leading-normal overflow-hidden h-[3em]">{{$q->question}}</p></div>
        <div class="mb-3 text-lg font-semibold text-gray-600">答え<p class="leading-normal overflow-hidden h-[3em]">{{$q->answer}}</p></div>
                 <div class="mb-8   text-gray-600 flex ">  
                    <div class="whitespace-nowrap">
                        <p>・解いた数:{{$q->try}}</p>
                        <p>・正解:{{$q->correct}}</p>
                    </div>
                      
                    <div class="ml-4 overflow-hidden whitespace-nowrap">
                      @if(isset($q->tags[0]))
                         <p>・タグ：{{ $q->tags[0]->name }}</p>
                      @else
                          <p>・タグ:なし</p>
                      @endif
                        <p>・覚えた:@if($q->memorize) ◯ @else ✕ @endif</p>
                    </div>
                </div>
                  <div class="basis-full text-center">
                    <a href="{{route('edit',[$q->id])}}"><button class="px-4 py-2 text-white bg-indigo-500 hover:bg-indigo-700 cursor-pointer rounded-lg">編集</button></a>
                  </div>
              
        </div>
      @endforeach
      <!-- question - end -->
      
     
    </div>
  </div>
</div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
  let app = new Vue({
    el: '#app',
    data(){
      return{
     
      }
    },
    methods:{
       btn(){
       const ans = confirm('本当に削除しますか？');
        if(!ans) event.preventDefault();
        
      }
    }

  });
</script>