<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        $roles     = Role::all();

        return \response()->json([
            'countries' => $countries,
            'roles'     => $roles,
        ]);
    }

    public function block(User $user)
    {
        if ($user->block === 1) {
            $user->update([
                'block' => 0,
            ]);
        } else {
            $user->update([
                'block' => 1,
            ]);
        }
    }

    public function role(Request $request, User $user)
    {
        $data = $request->all();

        $user->update([
            'role_id' => $data['role_id'],
        ]);
    }

    public function search(Request $request)
    {
        $text = $request->text;

        $users = User::where('name', 'LIKE', "%${text}%")
                     ->orWhere('email', 'LIKE', "%${text}%")
                     ->paginate(15);

        return \response()->json($users);
    }

    public function destroy(User $user)
    {
        $messages=Message::where('user_id', $user->id)->get();
        if(isset($messages) && !empty($messages)){
            foreach ($messages as $message){
                $message->delete();
            }
        }
        \unlink($user->image->path);
        $user->delete();
    }
}
