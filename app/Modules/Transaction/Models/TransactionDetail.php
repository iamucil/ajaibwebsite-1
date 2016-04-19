<?php
/**
* FILENAME     : TransactionDetail.php
* @package     : TransactionDetail
*/
namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table    = 'transaction_details';

    protected $fillable     = ['quantity', 'quantity_id', 'amount', 'keterangan', 'item',];

    public function transaction()
    {
        return $this->belongsTo('App\Modules\Transaction\Models\Transaction', 'transaction_id');
    }
}
?>