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

class ClientcreateController extends Controller
{
    public function createuser()
    {
            return view('createuser');
    }
    public function automatebet()
    {
        $data = Groups::all();
        return view('automatebet')->with('data', $data);
    }
    public function details($id)
    {
        $id = \Crypt::decrypt($id);
        $client = Client::where('id', $id)->get();
        // echo '<pre>';
        // print_r($client);
        // exit;
        $details = Bethistory::where('user_id', $id)->get();
        // $account = Account::where('user_id', $id)->get();
        // $deposit = Account::where('user_id', $id)->where('transaction_type', '=', 'deposit')->get();
        // $withdraw = Account::where('user_id', $id)->where('transaction_type', '=', 'withdraw')->get();
        // echo '<pre>';
        // print_r($deposit);
        // exit;

        // return view('dummy')->with('details', $details);

            return view('details')->with('client', $client)->with('details', $details);
    }
    public function userlist()
    {
        $client = Client::orderBy('id', 'DESC')->get();
        return view('userlist', ['client'=>$client]);
    }
    public function userdetails($id)
    {
        $id = \Crypt::decrypt($id);
        if($id){
            $client = Client::where('id', $id)->get();
            $id = Client::where('id', $id)->count();
            if($id){
                return $client;
            }
        }
    }
    public function createuseraction(Request $request)
    {
        $data = new Client();
        request()->validate([
            'name' => 'required | unique:client',
            'email' => 'required|email|unique:client',
            'password' => 'required|min:6',
        ]);

        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->password = sha1($request['password']);
        $data->password_plain = $request['password'];
        $data->phone_number = $request['number'];
        $data->street_address = $request['address'];
        $data->other = $request['other'];
        $data->token = Str::random(30);
        $data->url = "http://".$_SERVER['HTTP_HOST']."/installerdownload?id=bot-$data->token";

        $data->save();

        $params = [
            'sender_name' => 'Casino Bot',
            'receiver_name' => $request['name'],
            'usermail' => $request['email'],
            'downloadlink' => "http://".$_SERVER['HTTP_HOST']."/installerdownload?id=bot-$data->token",
        ];

        return redirect()->route('downloadLink', $params);
    }
    public function changeuserstatus(Request $request)
    {
        $clientStatus = Client::where('id', $request->id)->first();
        if($clientStatus->status == 1){
            $data['client'] = Client::where('id', $request->id)->where('status', 1)->update(['status'=>0 ]);
        }else if($clientStatus->status == 0){
            $data['client'] = Client::where('id', $request->id)->where('status', 0)->update(['status'=>1 ]);
        }
        return response()->json([
            'status' => 200
        ]);
    }

    public function pauseunpauseuser(Request $request)
    {
        $clientStatus = Client::where('id', $request->id)->first();
        if($clientStatus->is_paused == 1){
            $clientStatus->is_paused = 0;
        }else if($clientStatus->is_paused == 0){
            $clientStatus->is_paused = 1;
        }
        $clientStatus->save();
        return response()->json([
            'status' => $clientStatus->is_paused
        ]);
    }

    public function creategroup()
    {
        $client = Client::where('group_id', null)->get();
        $hour = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
        $min = ['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '59'];

        return view('creategroup')->with('client', $client)->with('hour', $hour)->with('min', $min);
    }

    public function creategroupaction(Request $request)
    {
        $data = new Groups();
        $client = new Client();
        request()->validate([
            'groupname' => 'required | max:255',
            'days' => 'required_without_all',
        ]);

            $arraytostring = implode(',', $request['days']);
            // $namearray = implode(',', $request['username']);

            $data->group_name = $request['groupname'];
            // $data->users = $namearray;
            // $data->password = sha1($request['password']);
            $data->start_autobet_hour = $request['starttime_hour'];
            $data->start_autobet_min = $request['starttime_min'];
            $data->stop_autobet_hour = $request['stoptime_hour'];
            $data->stop_autobet_min = $request['stoptime_min'];
            $data->days = $arraytostring;
            $data->winning_double = $request['winningamount'];
            $data->negative_double = $request['negativeamount'];

            $data->save();

            $test = $request['username'];

            if($test > 0){
                foreach ($test as $user) {
                    client::where('id','=', $user)
                        ->update([
                            'group_id' => $data->id,
                        ]);
                }
        }
        return redirect()->route('automatebet');
    }

    public function personal_settings()
    {

        // $client = Client::all();
        $client = Client::where('group_id', null)->where('individual_setting_id', null)->get();
        $hour = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
        // $min = [00, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59];
        $min = ['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '59'];

        return view('personal_settings')->with('client', $client)->with('hour', $hour)->with('min', $min);
        // return view('personal_settings')->with('client', $client);
    }

    public function personal_list($id)
    {
        $id = \Crypt::decrypt($id);
        $client = Client::where('group_id', $id)->get();
        // echo '<pre>';
        // print_r($client);
        // exit;
        // $details = Bethistory::where('user_id', $id)->get();
        // $account = Account::where('user_id', $id)->get();
        // $deposit = Account::where('user_id', $id)->where('transaction_type', '=', 'deposit')->get();
        // $withdraw = Account::where('user_id', $id)->where('transaction_type', '=', 'withdraw')->get();
        // echo '<pre>';
        // print_r($deposit);
        // exit;

        // return view('dummy')->with('details', $details);

            return view('personal_list')->with('client', $client);
    }

    public function nogroup_users()
    {

        $client = Client::where('group_id' , NULL)->orWhere('group_id', '=', 0)->get();
        // $client = Individual_list::all();
        return view('nogroup_users')->with('client', $client);
    }

    public function personal_settings_action(Request $request)
    {
        $flag = $request->addeditflag;
        $user = (int)$request->username[0];
        if ($flag > 0){
            $data = Individual_list::where('id', $flag)->first();
        } else {
            $data = new Individual_list();
        }

        $client = Client::find($user);
        request()->validate([
            'days' => 'required_without_all',
            'username' => 'required_without_all',
        ]);

        $arraytostring = implode(',', $request['days']);
        $data->user_id = $user;
        $data->start_autobet_hour = $request['starttime_hour'];
        $data->start_autobet_min = $request['starttime_min'];
        $data->stop_autobet_hour = $request['stoptime_hour'];
        $data->stop_autobet_min = $request['stoptime_min'];
        $data->days = $arraytostring;
        $data->winning_double = $request['winningamount'];
        $data->negative_double = $request['negativeamount'];
        $data->save();

        $client->group_id = null;
        $client->individual_setting_id = $data->id;
        $client->save();

        return redirect()->route('nogroup_users');
    }

    public function editIndividualSetting(Request $request)
    {
        $ind_id = $request->individual_id;
        $user = $request->user_id;
        $userdata = Client::where('id', $user)->get();
        $hour = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
        $min = ['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '59'];
        $individual = Individual_list::where('id' , $ind_id)->first();
        $daysarray = explode(',', $individual->days);
        return view('personal_settings')->with('hour', $hour)->with('min', $min)->with('daysarray', $daysarray)->with('client', $userdata)->with('individual', $individual);
    }

    public function edit_group($id)
    {
        $id = \Crypt::decrypt($id);
        $hour = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24];
        $min = [00, 05, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 59];

        $client = Groups::where('id' , $id)->get();
        $name = Client::where('group_id' , $id)->pluck('id')->toArray();
        $user = Client::all();

        $daysarray = explode(',', $client[0]->days);
        return view('edit_group')->with('client', $client)->with('hour', $hour)->with('min', $min)->with('daysarray', $daysarray)->with('user', $user)->with('name', $name);
    }

    public function edit_group_action(Request $request, $id)
    {
        $id = \Crypt::decrypt($id);
        $data = new Groups();
        $client = new Client();
        request()->validate([
            'groupname' => 'required | max:255',
            'days' => 'required_without_all',
        ]);

            $arraytostring = implode(',', $request['days']);
            // $namearray = implode(',', $request['username']);

            $group_name = $request['groupname'];
            // $data->users = $namearray;
            // $data->password = sha1($request['password']);
            $start_autobet_hour = $request['starttime_hour'];
            $start_autobet_min = $request['starttime_min'];
            $stop_autobet_hour = $request['stoptime_hour'];
            $stop_autobet_min = $request['stoptime_min'];
            $days = $arraytostring;
            $winning_double = $request['winningamount'];
            $negative_double = $request['negativeamount'];

            groups::where('id', '=', $id)
                ->update([
                    'group_name' => $group_name,
                    'start_autobet_hour' => $start_autobet_hour,
                    'start_autobet_min' => $start_autobet_min,
                    'stop_autobet_hour' => $stop_autobet_hour,
                    'stop_autobet_min' => $stop_autobet_min,
                    'days' => '"'.$arraytostring.'"',
                    'winning_double' => $winning_double,
                    'negative_double' => $negative_double,
                ]);

            $test = $request['username'];
            client::where('group_id','=', $id)
                ->update([
                    'group_id' => null,
                ]);
            if($test>0){
                foreach ($test as $user) {
                    client::where('id','=', $user)
                        ->update([
                            'group_id' => $id,
                        ]);
                }
        }

        return redirect()->route('automatebet');
    }


    public function delete_group(Request $request)
    {
        $id = $request->id;
        $client = Groups::find($id);
        $client->delete();
        Client::where('group_id' , $id)->update(array('group_id' => null));
        return response()->json([
            'status' => 200
        ]);
    }
    public function download(Request $request)
    {
        $identity = $request->id;
        $all = explode('-', $identity);
        $name = Client::where('token' , $all[1])->first();
        if ($name){
            $pathToFile = storage_path('app/files/main.exe');
            return response()->download($pathToFile);
        } else {
            echo "Invalid URL, contact concerned authority";
        }

    }

    public function mailusercreds(Request $request){
        try{
            $user = $request->id;
            $userdata = Client::find($user);
            $sender_name = "Casino Bot";
            $receiver_name = $userdata->name;
            $usermail = $userdata->email;
            $downloadlink = $userdata->url;
            $password = $userdata->password_plain;

            $data = [
                'sender_name' => $sender_name,
                'receiver_name' => $receiver_name,
                'usermail' => $usermail,
                'downloadlink' => $downloadlink,
                'password' => $password,
            ];

            Mail::send('downloadLink', $data, function($message) use( $sender_name, $receiver_name, $usermail) {
                $message->to($usermail, $receiver_name)->subject
                ('Download Link for CasinoBot');
                $message->from('brownhick1977@gmail.com', $sender_name);
            });
            return response()->json([
                'status' => 200
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => 404
            ]);
        }
    }
}
