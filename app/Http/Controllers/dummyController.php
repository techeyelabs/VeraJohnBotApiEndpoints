<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Betstartlog;
use App\Betendlog;
use App\Client;
use DB;


class dummyController extends Controller
{
    public function startrelation(Request $request)
    {   
        // $data1 = Client::where('id', '=', 7)->get();
        $dummy2 = Client::where('id', '=', 7)->with('Betstartlog')->first();
        
        echo '<pre>';
        print_r($dummy2->Betstartlog[0]->starttime);
        exit();
        // dd($dummy2);
    }    
        

}
