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
use App\DepositWithdrawHistory;
use \Crypt;
use DB;
use DataTables;

class BetController extends Controller
{
    public function bethistory (Request $request) {
        $uuid = $request->uuId;
        $mac = $request->mac;
        $name = $request->id;
        $token = $request->token;
        $target = $request->target;
        $result = $request->result;
        $aftermath = $request->aftermath;
        $delta = $request->delta;
        $table = $request->table;
        $flag = Client::where('name', $name)->first();
        if($flag){
            $data = new Bethistory();
            $data->user_id = $flag->id;
            $data->delta = $delta;
            $data->target = $target;
            $data->result = $result;
            $data->aftermath = $aftermath;
            $data->table = $table;
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

    public function winninghistory (Request $request) {
        $name = $request->name;
        $target = $request->target;
        $result = $request->result;
        $aftermath = $request->aftermath;
        $delta = $request->delta;
        $table = $request->table;
        $flag = Client::where('name', $name)->where('token', $token)->first();
        if($flag){
            $data = new Bethistory();
            $data->user_id = $flag->id;
            $data->delta = $delta;
            $data->target = $target;
            $data->result = $result;
            $data->aftermath = $aftermath;
            $data->table = $table;
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

    public function userbethistory($id){
        $id = Crypt::decrypt($id);
        $details = Bethistory::where('user_id', $id)->orderBy('id', 'DESC')->get();
        $client = Client::where('id', $id)->get();

        return view('userbethistory')->with('details', $details)->with('client', $client);
    }

    public function withdrawhistory($id){
        $id = Crypt::decrypt($id);
        $client = Client::where('id', $id)->get();
        $withdraw = DepositWithdrawHistory::where('user_id', $client[0]->name)->where('type', '!=', 'ご入金')->get();
        return view('withdrawhistory')->with('withdraw', $withdraw)->with('client', $client);
    }

    public function deposithistory($id){
        $id = Crypt::decrypt($id);
        $client = Client::where('id', $id)->get();
        //$deposit = Account::where('user_id', $id)->where('transaction_type', '=', 'deposit')->get();
        $deposit = DepositWithdrawHistory::where('user_id', $client[0]->name)->where('type', 'ご入金')->get();
        return view('deposithistory')->with('deposit', $deposit)->with('client', $client);
    }
}
