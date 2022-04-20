<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        $request->merge([
            'password' => bcrypt($request->password),
            'type' => 'user'
        ]);

        $user = User::create($request->all());

        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('my-app-token')->plainTextToken;

        return response()->api($data);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;

            return response()->api($data);
        } else {

            return response()->api([], 1, __('auth.failed'));
        }
    }

    public function logout()
    {
        $user = auth()->user();

        if ($user->tokens()->delete()) {
            return response()->api([]);
        } else {
            return response()->api([], 1, 'something went wrong!');
        }
    }

    public function user()
    {
        $user = Auth::user();

        $data['user'] = new UserResource($user);

        return response()->api($data);
    }
}
