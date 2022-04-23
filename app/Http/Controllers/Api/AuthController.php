<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function forgotPassword($email)
    {
        $characters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
        $pin = mt_rand(100,999) . mt_rand(100,999) . $characters[rand(0,strlen($characters) -1)];
        $password = str_shuffle($pin);
        $user = User::where('email',$email)->first();
        $user->password = Hash::make($password);
        $user->update();

        $response = Http::post('http://sms.codeitapps.com/api/v3/sms?',[
            'token' => 's3Xs93M1KgsjARbH1611QG8zKSitQjY4k7gz',
            'to' => $user->mobile,
            'sender' => 'Demo',
            'message' => "Dear " .$user->name . "\nYour New passowrd is $password\n\nExpenses Management"
        ]);

        return response()->json(['message' => "We have sent new password in your mobile"]);


    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'mobile' => 'required',
        ]);


        if($validator->fails()){
            return response()->json(['message','Bad Request']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'Account Created Successfully'
        ]);

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['message','Bad Request']);
        }

        $credentials  = request(['email','password']);

        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Unauthorized'
            ]);
        }

        $user = User::where('email',$request->email)->first();
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            "message" => "success",
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Token Deleted'
        ]);
    }
}
