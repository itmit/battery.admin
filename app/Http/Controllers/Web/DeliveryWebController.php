<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\DeliveryDetails;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class DeliveryWebController extends Controller
{

    public function checkFilesInUploadedFolder()
    {
        $directory = '/csv_upload';
        $files = Storage::allFiles($directory);
        return $files;
    }

    public function getDeliveryFromUploadedCSVFile()
    {

    }

}
