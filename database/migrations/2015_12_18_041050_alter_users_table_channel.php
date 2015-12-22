<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableChannel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * if using doctrine/tbal you should do following this to make column nullable
         * unfortunately to rollback you should use raw query
         */

        #Schema::table('users', function ($table) {
        #    $table->string('phone_number', 50)->nullable()->change();
        #});

        DB::transaction(function () {
            DB::statement("alter table users alter column phone_number set not null");
        });
        Schema::table('users', function ($table) {
            $table->char('channel', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->string('phone_number', 50)->nullable()->change();
        });
        Schema::table('users', function ($table) {
            $table->dropColumn('channel');
        });
    }
}
