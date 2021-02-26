<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use DB;

class ClientcreateController extends Controller
{
    public function createuser()
    {
            return view('createuser');        
    }
    public function automatebet()
    {
            return view('automatebet');        
    }
    public function details($id)
    { 
        $id = \Crypt::decrypt($id);
        $client = Client::where('id', $id)->get();
        // echo '<pre>';
        // print_r($client);
        // exit;
       
            return view('details')->with('client', $client);        
    }
    public function userlist()
    {

        $client = Client::all();
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
            'password' => 'required|min:6|regex:/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{6,}$/',
        ]);
        
            $data->name = $request['name'];
            $data->email = $request['email'];
            $data->password = sha1($request['password']);
            $data->phone_number = $request['number'];
            $data->street_address = $request['address'];
            $data->other = $request['other'];
            $data->token = Str::random(30);
            $data->url = "http://".$_SERVER['HTTP_HOST']."/bot-$data->token";

            $data->save();
            return redirect()->route('user-list');
    }
    public function changeuserstatus(Request $request)
    {       
        $Client = Client::find($request->id);
        $clientStatus = Client::where('id', $request->id)->first();
        if($clientStatus->status == 1){
        $data['client'] = Client::where('id', $request->id)->where('status', 1)->update(['status'=>0 ]);
        }else if($clientStatus->status == 0){
            $data['client'] = Client::where('id', $request->id)->where('status', 0)->update(['status'=>1 ]);
           
        }
        return ;
            
           
    }
}
