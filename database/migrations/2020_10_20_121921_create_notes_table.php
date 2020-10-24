<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('text');
            $table->bigInteger('author_id');
            $table->bigInteger('summary_id');

            $table->foreign('author_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('summary_id')->references('id')->on('summaries')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
