<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeekingIdToConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->unsignedBigInteger('seeking_id')->after('user_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->dropColumn('seeking_id');
        });
    }
}
