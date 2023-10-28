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
            $table->id();
            $table->foreignId('like_from_user_id')->constrained('users');
            $table->foreignId('like_to_user_id')->constrained('users');
            //seekingが削除されたら、likeのレコードも削除される
            $table->foreignId('like_to_seeking_id')->constrained('seekings')->onDelete('cascade');
            $table->boolean('connected_flag')->default(false);
            $table->dateTime('connected_date')->nullable();
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
