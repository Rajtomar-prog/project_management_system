<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){
        $data = ['name'=>'Raj Tomar', 'phone'=>'9027883338'];
        Mail::send('mail-template', $data, function ($message) {
            // $message->from('john@johndoe.com', 'John Doe');
            // $message->sender('john@johndoe.com', 'John Doe');
            $message->to('rajtomer2110@gmail.com', 'Raj Tomar');
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            // $message->replyTo('john@johndoe.com', 'John Doe');
            $message->subject('Subject Test');
            // $message->priority(3);
            // $message->attach('pathToFile');
        });

        return 'Mail sent successfully';
    }
}
