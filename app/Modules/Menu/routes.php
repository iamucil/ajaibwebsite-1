<?php

Route::group(array('module' => 'Menu', 'namespace' => 'App\Modules\Menu\Controllers'), function() {

    Route::resource('Menu', 'MenuController');
    
});	