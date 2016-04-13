<?php namespace App\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {

    protected $table = 'chats';
    protected $fillable = ['sender_id','receiver_id','message','ip_address','useragent','read','file_type'];

}