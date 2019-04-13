<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Carbon\Carbon;
class ChatResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message['content'],
            'id' => $this->id,
            'type'=> $this->type,
            'read_at' => $this->read_at_timing($this),
            'send_at' => $this->created_at->diffForHumans()
        ];
    }

    private function read_at_timing($_this){
        $read_at = $_this->type == 0? $this->read_at: null;
        return $read_at? Carbon::parse($read_at)->diffForHumans(): null;
    }
}
