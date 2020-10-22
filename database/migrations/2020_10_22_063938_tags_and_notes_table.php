<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TagsAndNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tags_and_notes', function(Blueprint $table){
            $table->id();
            $table->bigInteger('note_id');
            $table->bigInteger('tag_id');
            $table->timestamps();


            $table->foreign('note_id')->references('id')->on('notes')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        //Schema::dropIfExists('tags_and_notes_id_seq');

        Schema::dropIfExists('tags_and_notes');

    }
}
