<x-app-layout>
    <section class="bg-white body-font relative">
        <div id="app" class="container  px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">単語帳編集</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">問題文と解答を編集してください</p>
            </div>

            
            <div  class="lg:w-1/2 md:w-2/3 mx-auto  ">
                <div class="text-right">
                  <form @submit="btn" method="post" action="{{route('destroy',$value)}}">
                            @csrf
                            @method('delete')
                            <input class="py-4 px-8 bg-red-500 hover:bg-red-700 text-white rounded-2xl" type="submit" value="削除">
                 </form>
                </div>
            {{session('message')}}
           
                <form method="POST" action="{{route('patch',$value)}}">
                    @csrf
                    @method('patch')
                    <div class="p-2 w-full">
                    <x-input-error :messages="$errors->get('question')" class="mt-2" />
                        <div class="relative">
                            <label for="question" class="leading-7 text-sm text-gray-600">問題文</label>
                            <textarea id="question" name="question" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{old('question',$value->question)}}</textarea>
                        </div>
                        <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                        <div class="relative">
                            <label for="answer" class="leading-7 text-sm text-gray-600">解答</label>
                            <textarea id="answer" name="answer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{old('answer',$value->answer)}}</textarea>
                        </div>

                        <div  class="relative">
                            
                        <div v-if="errors">
                            @{{ errors }} 
                        </div>
                        <p class="leading-7 text-sm text-gray-600">タグ</p>
                        <div class="text-center">
                            <input id="tag" v-model="tagName" name="tag" placeholder="新規追加するタグ名を入力してください" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200  text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">                 
                            <button @click="tag" type="button" class="py-2 px-6 mt-2 ml-8 bg-red-500 hover:bg-red-700 text-white rounded-2xl">新しいタグを登録する</button>    
                        </div>

                        <div >
                            <p class="leading-7 text-sm mt-4 text-gray-600">カードに設定したいタグを１つ選択してください</p>
                            <label class="mr-4 whitespace-nowrap"  v-for="tag in tags" >
                            <input  type="radio" name="tag" :value="tag.id" :checked="tag.id == include_tags[0].id ? true: false">
                                @{{ tag.name }}</label>
                        </div>
                      
                        <div class="mt-4 text-center">
                        <input class="py-4 px-12 text-lg bg-red-500 hover:bg-red-700 cursor-pointer text-white rounded-2xl"  type="submit" value="更新する">
                        </div>
                       
                    </div>
                </form>

            </div>
        </div>
    </section>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
     let app = new Vue({
        el: '#app',
        data(){
            return{
                tagName:'',
                tags: [],
                include_tags: [
                    {id:"",}
                ],
                errors:'',
                }
            }, 
        methods:{
           async tag(){
                        
                        const query = new FormData; 
                        query.set('tag', this.tagName);
                        const response = await fetch('tagajax',
                        { method:'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With':'XMLHttpRequest' },
                        body: query
                        }).then(response => response.json());
                        
                         console.log(response);
                        if(response.message){
                        this.errors = response.message;
                        }else{
                            this.tags = response;
                        }
                        
                        this.tagName = '';
                    },
                    btn(){
                      const ans = confirm('本当に削除しますか？');
                        if(!ans) event.preventDefault();
                        
                    }
                    
                },
                async created(){
                    const response = await fetch('tageditajax')
                    .then(response => response.json());
                    this.tags = response.tags;
                    if(response.include_tags[0]){
                        console.log(response.include_tags);
                     this.include_tags = response.include_tags;
                    }
                   
                }
              
    });
</script>