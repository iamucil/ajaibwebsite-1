<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableChatAddPathField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            DB::statement("alter table chats ADD path character varying(255)");
            DB::statement("ALTER TABLE chats ALTER message DROP NOT NULL");
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
        DB::transaction(function () {
            DB::statement("alter table chats DROP COLUMN path");
            DB::statement("ALTER TABLE chats ALTER message SET NOT NULL");
        });
    }
}
