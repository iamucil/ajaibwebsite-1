<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPhotoInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users', 'photo')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['photo']);
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('photo', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropColumn(['photo']);
        });
    }
}
