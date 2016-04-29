<?php namespace App\Modules\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

	protected $table   = 'transactions';

    public function Category()
    {
        return $this->belongsTo('App\Modules\Transaction\Models\Category');
    }

    public function TransactionDetails()
    {
        return $this->hasMany('App\Modules\Transaction\Models\TransactionDetail');
    }

    public function Assigne()
    {
        return $this->belongsTo('App\User', 'operator_id', 'id');
    }

    public function AccountPayable()
    {
        return $this->belongsTo('App\User', 'customer_id', 'id');
    }

    public function vendors()
    {
        return $this->belongsTo('App\Modules\Merchant\Models\Vendor', 'vendor_id', 'id');
    }

}
