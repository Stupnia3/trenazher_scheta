<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalScoreToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_score_flash_anzan')->default(0);
            $table->integer('total_score_flash_cards')->default(0);
            $table->integer('total_score_division')->default(0);
            $table->integer('total_score_multiplication')->default(0);
            $table->integer('total_score_columns')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'total_score_flash_anzan',
                'total_score_flash_cards',
                'total_score_division',
                'total_score_multiplication',
                'total_score_columns',
            ]);
        });
    }
}


