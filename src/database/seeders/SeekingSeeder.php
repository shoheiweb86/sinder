<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeekingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // シーキングデータの配列を定義
        $seekings = [
            [
                'user_id' => 1,
                'title' => '夏季インターンシップ募集！',
                'content' => '当社では、夏季インターンシップに参加してくれる学生を募集しています。新しいスキルを身につけたい学生の皆さん、ぜひご応募ください！',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => '英会話講師募集中！',
                'content' => '弊社では、英会話講師を募集しています。ネイティブスピーカーで、教育に情熱を持った方をお待ちしております。充実した授業とやりがいのある仕事です！',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'title' => 'パートタイム店舗スタッフ募集！',
                'content' => '当店では、パートタイムの店舗スタッフを募集しています。明るく元気な方、接客が得意な方、ぜひご応募ください。未経験者も歓迎です！',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'イベントスタッフ募集！',
                'content' => '大型イベントのスタッフを募集しています。イベント運営の裏方からイベント当日の運営まで、様々なポジションで活躍できます。経験者優遇。',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => 'Webデザイナー募集',
                'content' => '当社では、優れたデザインスキルを持つWebデザイナーを募集しています。ユーザーに魅力的な体験を提供するデザインを作りたい方、ぜひご応募ください。経験者優遇です。',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => '営業アシスタント募集中！',
                'content' => '営業チームのアシスタントを募集しています。データ入力やスケジュール管理などの業務サポートをお願いします。オフィスワークが得意な方、ぜひご応募ください。',
                'seeking_thumbnail' => 'seeking_image_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'title' => 'グラフィックデザイナー募集！',
                'content' => '弊社では、優れたグラフィックデザイナーを募集しています。広告やパンフレットなどのデザイン制作をお任せします。クリエイティブな仕事に興味がある方、ぜひご応募ください。',
                'seeking_thumbnail' => 'seeking_image_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => '看護師募集！',
                'content' => '当病院では、経験豊富な看護師を募集しています。患者さんへのケアや医師のサポートをお任せします。充実した医療現場で働きたい方、ぜひご応募ください。',
                'seeking_thumbnail' => 'seeking_image_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => '飲食店ホールスタッフ募集！',
                'content' => '当店では、ホールスタッフを募集しています。お客様へのサービスやオーダー受けなどの業務をお願いします。元気で明るい方、ぜひご応募ください。',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'title' => 'システムエンジニア募集！',
                'content' => '当社では、システムエンジニアを募集しています。システム開発や保守、運用などに携わっていただきます。技術に自信のある方、ぜひご応募ください。',
                'seeking_thumbnail' => 'seeking_image_1.png',
                'created_at' => now(),
                'updated_at' =>now(),
            ],
            // 追加のシーキングデータをここに追記する
        ];

        // シーキングデータをデータベースに挿入
        DB::table('seekings')->insert($seekings);
    }
}
