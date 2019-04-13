<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Chat extends Model
{
    protected $guarded=[];


    public function message(){
        return $this->belongsTo(Message::class);
    }

}
