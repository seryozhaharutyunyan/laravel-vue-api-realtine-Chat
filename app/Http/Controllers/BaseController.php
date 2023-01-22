<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Edge;
use App\Models\User;

class BaseController extends Controller
{
    public function getEdges(Country $country){
        $edges=Edge::where('country_id', $country->id)->get();

        return \response()->json($edges);
    }

    public function getUsers(Country $country){
        $users=User::where('country_id', $country->id)->paginate(15);

        return \response()->json($users);
    }
}
