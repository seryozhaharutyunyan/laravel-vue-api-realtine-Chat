<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Country\StoreRequest;
use App\Http\Requests\Country\UpdateRequest;
use App\Models\Chat;
use App\Models\Country;
use App\Models\Edge;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $countries=Country::paginate(15);

        return \response()->json($countries);
    }

    public function store(StoreRequest $request)
    {
        $data=$request->validated();

        Country::firstOrCreate(['name'=>$data['name']],$data);
    }

    public function update(UpdateRequest $request, Country $country)
    {
        $data=$request->validated();

        $country->update($data);
    }


    public function destroy(Country $country)
    {
        $edges=Edge::where('country_id', $country->id)->get();
        if(isset($edges) && !empty($edges)){
            foreach ($edges as $edge){
                Chat::where('edge_id', $edge->id)->delete();
                $edge->delete();
            }
        }
        $country->delete();
    }
}
