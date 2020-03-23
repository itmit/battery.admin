<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use App\Models\BatteryCategory;
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
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\MyReadFilter;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadCatalog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('home')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('file');
        $reader = new Xls();
        $reader->setReadDataOnly(true);
        
        // $url = storage_path() . '/app/catalog_upload/' . $file;
        $spreadsheet = $reader->load($file);

        $cells = $spreadsheet->getActiveSheet()->getCellCollection();

        for ($row = 142; $row <= 146; $row++){
            for ($col = 'B'; $col <= 'Q'; $col++) {
                if($cells->get($col.$row) == null) $position[$col] = null;
                else $position[$col] = $cells->get($col.$row)->getValue();
            }
            $result[$row] = $position;
            $position = [];
        }

        foreach($result as $item)
        {
            Battery::create([
                'category_id' => 8,
                'tab_id' => $item["B"],
                'neutral_id' => $item["C"],
                'din_marking' => $item["D"],
                'old_jis_marking' => $item["E"],
                'new_jis_marking' => $item["F"],
                'short_code' => $item["G"],
                'ah' => $item["H"],
                'rc' => $item["I"],
                'box' => $item["J"],
                'en' => $item["K"],
                'l_w_h' => $item["L"],
                'bhd' => $item["M"],
                'layout' => $item["N"],
                'weight_wet' => $item["O"],
                'pcs_pallet' => $item["P"],
                'remarks' => $item["Q"],
            ]);
        }
    }
}
