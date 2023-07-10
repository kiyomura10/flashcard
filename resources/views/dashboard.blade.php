<x-app-layout>
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">

    <h1 class="text-3xl font-medium title-font text-gray-900 mb-12 text-center">マイページ</h1>
  
    <div class="flex flex-wrap -m-4">

      <div class="p-4 md:w-1/2 w-full">

        <div class="h-full bg-white p-8 rounded text-center">
          <h2 class="text-xl mb-4">アカウント情報</h2>
          <p>{{ Auth::user()->name }}</p>
          <p>{{ Auth::user()->email }}</p>
          <a href="{{route('profile.edit')}}"><button class="py-4 px-8 mt-4  bg-red-500 hover:bg-red-700 text-white rounded-2xl">プロフィールを編集する</button></a>
        </div>

      </div>

      <div class="p-4 md:w-1/2 w-full">
        
        <div class="h-full bg-white p-8 rounded text-center">

          <div>
            <h2 class="text-xl underline mb-4">学習の記録</h2>      
            <p>🔴挑戦した問題数</p>
            {{ $sum[0]->total_try }}問
           
            <p class="mt-2">🔴正解した問題数</p>
            {{ $sum[0]->total_correct }}問
            
            <p class="mt-2">🔴覚えた問題数</p>
            {{ $memorize }}問
          </div>

        </div>

      </div>

    </div>

  </div>

</section>
</x-app-layout>
