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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DeliveryWebController extends Controller
{

    public function checkFilesInUploadedFolder()
    {
        $directory = 'public/csv_upload';
        $files = Storage::files($directory);
        if($files != null)
        {
            // return substr(strrchr($files[0], "/"), 1);
            self::getDeliveryFromUploadedCSVFile($files);
        }
        // return $files;
    }

    public function getDeliveryFromUploadedCSVFile(array $files)
    {
        foreach($files as $file)
        {
            // Delivery::create([
            //     'delivery_number' => 
            // ]);
            Excel::load(substr(strrchr($file, "/"), 1))->each(function (Collection $csvLine) {

                // DeliveryDetails::create([
                //     'name' => "{$csvLine->get('first_name')} {$csvLine->get('last_name')}",
                //     'job' => $csvLine->get('job'),
                // ]);

                    echo $csvLine->get('serial_number') . ' | ';
           
           });
        }
        
    }

}
