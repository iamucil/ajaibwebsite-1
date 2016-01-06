<?php namespace App\Modules\Roles\Models;

use Zizaco\Entrust\EntrustRole;
use namespace App\Modules\Roles\Models\Menu;
use namespace App\Modules\Roles\Models\RoleMenu;
class Role extends EntrustRole {

    public function menus()
    {
        return $this->hasManyThrough(Menu::class, RoleMenu::class, 'role_id', 'menu_id');
    }

}