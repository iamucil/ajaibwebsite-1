<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTabl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create menus table
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('parent_id')->index();
            $table->integer('name')->index();
            $table->integer('description')->index();
            $table->integer('route')->index();
            $table->timestamps();
        });

        // Create table for associating roles to menus (Many-to-Many)
        Schema::create('role_menu', function (Blueprint $table) {
            $table->integer('menu_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('menu_id')->references('id')->on('menus')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['menu_id', 'role_id']);
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
    }
}
