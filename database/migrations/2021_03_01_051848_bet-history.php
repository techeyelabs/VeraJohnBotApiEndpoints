<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BetHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bet-history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->default('0');
            $table->string('target')->default('P');
            $table->boolean('result')->default('1');
            $table->bigInteger('aftermath')->default('0');
            $table->bigInteger('delta')->default('0');
            $table->string('table')->default('Bacarrat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bet-history');
    }
}
