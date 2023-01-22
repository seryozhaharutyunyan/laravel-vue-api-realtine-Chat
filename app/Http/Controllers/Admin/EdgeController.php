<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Edge\StoreRequest;
use App\Http\Requests\Edge\UpdateRequest;
use App\Models\Chat;
use App\Models\Country;
use App\Models\Edge;

class EdgeController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        $edges     = Edge::paginate(15);

        return \response()->json([
            'edges'     => $edges,
            'countries' => $countries,
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Edge::firstOrCreate($data);
    }

    public function update(UpdateRequest $request, Country $country)
    {
        $data = $request->validated();

        $country->update($data);
    }


    public function destroy(Edge $edge)
    {
        $chats = Chat::where('edge_id', $edge->id)->get();
        if (isset($chats) && !empty($chats)) {
            foreach ($chats as $chat) {
                $chat->delete();
            }
        }
        $edge->delete();
    }
}
