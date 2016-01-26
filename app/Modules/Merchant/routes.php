<?php

Route::group(['module' => 'Merchant', 'namespace' => 'App\Modules\Merchant\Controllers', 'prefix' => 'dashboard', 'middleware' => ['auth', 'csrf', 'role:admin|root']], function() {

    Route::resource('vendors', 'VendorController', [
        'names' => [
            'create'    => 'vendor.create',
            'index'     => 'vendor.index',
            'store'     => 'vendor.store',
            'edit'      => 'vendor.edit',
            'delete'    => 'vendor.delete',
            'update'    => 'vendor.update',
            'show'      => 'vendor.show',
            'destroy'   => 'vendor.destroy',
        ]
    ]);

    Route::resource('vendor-categories', 'VendorCategoryController', [
        'names' => [
            'create'    => 'vendor.category.create',
            'index'     => 'vendor.category.index',
            'store'     => 'vendor.category.store',
            'edit'      => 'vendor.category.edit',
            'delete'    => 'vendor.category.delete',
            'update'    => 'vendor.category.update',
            'show'      => 'vendor.category.show',
            'destroy'   => 'vendor.category.destroy',
        ]
    ]);
});