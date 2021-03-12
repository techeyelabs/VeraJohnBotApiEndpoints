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
         return response()->json([
                "status" => 404
              ]);
        $flag = Client::where('name', $name)->where('password', $passwordCheck)->where('token', $token)->first();

        if($flag){
            return response()->json([
                "status" => 200
              ]);
        } else{
            return response()->json([
                "status" => 404
              ]);
        }
      }

      public function account (Request $request) {
            $name = $request->name;
            $token = $request->token;
            $amount = $request->amount;
            $date = $request->date;
            $type = $request->type;
            // $starttime = $request->starttime;
            $flag = Client::where('name', $name)->where('token', $token)->first();
            if($flag){
                $data = new Account();
                $data->user_id = $flag->id;
                // $data->starttime = $starttime;
                $data->amount = $amount;
                $data->date = $date;
                $data->transaction_type = $type;
                $data->save();
                return response()->json([
                    // "message" => "hi",
                    // "client" => $flag,
                    "status" => 200
                  ]);
            } else{
                return response()->json([
                    "status" => 404
                  ]);
            }
        }

        public function beteligibility(Request $request) {

          $id = $request->id;
          $flag = Client::where('id', $id)->first();
          if($flag->group_id == NULL || $flag->group_id ==0){

            $group = Individual_list::where('user_id', $id)->first();

          } else{
              $group = Groups::where('id', $flag->group_id)->first();
            }
          if($group != null){
              $start_autobet_hour = $group->start_autobet_hour;
              $start_autobet_min = $group->start_autobet_min;
              $stop_autobet_hour = $group->stop_autobet_hour;
              $stop_autobet_min = $group->stop_autobet_min;
              $start_autobet = $start_autobet_hour.':'.$start_autobet_min;
              $stop_autobet = $stop_autobet_hour.':'.$stop_autobet_min;

              $h = date('h');
              $m = date('i');
              $dt = date('h:i');

              if($h == $start_autobet_hour || $h == $stop_autobet_hour){
                if($m >= $start_autobet_min && $m <= $stop_autobet_min){

                  return response()->json([
                    // "message" => "hi",
                    "time" => $dt,
                    "start_autobet" => $start_autobet,
                    "stop_autobet" => $stop_autobet,
                    "status" => 200
                  ]);

                } else{

                  return response()->json([
                    "time" => $dt,
                    "start_autobet" => $start_autobet,
                    "stop_autobet" => $stop_autobet,
                    "status" => 404
                    ]);

                }
              

              } else if($h > $start_autobet_hour && $h < $stop_autobet_hour){
              
                return response()->json([
                    // "message" => "hi",
                    "time" => $dt,
                    "start_autobet" => $start_autobet,
                    "stop_autobet" => $stop_autobet,
                    "status" => 200
                  ]);
              } else{
                  return response()->json([
                    "time" => $dt,
                    "start_autobet" => $start_autobet,
                    "stop_autobet" => $stop_autobet,
                      "status" => 404
                    ]);
              }


          } else{
            return response()->json([
                "status" => 404
              ]);
            }
       
        }
  
}


