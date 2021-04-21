<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use App\Bethistory;
use App\Account;
use App\Groups;
use App\Individual_list;
use Mail;
use DB;

class AjaxController extends Controller
{
    public function getendhour(Request $request){
        $res = [];
        $start = (int)$request->id;
        for ($x = $start; $x <= 24; $x++){
            if ($x < 10){
                $val = '0'.$x;
            } else {
                $val = (string)$x;
            }
            array_push($res, "<option value='".$val."'>".$val."</option>");
        }
        return response()->json([
            'res' => $res
        ]);
    }

    public function getendmin(Request $request){
        $res = [];
        $start = (int)$request->id;
        for ($x = $start; $x <= 60; $x+=5){
            if ($x < 10) {
                $val = '0' . $x;
            } else if($x == 60){
                $val = "59";
            } else {
                $val = (string)$x;
            }
            array_push($res, "<option value='".$val."'>".$val."</option>");
        }
        return response()->json([
            'res' => $res
        ]);
    }
}
