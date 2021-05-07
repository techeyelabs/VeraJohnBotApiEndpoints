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
use phpDocumentor\Reflection\PseudoTypes\False_;
use function Composer\Autoload\includeFile;

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

    private function checkweek($group_weeks){
        $days = $group_weeks;
        $daysList = explode(',', $days);

        $currentDay = date('D');  // Get current day name
        $day_of_week = date('N', strtotime($currentDay));  //Get rank of the day

        if (!in_array((string)$day_of_week, $daysList)){
            return false;
        } else {
            return true;
        }
    }

    private function resetLock($client_id, $group_id){
        $client = Client::where('name', $client_id)->first();
        if ($client->is_locked != (int)$group_id){
            $client->is_locked = 0;
            $client->save();
        }
        return True;
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
        if($flag->group_id == NULL || $flag->group_id == ''){
            $group_all = Individual_list::where('user_id', $id)->first();
        } else {
            $group_all = explode(',', $flag->group_id);
        }

        $group_count = 0;
        foreach ($group_all as $grp_count){
            if ($grp_count != '' && $grp_count != null){
                $group_count++;
            }
        }

        if($group_all != null) {
            if (count($group_all) > 1) {
                $i = 0;
                foreach ($group_all as $grp){
                    if ($grp == null || $grp == '')
                        continue;

                    $group = Groups::where('id', $grp)->first();
                    $start_autobet_hour = $group->start_autobet_hour;
                    $start_autobet_min = $group->start_autobet_min;
                    $stop_autobet_hour = $group->stop_autobet_hour;
                    $stop_autobet_min = $group->stop_autobet_min;
                    $start_autobet = $start_autobet_hour.':'.$start_autobet_min;
                    $stop_autobet = $stop_autobet_hour.':'.$stop_autobet_min;

                    $h = date('G');
                    $m = date('i');
                    $dt = date('G:i');

                    $res = $this->checkweek($group->days);
                    if ($flag->is_locked != (int)$grp && $res == true) {
                        $status = 200;
                    } else {
                        $status = 404;
                    }
                    echo $start_autobet_hour;
                    echo '<br/>';
                    echo $start_autobet_min;
                    echo '<br/>';
                    echo $stop_autobet_hour;
                    echo '<br/>';
                    echo $stop_autobet_min;
                    echo '<br/>';
                    echo $start_autobet;
                    echo '<br/>';
                    echo $stop_autobet;
                    echo '\n';

                    if($h >= $start_autobet_hour && $h <= $stop_autobet_hour){
                        if($start_autobet_hour == $stop_autobet_hour){
                            if ($m <= $stop_autobet_min && $m >= $start_autobet_min){
                                echo "line 185";
                                $this->resetLock($id, $grp);
                                return response()->json([
                                    "time" => $dt,
                                    "group" => $grp,
                                    "start_autobet" => $start_autobet,
                                    "stop_autobet" => $stop_autobet,
                                    "status" => $status
                                ]);
                            }
                        } else if ($h == $stop_autobet_hour) {
                            if ($m <= $stop_autobet_min) {
                                echo "line 197";
                                $this->resetLock($id, $grp);
                                return response()->json([
                                    "time" => $dt,
                                    "group" => $grp,
                                    "start_autobet" => $start_autobet,
                                    "stop_autobet" => $stop_autobet,
                                    "status" => $status
                                ]);
                            }
                        } else if($h == $start_autobet_hour){
                            if ($m > $start_autobet_min) {
                                echo "line 209";
                                $this->resetLock($id, $grp);
                                return response()->json([
                                    "time" => $dt,
                                    "group" => $grp,
                                    "start_autobet" => $start_autobet,
                                    "stop_autobet" => $stop_autobet,
                                    "status" => $status
                                ]);
                            }
                        } else {
                            echo "line 220";
                            echo $status;
                            $this->resetLock($id, $grp);
                            return response()->json([
                                "time" => $dt,
                                "group" => $grp,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => $status
                            ]);
                        }
                    }

                    if ($i == $group_count - 1){
                        echo "line 232";
                        return response()->json([
                            "time" => "Not applicable",
                            "group" => "0",
                            "start_autobet" => "Not applicable",
                            "stop_autobet" => "Not applicable",
                            "status" => 404
                        ]);
                    }
                    $i++;
                }
            } else {
                $group = Individual_list::where('user_id', $id)->first();
                $start_autobet_hour = $group->start_autobet_hour;
                $start_autobet_min = $group->start_autobet_min;
                $stop_autobet_hour = $group->stop_autobet_hour;
                $stop_autobet_min = $group->stop_autobet_min;
                $start_autobet = $start_autobet_hour.':'.$start_autobet_min;
                $stop_autobet = $stop_autobet_hour.':'.$stop_autobet_min;

                $h = date('G');
                $m = date('i');
                $dt = date('G:i');

                $days = $group->days;
                $daysList = explode(',', $days);

                $currentDay = date('D');  // Get current day name
                $day_of_week = date('N', strtotime($currentDay));  //Get rank of the day

                if (!in_array((string)$day_of_week, $daysList)){
                    echo "line 263";
                    return response()->json([
                        "time" => $dt,
                        "start_autobet" => $start_autobet,
                        "stop_autobet" => $stop_autobet,
                        "status" => 404
                    ]);
                }

                if($h >= $start_autobet_hour && $h <= $stop_autobet_hour){
                    if($start_autobet_hour == $stop_autobet_hour){
                        if ($m <= $stop_autobet_min && $m >= $start_autobet_min){
                            echo "line 275";
                            return response()->json([
                                "time" => $dt,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => 200
                            ]);
                        } else {
                            echo "line 283";
                            return response()->json([
                                "time" => $dt,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => 404
                            ]);
                        }
                    } else if ($h == $stop_autobet_hour) {
                        if ($m <= $stop_autobet_min) {
                            echo "line 293";
                            return response()->json([
                                "time" => $dt,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => 200
                            ]);
                        } else {
                            echo "line 301";
                            return response()->json([
                                "time" => $dt,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => 404
                            ]);
                        }
                    } else if($h == $start_autobet_hour){
                        if ($m <= $start_autobet_min) {
                            echo "line 311";
                            return response()->json([
                                "time" => $dt,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => 404
                            ]);
                        } else {
                            echo "line 319";
                            return response()->json([
                                "time" => $dt,
                                "start_autobet" => $start_autobet,
                                "stop_autobet" => $stop_autobet,
                                "status" => 200
                            ]);
                        }
                    } else {
                        echo "line 328";
                        return response()->json([
                            "time" => $dt,
                            "start_autobet" => $start_autobet,
                            "stop_autobet" => $stop_autobet,
                            "status" => 200
                        ]);
                    }
                } else {
                    echo "line 337";
                    return response()->json([
                        "time" => $dt,
                        "start_autobet" => $start_autobet,
                        "stop_autobet" => $stop_autobet,
                        "status" => 404
                    ]);
                }
            }
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
            'lastdate' => date('Y-m-d', strtotime('+1 day', $userdata->updated_at))
        ]);
    }

    public function lockUserUntilNext(Request $request){
        $user = $request->userId;
        $userdata = Client::where('name', $user)->first();
        $userdata->is_locked = 1;
        $userdata->save();
        return response()->json([
           'status' => 200
        ]);
    }
}


