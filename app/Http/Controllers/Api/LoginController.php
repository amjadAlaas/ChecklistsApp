<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiResponseTrait;
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            $token = $user->createToken($user->id);
            return $this->apiResponse($token, "login Successfuly", 200);

            // return response()->json(['message' => 'Login successful']);
        } else {
            // Email or password is incorrect
            return $this->apiResponse(null, 'Email or password is incorrect', 401);
        }

    }
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return $this->apiResponse(null, 'Logged out successfully', 200);
    }
}
