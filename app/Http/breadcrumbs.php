<?php
Breadcrumbs::register('admin::dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Dashboard', route('admin::dashboard'));
});

Breadcrumbs::register('user.list', function($breadcrumbs) {
    $breadcrumbs->parent('admin::dashboard');
    $breadcrumbs->push('Daftar User', route('user.list'));
});

Breadcrumbs::register('user.add', function($breadcrumbs) {
    $breadcrumbs->parent('user.list');
    $breadcrumbs->push('Create', route('user.add'));
});

// Breadcrumbs::register('user.list', function($breadcrumbs)
// {
//     $breadcrumbs->parent('photo.index');
//     $breadcrumbs->push('Upload Photo', route('photo.create'));
// });
?>