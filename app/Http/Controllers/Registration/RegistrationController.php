<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;
use App\Http\Requests\Registration\ResetRequest;
use App\Http\Requests\Registration\StoreRequest;
use App\Mail\PasswordMail;
use App\Models\Country;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{

    public function index()
    {
        $countries = Country::all();

        return \response()->json($countries);
    }

    public function store(StoreRequest $request)
    {
        $data  = $request->validated();
        $roles = Role::all();
        $path  = ('storage/' . Storage::disk('public')->
            put('img/users/' . $data['email'], $data['img']));
        $url   = \url($path);
        unset($data['img']);

        foreach ($roles as $role) {
            if ($role->role === 'user') {
                $data['role_id'] = $role->id;
            }
        }

        $password         = Str::random(10);
        $data['password'] = Hash::make($password);

        $image = Image::create([
            'path' => $path,
            'url'  => $url,
        ]);

        $data['image_id'] = $image->id;

        User::create($data);
        Mail::to($data['email'])->send(new PasswordMail($password));

        return \response('Your password has been sent to your email address.');
    }


    public function reset(ResetRequest $request)
    {
        $data=$request->validated();

        $user=User::where('email', $data['email'])->first();

        $password         = Str::random(10);
        $passwordData = Hash::make($password);

        $user->update([
            'password'=>$passwordData
        ]);
        Mail::to($data['email'])->send(new PasswordMail($password));

        return \response('Your password has been sent to your email address.');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
    }
}
