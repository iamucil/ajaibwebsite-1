<?php

    Route::group ([
        'module'     => 'Transaction',
        'namespace'  => 'App\Modules\Transaction\Controllers',
        'prefix'     => 'ajaib',
        'middleware' => 'auth',], function () {

        Route::resource ('transactions', 'TransactionsController', [
            'names' => [
                'create'  => 'transactions.create',
                'index'   => 'transactions.index',
                'store'   => 'transactions.store',
                'edit'    => 'transactions.edit',
                'delete'  => 'transactions.delete',
                'update'  => 'transactions.update',
                'show'    => 'transactions.show',
                'destroy' => 'transactions.destroy',
            ],
        ]);

        Route::resource ('transaction-categories', 'CategoriesController', [
            'names' => [
                'create'  => 'transaction.category.create',
                'index'   => 'transaction.category.index',
                'store'   => 'transaction.category.store',
                'edit'    => 'transaction.category.edit',
                'delete'  => 'transaction.category.delete',
                'update'  => 'transaction.category.update',
                'show'    => 'transaction.category.show',
                'destroy' => 'transaction.category.destroy',
            ],
        ]);        
    });




    Route::group ([
        'module'     => 'Transaction',
        'namespace'  => 'App\Modules\Transaction\Controllers',
        'prefix'     => 'dashboard',
        'middleware' => 'auth',], function () {

        Route::get('/transactions/invoice/{invoice}/{print?}', 'TransactionsController@printInvoice')->name('transactions.invoice.print');
        // Route::group(['prefix' => 'invoice/{transaction}'], function() {
        //     Route::get('/pdf', 'TransactionsController@exportInvoice')->name('transactions.invoice.export');
        //     Route::get('/print', 'TransactionsController@printInvoice')->name('transactions.invoice.print');
        // });

        // Route::get('/transactions/invoice/{invoice}/pdf', 'TransactionsController@exportInvoice')->name('transactions.invoice');
        // Route::get('/transactions/invoice/{invoice}', 'TransactionsController@printInvoice')->name('transactions.invoice');
    });