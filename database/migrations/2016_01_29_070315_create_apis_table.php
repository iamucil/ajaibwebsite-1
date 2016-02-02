<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('apis');
        Schema::create('apis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('name')->unique();
            $table->string('description', 255)->nullable();
            $table->string('base_url', 50)->nullable();
            $table->string('key', 255)->nullable();
            $table->string('params', 255)->nullable();
            $table->enum('method', ['POST', 'PUT', 'PATCH', 'GET', 'DELETE'])->nullable()->default('POST');
            $table->timestamps();

            $table->index('category_id');
            $table->engine = 'InnoDB';

            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onDelete('SET NULL');
        });

        DB::transaction(function () {
            DB::statement('ALTER TABLE apis DROP method;');
            DB::statement('DROP TYPE IF EXISTS api_method;');
            DB::statement('CREATE TYPE api_method AS ENUM (\'POST\', \'PUT\', \'PATCH\', \'GET\', \'DELETE\');');
            DB::statement("ALTER TABLE apis ADD method api_method");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('apis');
    }
}
