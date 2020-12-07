<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Client;
use App\User;
use DB;
// use Hashids\Hashids;

class ClientcreateController extends Controller
{
    public function createuser()
    {
            return view('createuser');
         
    }
    public function userlist()
    {

        $client = Client::all();
        // $hashids = new Hashids();
        return view('userlist', ['client'=>$client]);
        // return view('userlist', compact('client','hashids'));
           
           
    }
    public function userdetails($id)
    {
        $id = \Crypt::decrypt($id);
        if($id){
            $client = Client::where('id', $id)->get();
            $id = Client::where('id', $id)->count();
            if($id){
                // return view('clientprofile',['client'=>$client]);
                return $client;
            }
        }
        // return $id;
       
            // $client = Client::where('id', $id)->get()->first();
            // return view('clientprofile', ['client'=>$client]);
         

        // $client = Client::all();
        // return view('clientprofile', ['client'=>$client]);
           
           
    }
    public function createuseraction(Request $request)
    {
        $data = new Client();
        request()->validate([
            'name' => 'required | unique:client',
            'email' => 'required|email|unique:client',
            'password' => 'required|min:6|regex:/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{6,}$/',
            ]);
            // Another Regex with same conditions.
            // ^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
            
            // $data->id = \Crypt::decrypt(id);
            $data->name = $request['name'];
            $data->email = $request['email'];
            $data->password = sha1($request['password']);
            $data->token = Str::random(30);
            // $data = $request->all();
            // dd($data);
            // return $data;
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
