<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Delivery;
use App\Models\DeliveryDetails;
use App\Models\Shipment;
use App\Models\ShipmentDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShipmentApiController extends ApiBaseController
{
    public $successStatus = 200;

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whom' => 'required|uuid|exists:clients,uid',
            'serials' => 'required|array'
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "Validation error", 400);
        }

        $whom = Client::where('uid', $request->whom)->first()->id;

        $shipment = Shipment::create([
            'from' => auth('api')->user()->id,
            'whom' => $whom,
        ]);

        foreach ($request->serials as $serial) {
            ShipmentDetail::create([
                'shipment' => $shipment->id,
                'serial' => $serial
            ]);
        }

        return $this->sendResponse([], 'Stored');
    }
    
}
