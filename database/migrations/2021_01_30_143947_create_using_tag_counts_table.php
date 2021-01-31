<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsingTagCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('using_tag_counts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('count');
            $table->foreignId('user_id')->constraind();
            $table->foreignId('tag_id')->constraind();
            $table->unique(['user_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('using_tag_counts');
    }
}
