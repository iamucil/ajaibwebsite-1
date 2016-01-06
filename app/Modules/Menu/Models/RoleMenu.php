<?php

namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Menu\Models\Menu;
class RoleMenu extends Model
{
    protected $table = 'role_menu';

    public function menus()
    {
        return $this->belongsTo(Menu::class);
    }
}
