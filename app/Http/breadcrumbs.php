<?php
Breadcrumbs::register('admin::dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', route('admin::dashboard'));
});

// Breadcrumbs::register('user.list', function($breadcrumbs) {
//     $breadcrumbs->parent('admin::dashboard');
//     $breadcrumbs->push('Daftar User', route('user.list'));
// });

// Breadcrumbs::register('user.add', function($breadcrumbs) {
//     $breadcrumbs->parent('user.list');
//     $breadcrumbs->push('Create', route('user.add'));
// });

// Breadcrumbs::register('user.list', function($breadcrumbs)
// {
//     $breadcrumbs->parent('photo.index');
//     $breadcrumbs->push('Upload Photo', route('photo.create'));
// });
//
$route_collections  = Route::getRoutes();
foreach ($route_collections as $collection) {
    if(!is_null($collection->getName())){
        $route_name     = $collection->getName();
        if($route_name != 'admin::dashboard') {
            Breadcrumbs::register($route_name, function ($breadcrumbs, $page = null) use ($route_name){
                $breadcrumbs->parent('admin::dashboard');
                $title  = str_replace('.', ' ', $route_name);
                if(!is_null($page)){
                    $title  = (isset($page->title)) ?: $title;
                }else{
                    $title  = str_replace('.', ' ', $route_name);
                }
                $breadcrumbs->push($title, route($route_name));
            });
        }
    }
}
?>