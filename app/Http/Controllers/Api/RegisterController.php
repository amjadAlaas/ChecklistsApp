<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
            'img' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->img = $request->img;
        $user->save();
        $token = $user->createToken($user->id);
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
