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
            $table->bigInteger('publisher_id')
                ->foreign('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            // 通知の受信者
            $table->bigInteger('subscriber_id')
                ->foreign('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            // 通知のタイプ
            $table->text('type');

            $table->bigInteger('reply_id')->nullable(true);

            $table->boolean('is_read')->default(false);




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
