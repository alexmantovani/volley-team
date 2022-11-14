<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_team', function (Blueprint $table) {
            $table->id();

            $table->foreignId('result_id');
            $table->foreignId('team_id');

            $table->boolean('visitor_team')->default(false);
            $table->boolean('winner')->default(false);

            $table->tinyInteger('set_wins')->default(0);

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
        Schema::dropIfExists('result_team');
    }
};
