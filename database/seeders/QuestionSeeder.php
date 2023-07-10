<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'user_id' => '1',
                'question' => 'array',
                'answer' => '配列',
            ],
            [
                'user_id' => '1',
                'question' => 'attribute',
                'answer' => '属性',
            ],
            [
                'user_id' => '1',
                'question' => 'branch',
                'answer' => 'ブランチ、分岐',
            ],
            [
                'user_id' => '1',
                'question' => 'character',
                'answer' => '文字',
            ],
            [
                'user_id' => '1',
                'question' => 'define',
                'answer' => '定義する',
            ],
            [
                'user_id' => '1',
                'question' => 'Facade（ファサード）',
                'answer' => 'クラスをインスタンス化しなくても、静的（static）メソッドのように使える機能',
            ],
            [
                'user_id' => '1',
                'question' => 'seeder(シーダー)',
                'answer' => 'データベースにテストデータを登録する機能',
            ],
            [
                'user_id' => '1',
                'question' => 'Gate',
                'answer' => 'アクセスや動作に制限をかける機能。Gateは、Gateファサードを使用してApp\Providers\AuthServiceProviderクラスのbootメソッド内で定義する',
            ],
            [
                'user_id' => '1',
                'question' => 'サービスコンテナ',
                'answer' => 'クラスのインスタンス化を管理する仕組み。サービスコンテナにクラスを登録することをバインド、サービスコンテナからクラスを生成することをリゾルブという',
            ],
            [
                'user_id' => '1',
                'question' => 'FormRequest（フォームリクエスト）',
                'answer' => 'リクエスト作成時に認可(Authorization)と検証(Validation)を行う機能。フォームから送信されたリクエストを操作、拡張するためのリクエストインスタンスを継承したクラス',
            ],
        
        ];

        foreach($questions as $question){
            \App\Models\Question::create($question);
        }
    }
}
