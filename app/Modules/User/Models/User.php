<?php namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'users';
    protected $fillable = ['name','email','firstname','lastname','phone_number','address','gender'];

}
