<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('transactions')->delete();
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('number', 50)->unique()->after('id');
            $table->integer('customer_id')->nullable();
            $table->integer('operator_id')->nullable();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('operator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
