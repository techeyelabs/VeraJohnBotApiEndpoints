<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");

        Mail::send(['text'=>'mail'], $data, function($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
    public function downloadLink(Request $request) {
        $sender_name = 'NineBot';
        $receiver_name = $request->receiver_name;
        $usermail = $request->usermail;
        $downloadlink = $request->downloadlink;

        $data = [
            'sender_name' => $request->sender_name,
            'receiver_name' => $request->receiver_name,
            'usermail' => $request->usermail,
            'downloadlink' => $request->downloadlink,
        ];

        Mail::send('downloadLink', $data, function($message) use( $sender_name, $receiver_name, $usermail) {
            $message->to($usermail, $receiver_name)->subject
            ('バカラ自動BETソフト「ナイン ボット」ダウンロードリンク');
            $message->from('brownhick1977@gmail.com', $sender_name);
        });
        return redirect()->route('user-list');
    }
    public function attachment_email() {
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
            $message->to('abc@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
            $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
            $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
        echo "Email Sent with attachment. Check your inbox.";
    }
}
