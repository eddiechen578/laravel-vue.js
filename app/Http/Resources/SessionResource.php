<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use DB;
use Carbon\Carbon;
class SessionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $chat = DB::table('Sessions')
            ->join('Messages', 'Messages.session_id', '=', 'Sessions.id')
            ->join('Chats', 'Chats.message_id', '=', 'Messages.id')
            ->select('Chats.*')
            ->where('type', 0)
            ->where('user_id', '!=', auth()->id())
            ->orderBy('created_at', 'desc')
            ->first();

        $chat?$time = Carbon::parse($chat->created_at)->diffForHumans(Carbon::now()):$time="";

        return [
            'id' => $this->id,
            'open' => false,
            'user' => [$this->user1_id, $this->user2_id],
            'unreadCount' => $this->chats->where('read_at', null)
                             ->where('type', 0)
                             ->where('user_id', '!=', auth()->id())
                             ->count(),
            'unreadTime' =>  $time,
            'block' => !!$this->block,
            'blocked_by' => $this->blocked_by
        ];
    }
}
