<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'user_id' => '1',
                'name' => 'IT英語',
            ],
            [
                'user_id' => '1',
                'name' => 'Laravel',
            ]
        ]; 

        foreach($tags as $tag){
            \App\Models\Tag::create($tag);
        }
        
    }
}
