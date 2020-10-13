<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    public $successStatus = 200;
    // Api lấy data từ form
    // 

    public function login(Request $request)
    {
        
        if (Auth::attempt(
            [
                'email' => request('email'),
                'password' => request('password')
            ]
        )) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(
                [
                    'success' => $success
                ],
                $this->successStatus
            );
        }
        else {
            return response()->json(
                [
                    'error' => 'Unauthorised'
                ], 401);
        }
    }


    public function register(Request $request)
    {
        
                 $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'error' => $validator->errors()
                ], 401);
        }
        $check= User::where('email',$request->email)->first();
        if($check){
            return  response()->json(["error"=>"Email da ton tai"]);
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(
            [
                'success' => $success
            ],
            $this->successStatus
        );

    }



    //  Api lấy data từ token (header)
    //  Authorization   có giá trị là: Bearer Token
    // 
    // 
    public function details(Request $request)
    {
        return response()->json($request->user());
    }
    public function logout(Request $request)
    {
        // Xóa token của user
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out']);
    }
}
