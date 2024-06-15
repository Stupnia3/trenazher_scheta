<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionIdToGameSettingsAndGameResults extends Migration
{
    public function up()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->uuid('session_id')->nullable()->after('id'); // Допускаем NULL
        });

        Schema::table('game_results', function (Blueprint $table) {
            $table->uuid('session_id')->nullable()->after('id'); // Допускаем NULL
        });
    }

    public function down()
    {
        Schema::table('game_settings', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });

        Schema::table('game_results', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
}

