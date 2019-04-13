<?php

namespace App\Http\Controllers;

use App\Entities\Session;
use App\Events\SessionEvent;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create(Request $request){
      $session = Session::create(['user1_id'=>auth()->id(),
                                  'user2_id'=>$request->friend_id]);

      $modify_session = new SessionResource($session);
      broadcast(new SessionEvent($modify_session, auth()->id()));
      return $modify_session;
    }
}
