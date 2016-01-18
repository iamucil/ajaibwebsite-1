<?php namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Menu\Models\RoleMenu;
use App\Modules\Menu\Models\ParentMenu;
class Menu extends Model {

    public function RoleMenus()
    {
        return $this->hasMany(RoleMenu::class);
    }

    public function parents()
    {
        return $this->belongsTo(ParentMenu::class, 'parent_id');
    }
}
