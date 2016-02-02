<?php

namespace App\Modules\Merchant\Models;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $table        = 'categories';
    protected $fillable     = ['name'];
    public function vendors()
    {
        return $this->hasMany('App\Modules\Merchant\Models\Vendor', 'category_id', 'id');
    }
}
