<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterChatTableSetNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
        Schema::table('users', function ($table) {
            $table->string('read', 50)->nullable()->change();
            $table->string('useragent', 50)->nullable()->change();
        });
        */
        DB::transaction(function () {
            DB::statement("alter table chats alter column read drop not null");
            DB::statement("alter table chats alter column useragent drop not null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function () {
            DB::statement("alter table chats alter column read set not null");
            DB::statement("alter table chats alter column useragent set not null");
        });
    }
}
