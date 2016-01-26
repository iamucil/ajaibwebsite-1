<?php

namespace App\Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Modules\Merchant\Modules\VendorCategory', 'vendor_category_id');
    }
}
