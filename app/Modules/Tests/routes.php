<?php

Route::group(array('module' => 'Tests', 'namespace' => 'App\Modules\Tests\Controllers'), function() {

    Route::get('tests/upload' , 'TestsController@upload');
    Route::post('tests/upload/process' , 'TestsController@process');

});	