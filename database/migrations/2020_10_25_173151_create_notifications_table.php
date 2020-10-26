<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // 通知の発行者
            $table->bigInteger('publisher_id');
                
            $table->foreign('publisher_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            // 通知の受信者
            $table->bigInteger('subscriber_id');
            $table->foreign('subscribe_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            // 通知のタイプ
            $table->text('type');

            $table->bigInteger('reply_comment_id')->nullable(true);
            $table->foreign('reply_comment_id')->references('id')->on('comments')->onDelete('cascade')->onUpdate('cascade');

            $table->boolean('is_read')->default(false);

            $table->bigInteger('follow_id')->nullable(true);
                
            $table->foreign('follow_id')->references('id')->on('following_users')->onDelete('cascade')->onUpdate('cascade');

            $table->bigInteger('favorite_id')->nullable(true);
            $table->foreign('favorite_id')->references('id')->on('favorites')->onDelete('cascade')->onUpdate('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
