<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ユーザーデータの配列を定義
        $users = [
            [
                'name' => 'John Doe',
                'age' => 25,
                'grade' => '学部1年生',
                'faculty' => '経済科学部',
                'sex' => '男子',
                'self_introduction' => 'Hello, I am John.',
                'avatar' => 'avatar.jpg',
                'line_link' => 'https://line.me/johndoe',
                'twitter_link' => 'https://twitter.com/johndoe',
                'instagram_link' => 'https://instagram.com/johndoe',
                'registered_sns_flag' => '1',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            // 追加のユーザーデータをここに追記する
        ];

        // ユーザーデータをデータベースに挿入
        DB::table('users')->insert($users);
    }
}
