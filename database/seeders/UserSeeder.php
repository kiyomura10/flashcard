<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'test@test',
                'password' => Hash::make('test1234'),
                'name' => 'test'
            ],
            [
                'email' => 'taiti@taiti',
                'password' => Hash::make('taiti1234'),
                'name' => 'taiti'
            ]
        ];    

        foreach($users as $user){
            \App\Models\User::create($user);
        }
        
    }
}
