<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekingsTable extends Migration
{
    public function up()
    {
        Schema::create('seekings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title', 30);
            $table->string('content', 200);
            $table->string('seeking_thumbnail');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seekings');
    }
};
