<?php

namespace App\Http\Controllers;

use App\Events\MsgReadEvent;
use App\Events\PrivateChatEvent;
use App\Http\Resources\ChatResource;
use Illuminate\Http\Request;
use App\Entities\Session;
use Carbon\Carbon;
class ChatController extends Controller
{
    public function send(Session $session, Request $request){
        $message = $session->messages()->create(['content'=> $request->content]);

        $chat =$message->createForSend($session->id);

        $message->reateForReceive($session->id, $request->to_user);

        $time = $message->created_at->diffForHumans();

        broadcast(new PrivateChatEvent($message->content, $chat, $time));

        return response([$chat->id, $time], 200);
    }

    public function chats(Session $session){

        $chats = $session->chats->where('user_id', auth()->id())->values();
        return ChatResource::collection($chats);
    }

    public function read(Session $session){
       $chats = $session->chats->where('read_at', null)
                       ->where('type', 0)
                       ->where('user_id', '!=', auth()->id());
        foreach ($chats as $chat){
            $chat->update(['read_at' => Carbon::now()]);
            broadcast(new MsgReadEvent(new ChatResource($chat), $chat->session_id));
        }
    }

    public function clear(Session $session){
        $session->deleteChat();

        $session->chats->count()==0?$session->deleteMessage():"";

        return response('cleared', 200);
    }
}
