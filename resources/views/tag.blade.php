<x-app-layout>
<section class="text-gray-600 body-font">

  <div class="container px-5 py-24 mx-auto  min-h-screen bg-white">

        <div class="flex flex-col text-center w-full mb-8">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-800">タグ編集</h1>
            <p class="leading-relaxed text-base">タグの作成や削除をすることができます</p>
        </div>

        <div class="lg:w-1/2 md:w-2/3 mx-auto">
            
            {{session('message')}} 
            <x-input-error :messages="$errors->get('tagName')"  />
            <form method="POST" action="{{route('tag.store')}}">
                @csrf
                <div class="mx-auto md:w-2/3">
                   <input id="tag" name="tagName" placeholder="新規追加するタグ名を入力してください"  class="w-full   bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200  text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">                 
                </div>
                <div class="text-center">
                    <input class="py-2 px-6 mt-2 ml-8 bg-red-500 hover:bg-red-700 text-white rounded-2xl" type="submit" value="新しいタグを登録する">
                </div>
            </form>

            <form method="post" action="{{route('tag.destroy')}}">
                @csrf
                @method('delete')

                <div class="mt-8 p-4 w-full text-center border">
                    <p class="mb-4 text-lg">タグ一覧</p>
                    <x-input-error :messages="$errors->get('tag_id')" class="mt-2" />
                    @foreach($tags as $tag)

                        <input type="radio" name="tag_id" id="{{$tag->id}}" value="{{ $tag->id }}">
                        <label for="{{$tag->id}}">{{ $tag->name }}</label>
                        
                    @endforeach
                </div>
        
                <div class="text-center mt-10">
                    <input class="py-4 px-12 text-lg bg-red-500 hover:bg-red-700 cursor-pointer text-white rounded-2xl" type="submit" value="選択したタグを削除する">
                </div>
            </form>
        </div>

    </div>
</section>
</x-app-layout>