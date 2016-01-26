<?php

Route::group(['module' => 'Merchant', 'namespace' => 'App\Modules\Merchant\Controllers', 'prefix' => 'dashboard'], function() {

    Route::resource('vendors', 'VendorController');
    Route::resource('vendor-categories', 'VendorCategoryController');
});