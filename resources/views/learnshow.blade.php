<x-app-layout>                
<section class="bg-white body-font relative">

    <div class="container  px-5 py-24 mx-auto">

        <div class="flex flex-col text-center w-full mb-12">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">学習ページ</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">解答を入力してください</p>
        </div>

@if($value[0])
            <div id="app" class="lg:w-1/2 md:w-2/3 mx-auto  ">
                
                <div class="p-2 w-full">

                    <div class="relative">
                        <label for="question" class="leading-7 text-sm text-gray-600">問題文</label>
                        <textarea id="question" name="question" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $value[0]->question }}</textarea>
                    </div>
                    <button  @click="show = !show" v-show="!show" class="py-2 px-6 mt-2 ml-8 bg-red-500 hover:bg-red-700 text-white rounded-2xl" type="submit" name="correct" value="正解">解答を表示する</button>
                    <div v-show="show" class="relative">
                        <label for="anser" class="leading-7 text-sm text-gray-600">解答</label>
                        <textarea  id="anser" name="anser" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">{{ $value[0]->answer }}</textarea>
                    </div>
                    <div  class="mt-4 text-center">
                        <button @click="correct_btn({{$value[0]->id}})" :class="{'bg-gray-300':gray,'bg-blue-300':blue,'bg-gray-300':!blue}" class="py-4 px-8  rounded-2xl" type="submit" name="correct" value="正解">正解</button>
                        <button @click="incorrect_btn({{$value[0]->id}})"  :class="{'bg-gray-300':gray,'bg-blue-300':red,'bg-gray-300':!red}" class="py-4 px-8  rounded-2xl" type="submit" name="incorrect" value="不正解">不正解</button>
                        <button @click="memorize_btn({{$value[0]->id}})" :class="{'bg-gray-300':!btn,'bg-blue-300':btn}" class="py-4 px-8 rounded-2xl ml-4" type="submit" name="memorize" value="不正解">覚えた</button>
                    </div>
                    
                </div>
                
                {{ $value->appends(request()->query())->links() }}
            </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
    let app = new Vue({
        el: '#app',
        data(){
            return{
                show: false,
                correct: 0,
                memorize: {{$value[0]->memorize}} ,
                blue: false,
                red: false,
                gray:true,
                id:'',
                btn:false
            }
        },
        methods:{
            async next(){
               
                if(this.id){
                    const query = new FormData; 
                      query.set('id', this.id);
                      query.set('correct', this.correct);
                      query.set('memorize', this.memorize);
                      const response = await fetch('learnajax',
                        { method:'POST',
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: query
                        }).then(response => response.json())
                        
                }
               
            },
            correct_btn(id){
                this.id = id;
                this.blue= true;
                this.red = false;
                this.gray= false;
                this.correct = 1 ;
            },
            incorrect_btn(id){
                this.id = id;
                this.blue= false;
                this.red = true;
                this.gray= false;
                this.correct = 0;
            },
            memorize_btn(id){
                this.id = id;
                
                if(this.btn){
                    this.btn = false;
                    this.memorize = 0;
                }else{
                    this.btn = true;
                    this.memorize = 1;
                }
            }
        },
        created(){
            if(this.memorize){
                this.btn = true;
            }else{
                this.btn = false;
            }
            
        }
              
    })
</script>
@else
    <p>条件に合う問題がありません。</p>
@endif
</x-app-layout>
