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
        $details = Bethistory::where('user_id', $id)->get();
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
        $client = Client::get();
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

        $data->group_name = $request['groupname'];

        $data->start_autobet_hour = $request['starttime_hour'];
        $data->start_autobet_min = $request['starttime_min'];
        $data->stop_autobet_hour = $request['stoptime_hour'];
        $data->stop_autobet_min = $request['stoptime_min'];
        $data->days = $arraytostring;
        $data->winning_double = $request['winningamount'];
        $data->negative_double = $request['negativeamount'];
        $data->terminate_table_count = $request['tablecount'];
        $data->save();

        $test = $request['username'];
        if($test > 0){
            foreach ($test as $user) {
                $candidate = client::where('id','=', $user)->first();
                $prevstr = $candidate->group_id;
                $prevstr_arr = explode(',', $prevstr);
                if (!in_array((string)$data->id, $prevstr_arr)){
                    array_push($prevstr_arr, $data->id);
                    $newStr = implode(',', $prevstr_arr);
                    $candidate->group_id = $newStr;
                    $candidate->save();
                }
            }
        }
        return redirect()->route('automatebet');
    }

    public function personal_settings()
    {
        $client = Client::get();
        $hour = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
        $min = ['00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '59'];
        return view('personal_settings')->with('client', $client)->with('hour', $hour)->with('min', $min);
    }

    public function personal_list($id)
    {
        $id = \Crypt::decrypt($id);
        $client = Client::whereRaw("find_in_set('".$id."',group_id)")->get();
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
        $name = Client::select('id')->whereRaw("find_in_set('".$id."',group_id)")->pluck('id')->toArray();
        $user = Client::all();

        $daysarray = explode(',', $client[0]->days);
        return view('edit_group')->with('client', $client)->with('hour', $hour)->with('min', $min)->with('daysarray', $daysarray)->with('user', $user)->with('name', $name);
    }

    public function edit_group_action(Request $request, $id)
    {
        $id = \Crypt::decrypt($id);
        request()->validate([
            'groupname' => 'required | max:255',
            'days' => 'required_without_all',
        ]);
        $arraytostring = implode(',', $request['days']);
        $group_name = $request['groupname'];
        $start_autobet_hour = $request['starttime_hour'];
        $start_autobet_min = $request['starttime_min'];
        $stop_autobet_hour = $request['stoptime_hour'];
        $stop_autobet_min = $request['stoptime_min'];
        $days = $arraytostring;
        $winning_double = $request['winningamount'];
        $negative_double = $request['negativeamount'];
        $termination_table_count = $request['tablecount'];

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
                'terminate_table_count' => $termination_table_count
            ]);

        $test = $request['username'];
        if($test>0){
            $all = client::select('id')->pluck('id');
            foreach ($all as $single){
                $individual = client::find($single);
                $previndividualstr = $individual->group_id;
                $previndividualstr_arr = explode(',', $previndividualstr);
                if (($key = array_search($id, $previndividualstr_arr)) !== false) {
                    unset($previndividualstr_arr[$key]);
                }
                $newstr = implode(',', $previndividualstr_arr);
                $individual->group_id = $newstr;
                $individual->save();
            }

            foreach ($test as $user) {
                $candidate = client::where('id','=', $user)->first();
                $prevstr = $candidate->group_id;
                $prevstr_arr = explode(',', $prevstr);
                if (!in_array((string)$id, $prevstr_arr)){
                    array_push($prevstr_arr, $id);
                    $newStr = implode(',', $prevstr_arr);
                    $candidate->group_id = $newStr;
                    $candidate->save();
                }
            }
        }
        return redirect()->route('automatebet');
    }


    public function delete_group(Request $request)
    {
        $id = $request->id;
        $group = Groups::find($id);
        $group->delete();
        $client_list = Client::all();
        foreach ($client_list as $client){
            $prevstr = $client->group_id;
            $prevstr_arr = explode(',', $prevstr);
            if (($key = array_search($id, $prevstr_arr)) !== false) {
                unset($prevstr_arr[$key]);
            }
            $newstr = implode(',', $prevstr_arr);
            $client->group_id = $newstr;
            $client->save();
        }
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
