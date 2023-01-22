<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreRequest;
use App\Http\Requests\Chat\UpdateRequest;
use App\Models\Chat;
use App\Models\Country;
use App\Models\Edge;
use App\Models\Message;

class ChatController extends Controller
{

    public function index()
    {
        $countries = Country::all();

        return \response()->json($countries);
    }

    public function show(Edge $edge)
    {
        $chats = Chat::where('edge_id', $edge->id)->paginate(15);

        return \response()->json($chats);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        unset($data['country_id']);
        $chat=Chat::where('edge_id', $data['edge_id'])->where('name', $data['name'])->first();
        if(isset($chat) && !empty($chat)){
            return;
        }
        Chat::create($data);
    }

    public function update(UpdateRequest $request, Chat $chat)
    {
        $data = $request->validated();

        $chat->update($data);
    }


    public function destroy(Chat $chat)
    {
        $messages=Message::where('user_id', $chat->id)->get();
        if(isset($messages) && !empty($messages)){
            foreach ($messages as $message){
                $message->delete();
            }
        }
        $chat->delete();
    }
}
