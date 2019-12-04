<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AuthController extends ApiBaseController
{
    public $successStatus = 200;

    /** 
     * login api 
     * 
     * @return Response 
     */ 
    public function login(Request $request) { 

        $validator = Validator::make($request->all(), [ 
            'login' => 'required',
            'password' => 'required|min:6'
        ]);
        
        if ($validator->fails()) {     
            return $this->sendError($validator->errors()->first(), "Validation error", 401);
        }

        $client = Client::where('login', '=', $request['login'])->first();        

        if ($client != null) {
            if (Hash::check(request('password'), $client->password))
            {
                Auth::login($client);
            }
            else
            {
                return $this->SendError('Authorization error', 'Wrong password', 401);
            }

            if (Auth::check()) {
                $tokenResult = $client->createToken(config('app.name'));
                $token = $tokenResult->token;
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();

                return $this->sendResponse([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                    'uid' => $client->uid,
                    'role' => $client->role
                ],
                    'Authorization is successful');
            }
        }

        return $this->SendError('Authorization error', 'Unauthorised', 401);
    }
    
}
