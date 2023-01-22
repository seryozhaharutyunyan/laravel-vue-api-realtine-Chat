<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{

    public function index()
    {
        $countries=Role::paginate(15);

        return \response()->json($countries);
    }

    public function store(StoreRequest $request)
    {
        $data=$request->validated();

        Role::firstOrCreate(['role'=>$data['role']],$data);
    }

    public function update(UpdateRequest $request, Role $role)
    {
        $data=$request->validated();

        $role->update($data);
    }


    public function destroy(Role $role)
    {
        $roles=Role::all();
        $ids=[];
        foreach ($roles as $r){
            if($r->role==='user'){
                $ids[]=$r->id;
            }elseif ($r->role==='admin'){
                $ids[]=$r->id;
            }
        }
        foreach ($ids as $id){
            if($role->id===$id){
                return response('Cannot be deleted', '442');
            }
        }


        $users=User::where('role_id', $role->id)->get();
        if(isset($users) && !empty($usere)){
            foreach ($users as $user){
                $user->update([
                    'role_id'=>$id
                ]);
            }
        }
        $role->delete();
    }
}
