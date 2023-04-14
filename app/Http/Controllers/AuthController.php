<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Info;

class AuthController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:7',
            'confirm_password' => 'required|same:password',
            'phone_number' => 'required|numeric|digits:10'
        ]);
    }

    public function register(Request $request)
    {
        $validatedData = $this->validator($request->all());
        if ($validatedData->fails())  {
            return response()->json(['errors'=>$validatedData->errors()]);
        }

        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'user_name' => $request['user_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'phone_number' => $request['phone_number']
        ]);
        $user->save();

        $info = Info::create([
            'user_id' => $user->id,
        ]);
        $info->save();

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password'))){

            $user = User::where('email', $request['email'])->firstOrFail();

        }else if (Auth::attempt($request->only('user_name', 'password'))) {

            $user = User::where('user_name', $request['user_name'])->firstOrFail();

        }else{
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:7',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        if(!Hash::check($request->old_password, $user->password)){
            return response()->json(['errors'=>'The password is incorrect']);
        }

        $user->password = Hash::make($request['new_password']);
        $user->save();

        return response()->json(['data' => 'change password done '],403);
    }

    public function logout () {
        $token = Auth::user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response()->json($response, 200);
    }
}
