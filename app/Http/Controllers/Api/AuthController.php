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

    public function register(Request $request)
    {
        $number = $request->input('phone_number');
        $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $phoneNumberObject = $phoneNumberUtil->parse($number, 'RU');
        $number = $phoneNumberUtil->format($phoneNumberObject, \libphonenumber\PhoneNumberFormat::E164);
        $request['phone_number'] = $number;

        $validator = Validator::make($request->all(), [ 
            'uid' => 'required|uuid', 
            'name' => 'required', 
            'phone_number' => 'required|unique:clients,phone_number',
            'password' => 'required|min:6',
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
 
        $tryRegister = Client::WhereRaw('email = "' . $input['email'] . '" or phone = "' . $input['phone'] . '" or uid = "' . $input['uid'] . '" and phone <> "' . $input['phone'] . '"')->first();

        if($tryRegister)
        {
            return $this->SendError('Authorization error', 'User already exist', 401);
        }

        $user = Client::create([
            'uid' => $input['uid'],
            'name' => $input['name'],
            'phone_number' => $input['phone_number'],
            'password' => bcrypt($input['password']),
        ]);

        Auth::login($user);     

        if (Auth::check()) {
            $tokenResult = $user->createToken(config('app.name'));
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
        
        return $this->SendError('Authorization error', 'Unauthorised', 401);
    }
    
}
