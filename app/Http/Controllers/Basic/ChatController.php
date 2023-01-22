<?php

namespace App\Http\Controllers\Basic;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Message\StoreRequest;
use App\Models\Chat;
use App\Models\Message;


class ChatController extends Controller
{
    public function index(Chat $chat)
    {
        $messages=Message::where('chat_id', $chat->id)->orderBy('id', 'desc')->limit(25)->get();

        return \response()->json([
            'messages'=>$messages,
            'chat'=>$chat,
            ]);
    }

    public function store(StoreRequest $request){
        $data=$request->validated();

        Message::create($data);

        $messages=Message::where('chat_id', $data['chat_id'])->orderBy('id', 'desc')->limit(25)->get();
        \event(new NewMessage($data['chat_id'], \auth()->user(), $messages));

        return \response('ok', 200);
    }
}
