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

class ClientController extends ApiBaseController
{
    public $successStatus = 200;

    public function details(Request $request)
    {
        $client = Auth::user(); 
        return $this->sendResponse(
            $client->ToArray(),
            'Details returned');
    }
    
}
