<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAvatarDefaultValueInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // 既存の avatar 列の既定値を変更する
            $table->string('avatar')->default('default-avatar.png')->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // ロールバック時の操作（この場合、既定値の変更を元に戻す）
            $table->string('avatar')->nullable()->change();
        });
    }
}
