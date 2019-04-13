<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded=[];

    public function chats(){
        return $this->hasMany(Chat::class);
    }

    public function createForSend($session_id){
      return  $this->chats()->create([
             'session_id' => $session_id,
             'user_id' => auth()->id(),
             'type' => 0
        ]);
    }

    public function reateForReceive($session_id, $to_user){
      return  $this->chats()->create([
            'session_id' => $session_id,
            'user_id' => $to_user,
            'type' => 1
        ]);
    }
}
