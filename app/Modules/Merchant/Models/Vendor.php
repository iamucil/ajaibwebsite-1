<?php

namespace App\Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable  = ['name'];
    public function category()
    {
        return $this->belongsTo('App\Modules\Merchant\Models\VendorCategory', 'vendor_category_id');
    }
}
