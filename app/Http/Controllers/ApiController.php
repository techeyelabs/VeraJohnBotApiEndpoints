<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Betstartlog;
use App\Betendlog;
use App\Bethistory;
use App\Client;
use App\Account;
use App\Groups;
use App\DepositWithdrawHistory;
use App\Individual_list;
use Crypt;
use DB;
use Carbon;

class ApiController extends Controller
{
    public function getAllClient() {
        $client = Client::all();
        return response()->json([
            "message" => "All Client Record",
            "client" => $client
        ], 201);
    }

    public function createClient(Request $request) {


    }

    public function getClient($id) {
        if (Client::where('id', $id)->exists()) {
            $client = Client::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($client, 200);
        } else {
            return response()->json([
                "message" => "Client not found"
            ], 404);
        }
    }

    public function updateClient(Request $request, $id) {

    }

    public function deleteClient ($id) {

    }

    public function userauthentication(Request $request) {
        $name = $request->name;
        $password = $request->password;
        $passwordCheck = sha1($password);
        $token = $request->token;

        $mac = $request->mac;
        $uuid = $request->uuid;
        $flag = Client::where('name', $name)->where('password', $passwordCheck)->where('is_paused', 0)->first();

        if($flag){
            if($flag->uuid == "" || $flag->uuid == null || $flag->mac == "" || $flag->mac == null){
                $flag->uuid = $uuid;
                $flag->mac = $mac;
                $flag->save();
            } else {
                if($flag->uuid != $uuid && $flag->mac != $mac){
                    return response()->json([
                        "message" => "Device not recognized",
                        "status" => 420
                    ]);
                }
            }
            return response()->json([
                "message" => "Successfully authenticated",
                "verajohn_id" => $flag->verajohnId,
                "verajohn_pass" => $flag->verajohnPassword,
                "status" => 200
            ]);
        } else{
            return response()->json([
                "status" => 404
              ]);
        }
      }


    public function account(Request $request) {
        $name = $request->name;
        $token = $request->token;
        $amount = $request->amount;
        $date = $request->date;
        $type = $request->type;
        $flag = Client::where('name', $name)->where('token', $token)->first();
        if($flag){
            $data = new Account();
            $data->user_id = $flag->id;
            $data->amount = $amount;
            $data->date = $date;
            $data->transaction_type = $type;
            $data->save();
            return response()->json([
                "status" => 200
            ]);
        } else {
            return response()->json([
                "status" => 404
            ]);
        }
    }

    public function beteligibility(Request $request) {
        $id = $request->id;
        $flag = Client::where('name', $id)->first();
        if ($flag->uuid != $request->uuid && $flag->mac != $request->mac){
            return response()->json([
                "message" => "Device is not verified",
                "status" => 404
            ]);
        }
        if($flag->group_id == NULL || $flag->group_id ==0){
            $group = Individual_list::where('user_id', $id)->first();
        } else {
            $group = Groups::where('id', $flag->group_id)->first();
        }

        if($group != null){
            $start_autobet_hour = $group->start_autobet_hour;
            $start_autobet_min = $group->start_autobet_min;
            $stop_autobet_hour = $group->stop_autobet_hour;
            $stop_autobet_min = $group->stop_autobet_min;
            $start_autobet = $start_autobet_hour.':'.$start_autobet_min;
            $stop_autobet = $stop_autobet_hour.':'.$stop_autobet_min;

            $h = date('G');
            $m = date('i');
            $dt = date('G:i');

            //$weeks = $group->days;
            //$arr = explode(',', $weeks);


            if($h >= $start_autobet_hour && $h <= $stop_autobet_hour){
                if($start_autobet_hour == $stop_autobet_hour){
                    if ($m <= $stop_autobet_min && $m >= $start_autobet_min){
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 200
                        ]);
                    } else {
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 404
                        ]);
                    }
                } else if ($h == $stop_autobet_hour) {
                    if ($m <= $stop_autobet_min) {
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 200
                        ]);
                    } else {
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 404
                        ]);
                    }
                } else if($h == $start_autobet_hour){
                    if ($m <= $start_autobet_min) {
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 404
                        ]);
                    } else {
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 200
                        ]);
                    }
                } else {
                    return response()->json([
                        "time" => $dt,
                        "start_autobet" => $start_autobet,
                        "stop_autobet" => $stop_autobet,
                        "status" => 200
                    ]);
                }
            } else {
                return response()->json([
                    "time" => $dt,
                    "start_autobet" => $start_autobet,
                    "stop_autobet" => $stop_autobet,
                    "status" => 404
                ]);
            }
        } else {
            return response()->json([
                "status" => 404
            ]);
        }
    }

    public function devicevalidation(Request $request){
        $uuid = $request->uuid;
        $mac = $request->mac;
        $isexist = Client::where('uuid', $uuid)->orWhere('mac', $mac)->count();
        if ($isexist > 0){
            return response()->json([
                "status" => 200
            ]);
        } else {
            return response()->json([
                "status" => 404
            ]);
        }
    }

    public function deviceReg(Request $request){
        return response()->json([
            "status" => 200
        ]);
    }

    public function verajohnIdPassRegistration(Request $request){
        $userid = $request->userId;
        $passwordCheck = sha1($request->userPass);
        $verajohnId = $request->verajohnuserid;
        $verajohnPass = $request->verajohnuserpass;
        $isexistvera = Client::where('verajohnId', $verajohnId)->where('verajohnPassword', $verajohnPass)->first();
        if ($isexistvera){
            return response()->json([
                "status" => 404
            ]);
        } else {
            $isexist = Client::where('name', $userid)->where('password', $passwordCheck)->first();
            if ($isexist){
                $isexist->verajohnId = $verajohnId;
                $isexist->verajohnPassword = $verajohnPass;
                $isexist->save();
                return response()->json([
                    "status" => 200
                ]);
            } else {
                return response()->json([
                    "status" => 404
                ]);
            }
        }
    }

    public function depowithreg(Request $request){
        try{
            $user = $request->userId;
            $date = $request->date;
            $amount = $request->amount;
            $type = $request->type;

            $history = new DepositWithdrawHistory();
            $history->type = $type;
            $history->amount = $amount;
            $history->user_id = $user;
            $history->happening_date = $date;
            $history->save();


            $userdata = Client::where('name', $user)->first();
            $userdata->last_history_grabbing = $date;
            $userdata->save();

            return response()->json([
                'status' => 200
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => 404
            ]);
        }
    }

    public function getlastdepowithreg(Request $request){
        $user = $request->user;
        $userdata = Client::where('name', $user)->first();
        return response()->json([
            'status' => 200,
            'lastdate' => date('Y-m-d', strtotime('+1 day', $userdata->last_history_grabbing))
        ]);
    }
}


