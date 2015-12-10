<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->engine  = 'InnoDB';
            $table->increments('id');
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_id')->nullable()->unsigned();
            $table->text('message');
            $table->string('ip_address', 100);
            $table->string('useragent', 100);
            $table->timestamp('read')->nullable;
            $table->timestamps();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chats');
    }
}
