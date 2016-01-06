<?php namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Menu\Models\RoleMenu;
class Menu extends Model {

    public function RoleMenus()
    {
        return $this->hasMany(RoleMenu::class);
    }

}
