<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, EntrustUserTrait {
        EntrustUserTrait::can insteadof Authorizable;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone_number','channel','verification_code', 'country_id',];
    // protected $guarded  = ['name', 'email'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    protected $maps     = ['name' => 'myname'];
    public function country()
    {
        return $this->belongsTo('App\Country', 'country_id', 'id');
    }

    public function senders()
    {
        return $this->hasMany('App\Modules\Chat\Models\Chat', 'sender_id', 'id');
    }

    public function receivers()
    {
        return $this->hasMany('App\Modules\Chat\Models\Chat', 'receiver_id', 'id');
    }

    // public function roles()
    // {
    //     return $this->hasMany('App\RoleUser', 'user_id', 'id');
    // }
}
