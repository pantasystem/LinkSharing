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

            // 2 ^ 16 以上入力されることは想定していないのでTEXT型を指定する
            $table->text('url');
            $table->text('text');
            $table->bigInteger('author_id');
            $table->bigInteger('favorite_count')->default(0);

            $table->foreign('author_id')->references('id')->on('users')
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
        Schema::dropIfExists('notes');
    }
}
