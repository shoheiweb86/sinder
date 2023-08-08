<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->enum('grade', ['1年生', '2年生', '3年生', '4年生', '5年生', '6年生', '院1年生', '院2年生'])->nullable();;
            $table->enum('faculty', ['人文学部', '教育学部', '法学部', '経済科学部', '理学部', '医学部医学科', '医学部保健学科', '歯学部', '工学部', '農学部', '創生学部', '教育実践学研究科', '現代社会文化研究科', '自然科学研究科', '保健学研究科', '医歯学総合研究科'])->nullable();
            $table->enum('sex', ['男性', '女性'])->nullable();;
            $table->string('self_introduction', 200)->nullable();
            $table->string('avatar')->default('default-avatar.png');
            $table->string('line_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->boolean('registered_sns_flag')->default(false);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
        });

        // データを更新してフラグを立てる
        DB::table('users')->whereNotNull('line_link')
            ->orWhereNotNull('twitter_link')
            ->orWhereNotNull('instagram_link')
            ->update(['registered_sns_flag' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
