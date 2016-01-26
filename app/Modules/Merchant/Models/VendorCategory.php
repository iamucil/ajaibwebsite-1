<?php

namespace App\Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    public function vendors()
    {
        return $this->hasMany('App\Modules\Merchant\Models\Vendor', 'vendor_category_id', 'id');
    }
}
