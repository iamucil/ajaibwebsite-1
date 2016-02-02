<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropIndexCategoryVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('vendors', 'vendor_category_id')) {
            Schema::table('vendors', function (Blueprint $table) {
                // $table->dropForeign('vendor_category_id');
                // $table->dropForeign('vendors_vendor_category_id_foreign');
                // $table->dropIndex('vendor_category_id');
                $table->dropColumn('vendor_category_id');
            });
        }

        Schema::table('vendors', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->after('id');

            $table->index('category_id');

            $table->foreign('category_id')
                  ->references('id')->on('categories')
                  ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
        });
    }
}
