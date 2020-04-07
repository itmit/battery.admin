<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stock;
use App\Models\StockArchive;
use SplFileInfo;

class checkDeliveries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkDeliveries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = scandir(storage_path() . '/app/public/csv_upload');
        foreach($files as $file)
        {
            $fileType = new SplFileInfo($file);
            if($fileType->getExtension() == "csv")
            {
                // $path = base_path();
                // $path .= 'public_html/';
                // $url = storage_path() . '/app/public/csv_upload/' . $file;

                $url = storage_path() . '/app/public/csv_upload/' . $file;
                $handle = fopen($url, "r");
                $header = true;

                $delivery_number = $fileType->getBasename('.csv');

                $delivery = Delivery::create([
                    'delivery_number' => $delivery_number,
                    'uuid' => (string) Str::uuid(),
                ]);

                while ($csvLine = fgetcsv($handle, 1000, ";")) {

                    if ($header) {
                        $header = false;
                    } else {
                        DeliveryDetails::create([
                            'delivery_id' => $delivery->id,
                            'SSCC' => $csvLine[0],
                            'ARTICLE' => $csvLine[1],
                            'SERIAL' => $csvLine[2],
                            'SSCC_QUANTITY' => $csvLine[3],
                            'BATCH' => $csvLine[4],
                            'DESCRIPTION' => $csvLine[5],
                            'PACKING_DATE' => $csvLine[6],
                            'DISPATCH_DATE' => $csvLine[7],
                            'Description_2' => $csvLine[8],
                            'PAYER_CODE' => $csvLine[9],
                            'PAYER_DESCRIPTION' => $csvLine[10],
                            'RECEIVER_CODE' => $csvLine[11],
                            'RECEIVER_DESCRIPTION' => $csvLine[12],
                            'NETO_WEIGHT' => $csvLine[13],
                        ]);
                    }
                }  
            }   
        }

        $path = storage_path() . '/app/public/csv_upload';
        if (file_exists($path)) {
            foreach (glob($path.'/*') as $file) {
                if(is_dir($file))
                {
                    foreach(scandir($file) as $p) if (($p!='.') && ($p!='..'))
                    unlink($file.DIRECTORY_SEPARATOR.$p);
                    // return rmdir($file);
                }
                else
                {
                    unlink($file);
                }
            }
        }
    }
}
