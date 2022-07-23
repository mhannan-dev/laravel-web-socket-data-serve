<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PassportController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }
        //Get authenticated admin
        $admin = User::where('email', $request->email)->first();
        //Check Above Admin
        if ($admin) {
            if (Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('LaravelPassportClient')->accessToken;
                return response()->json(
                    ['message' => 'You are logged in', 'token' => $token],
                    200
                );
            } else {
                $response = ["message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'Wrong credentials! please input correct email and password'];
            return response($response, 422);
        }
    }

}
