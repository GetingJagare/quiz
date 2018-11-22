<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarkExpertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_experts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id', false, true)->index();
            $table->integer('report_id', false, true)->index();

            $table->tinyInteger('novelty');
            $table->tinyInteger('study');
            $table->tinyInteger('worth');
            $table->tinyInteger('representation');
            $table->tinyInteger('efficiency');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');

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
        Schema::dropIfExists('mark_experts');
    }
}
