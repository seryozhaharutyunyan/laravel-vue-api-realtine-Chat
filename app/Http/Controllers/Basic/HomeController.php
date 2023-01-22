<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Country;
use App\Models\Edge;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Country $country){
        $edges=Edge::where('country_id', $country->id)->get();

        return \response()->json($edges);
    }

    public function show(Edge $edge){
        $chats=Chat::where('edge_id', $edge->id)->get();

        return \response()->json($chats);
    }
}
