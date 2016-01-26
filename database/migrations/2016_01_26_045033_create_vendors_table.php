<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('vendors');
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_category_id')->unsigned();
            $table->string('name', 100)->unique();
            $table->string('description', 255)->nullable();
            $table->string('api', 100)->nullable();
            $table->enum('method', ['POST', 'PUT', 'GET', 'DELETE'])->nullable();
            $table->string('key', 255)->nullable();
            $table->string('params', 255)->nullable();
            $table->timestamps();

            $table->index('vendor_category_id');
            $table->engine = 'InnoDB';

            $table->foreign('vendor_category_id')
                  ->references('id')->on('vendor_categories')
                  ->onDelete('SET NULL');
        });

        DB::transaction(function () {
            DB::statement('ALTER TABLE vendors DROP method;');
            DB::statement('DROP TYPE IF EXISTS api_method;');
            DB::statement('CREATE TYPE api_method AS ENUM (\'POST\', \'PUT\', \'GET\', \'DELETE\');');
            DB::statement("ALTER TABLE vendors ADD method api_method");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vendors');
    }
}
