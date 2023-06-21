<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            //紐づくユーザーが削除（退会等）されたらいいねも削除
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            //紐づくアイテムが削除されたらいいねも削除
            $table->integer('seeking_id')->references('id')->on('seekings')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
