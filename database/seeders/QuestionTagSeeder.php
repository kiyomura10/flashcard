<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [];
        //タグ１に問題を紐付ける（１〜５問）
        for($i = 1; $i <= 5; $i++ ){
            $values[] = [
                'question_id' => $i,
                'tag_id' => '1'
            ];
        }  
        //タグ２に問題を紐付ける（６〜１０問）
        for($i = 1; $i <= 5; $i++ ){
            $values[] =
            [
                'question_id' => $i+5,
                'tag_id' => '2'
            ];
        }
            
        
        
        foreach($values as $value){
            \App\Models\QuestionTag::create($value);
        }
    }
}
