<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\UpdateRequest;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function update(UpdateRequest $request)
    {
        $data = $request->validated();

        unset($data['passwordNew_confirmation']);
        $data['passwordNew'] = Hash::make($data['passwordNew']);

        $user = \auth()->user();

        if (Hash::check($data['password'], $user->password)) {
            $user->update(['password' => $data['passwordNew']]);
        } else {
            return \response(['errors' => ['password' => ['Password is not correct']]], '422');
        }
    }
}
