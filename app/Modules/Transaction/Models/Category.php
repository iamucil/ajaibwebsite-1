<?php
namespace App\Modules\Transaction\Models;
use Illuminate\Database\Eloquent\Model;

/**
* FILENAME     : Category.php
* @package     : Category
*/
class Category extends Model
{
    protected $table = 'categories';

    public function Transactions()
    {
        return $this->hasMany('App\Modules\Transaction\Models\Transaction');
    }
}
?>