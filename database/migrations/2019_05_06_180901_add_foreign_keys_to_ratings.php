<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->integer('fund_raiser_id')->index();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('fund_raiser_id')->references('id')->on('fund_raisers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIfExists('user_id');
            $table->dropIfExists('fund_raiser_id');
        });
    }
}
