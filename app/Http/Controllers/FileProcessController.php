<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FileProcessController extends Controller
{
    public function upload(Request $request)
    {


        // store the file and get the path
        //$path = $request->file('file')->store('uploads');


        //https://biketrade97.hu/katalogus.xml
        //https://xml.bikefun.hu/cikktorzs.csv

        //DB::table('products')->truncate();

        #make prevolus 2 file get the data and combine them with $path file content
        //$xmlContent = file_get_contents('https://biketrade97.hu/katalogus.xml');
        //$xmlObject = simplexml_load_string($xmlContent);

        // $csvContent = file_get_contents('https://xml.bikefun.hu/cikktorzs.csv');
        //$csvContent = str_getcsv($csvContent, ";");
        // $csvContent = array_chunk($csvContent, 62);
        //array_shift($csvContent);
        //$csvContent = str_getcsv($csvContent, ";", '"');
        //$csvContent = file_get_contents('https://xml.bikefun.hu/cikktorzs.xml');
        //$csvObject = str_getcsv($csvContent, ";", '"', "\r\n");
        //$csvObject = str_getcsv($csvContent);
        //dd($csvContent['Product'][0]);
        //dd($csvContent['Product'][1]);
        //$csvContent =
        //$htmlContent = file_get_contents('http://office.bikefun.hu:5555/getcsvstocks.html');
        //$csv = array_map('str_getcsv', $csvContent);
        //dd($csvContent);
    }
}
