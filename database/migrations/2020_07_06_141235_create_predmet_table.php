<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePredmetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predmet', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('name_id');
            $table->unsignedBigInteger('teacher_id');
            $table->integer('score')->default(0);
            $table->foreign('name_id')->references('id')->on('students');
            $table->foreign('teacher_id')->references('id')->on('teachers');

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
        Schema::dropIfExists('predmet');
    }
}
