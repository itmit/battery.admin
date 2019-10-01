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
use Maatwebsite\Excel\Excel;

class DeliveryWebController extends Controller
{

    public function checkFilesInUploadedFolder()
    {
        $directory = 'public/csv_upload';
        $files = Storage::files($directory);
        if($files != null)
        {
            // return substr(strrchr($files[0], "/"), 1);
            return self::getDeliveryFromUploadedCSVFile($files);
        }
        else return 'Folder is empty';
        // return $files;
    }

    public function getDeliveryFromUploadedCSVFile(array $files, $delimiter = ';')
    {
        foreach($files as $file)
        {
        
            $path = base_path();
            $path .= '/public_html/';
            $url = $path . Storage::url($file);

            $handle = fopen($url, "r");
            $header = true;

            $delivery_number = stristr(substr(strrchr($file, "/"), 1), ".", true);

            $delivery = Delivery::create([
                'delivery_number' => $delivery_number,
                'type' => 0,
            ]);

            if($delivery == null)
            {
                return 'Somebody once told me';
            }

            while ($csvLine = fgetcsv($handle, 1000, ";")) {

                if ($header) {
                    $header = false;
                } else {
                    echo $csvLine[0] . ' | ';
                    DeliveryDetails::create([
                        'delivery_id' => $delivery->id,
                        'serial_number' => $csvLine[0],
                        'delivery_note' => $csvLine[1],
                        'SSCC' => $csvLine[2],
                        'TAB_ID' => $csvLine[3],
                        'production_date' => $csvLine[4],
                        'delivery_date' => $csvLine[5],
                        'TAB_description' => $csvLine[6],
                        'CustomerOrderNumber' => $csvLine[7],
                        'Customer_Buyer' => $csvLine[8],
                        'Customer_buyer_ID' => $csvLine[9],
                        'Customer_Receiver' => $csvLine[10],
                        'Customer_Receiver_ID' => $csvLine[11],
                    ]);
                }
            }
        }
        
    }

}
