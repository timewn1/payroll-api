<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $msg = 'Invalid credentials';
            return response()->json(['msg' => $msg], 401);
        }

        User::removeStoredToken(Auth::user()->id);

        $token = $request->user()->createToken('auth-token');
        return response(['token' => $token->plainTextToken]);
    }

    public function logout()
    {
        auth()->logout();
    }
}
