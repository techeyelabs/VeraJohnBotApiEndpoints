<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Betstartlog;
use App\Betendlog;
use App\Client;
use Crypt;
use DB;

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
       
        // $id = \Crypt::decrypt($id);
        // $clientid = \Crypt::decrypt($id); 
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
        $flag = Client::where('name', $name)->where('password', $passwordCheck)->where('token', $token)->first();
        // var_dump($flag);
        // die();
        if($flag){
            return response()->json([
                "status" => 200
              ]);
        } else{
            return response()->json([
                "status" => 420
              ]);
        }
      }

      public function betstartlog (Request $request) {
        $name = $request->name;
        $token = $request->token;
        $starttime = $request->starttime;
        $flag = Client::where('name', $name)->where('token', $token)->first();
        if($flag){
            $data = new Betstartlog();
            $data->userid = $flag->id;
            $data->starttime = $starttime;
            $data->save();
            return response()->json([
                "status" => 200
              ]);
        } else{
            return response()->json([
                "status" => 404
              ]);
        }
    }
      public function betendlog (Request $request) {
        $name = $request->name;
        $token = $request->token;
        $endtime = $request->endtime;
        $flag = Client::where('name', $name)->where('token', $token)->first();
        if($flag){
            $data = new Betendlog();
            $data->userid = $flag->id;
            $data->endtime = $endtime;
            $data->save();
            return response()->json([
                "status" => 200
              ]);
        } else{
            return response()->json([
                "status" => 404
              ]);
        }
    }
}
