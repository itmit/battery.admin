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

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [ 
    //         'phone_number' => 'required',
    //     ]);
        
    //     if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }

    //     $number = $request->input('phone_number');
    //     $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    //     $phoneNumberObject = $phoneNumberUtil->parse($number, 'RU');
    //     $number = $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::E164);
    //     $request['phone_number'] = $number;

    //     $validator = Validator::make($request->all(), [ 
    //         'uid' => 'required|uuid', 
    //         'name' => 'required', 
    //         'phone_number' => 'required|unique:clients,phone_number',
    //         'password' => 'required|min:6',
    //         'role' => 'required'
    //     ]);
        
    //     if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }
 
    //     $tryRegister = Client::WhereRaw('phone_number='.$request['phone_number'].'')->first();

    //     if($tryRegister)
    //     {
    //         return $this->SendError('Authorization error', 'User already exist', 401);
    //     }

    //     $user = Client::create([
    //         'uid' => $request['uid'],
    //         'name' => $request['name'],
    //         'phone_number' => $request['phone_number'],
    //         'pole' => $request['role'],
    //         'password' => bcrypt($request['password']),
    //     ]);

    //     Auth::login($user);     

    //     if (Auth::check()) {
    //         $tokenResult = $user->createToken(config('app.name'));
    //         $token = $tokenResult->token;
    //         $token->expires_at = Carbon::now()->addWeeks(1);
    //         $token->save();

    //         return $this->sendResponse([
    //             'access_token' => $tokenResult->accessToken,
    //             'token_type' => 'Bearer',
    //             'expires_at' => Carbon::parse(
    //                 $tokenResult->token->expires_at
    //             )->toDateTimeString()
    //         ],
    //             'Authorization is successful');
    //     }
        
    //     return $this->SendError('Authorization error', 'Unauthorised', 401);
    // }

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
            return response()->json(['error'=>$validator->errors()], 401);            
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
                    )->toDateTimeString()
                ],
                    'Authorization is successful');
            }
        }

        return $this->SendError('Authorization error', 'Unauthorised', 401);
    }
    
}
