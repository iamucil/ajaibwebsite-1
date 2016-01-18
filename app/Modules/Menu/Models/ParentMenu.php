<?php
namespace App\Modules\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Menu\Models\Menu;

class ParentMenu extends Model {

    protected $table    = 'menus';

    public function menus()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }
}
?>