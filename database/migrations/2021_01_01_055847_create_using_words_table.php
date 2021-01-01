<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsingWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('using_words', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('summary_id')->constrained('summaries')->onDelete('cascade');
            $table->foreignId('word_id')->constrained('words')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('using_words');
    }
}
