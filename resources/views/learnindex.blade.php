
<x-app-layout>
<div class="container px-5 py-24 mx-auto">

    <h1 class="text-3xl font-medium title-font text-gray-900 mb-8 text-center">学習ページ</h1>
    <p class="w-full leading-relaxed text-center mb-8 text-base">設定を選んで学習を開始しましょう</p>
    <form method="GET" action="{{route('learn.show')}}">
        @csrf

      <div class="flex flex-wrap -m-4">

        <div class="p-4 md:w-1/2 w-full">

          <div class="h-full bg-white p-8 rounded text-center">
              <label for="memories" class="leading-7 text-sm text-gray-600">覚えてない問題だけ出題する</label>
              <input type="checkbox" id="memories" name="memories" value="true">
          </div>

        </div>

        <div class="p-4 md:w-1/2 w-full">
          
          <div class="h-full bg-white p-8 rounded ">

            <div>
              <p class="text-center">学習するタグを選択してください</p>

              <div class="mt-4 ">
                <x-input-error :messages="$errors->get('tag')" class="mt-2" />
                <input type="radio" name="tag" id="all" value="all">
                <label class="mr-2" for="all">全ての問題を出題する</label>
                @foreach($tags as $tag)
                  <label class="whitespace-nowrap mr-2" for="{{$tag->id}}">
                    <input type="radio" name="tag" id="{{$tag->id}}" value="{{ $tag->id }}">{{ $tag->name }}
                  </label>
                @endforeach
              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="text-center mt-8">
        <button class=" bg-red-500 hover:bg-red-700 cursor-pointer text-white rounded-2xl border-0 py-2 px-8 focus:outline-none text-lg">学習を開始する</button>
      </div>

    </form>

    
    
</div>
</x-app-layout>