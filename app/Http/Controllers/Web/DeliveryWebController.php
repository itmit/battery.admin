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

            return basename($handle);

            while ($csvLine = fgetcsv($handle, 1000, ";")) {

                if ($header) {
                    $header = false;
                } else {
                    echo $csvLine[0] . ' | ';
                    // Character::create([
                    //     'name' => $csvLine[0] . ' ' . $csvLine[1],
                    //     'job' => $csvLine[2],
                    // ]);
                }
            }
        }
        
    }

}
