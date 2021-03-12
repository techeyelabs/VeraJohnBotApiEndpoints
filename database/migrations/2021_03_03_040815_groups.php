<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Groups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_name')->default('0');
            // $table->string('users')->default('0');
            $table->Integer('start_autobet_hour')->default('0');
            $table->Integer('start_autobet_min')->default('0');
            // $table->string('stop_autobet')->default('0');
            $table->Integer('stop_autobet_hour')->default('0');
            $table->Integer('stop_autobet_min')->default('0');
            $table->string('days')->default('0');
            $table->Biginteger('winning_double')->default('0');
            $table->Biginteger('negative_double')->default('0');
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
        Schema::dropIfExists('groups');
    }
}
