<?php


namespace App\Services;

use Illuminate\Support\Facades\Mail;


class MailService
{
    public function sendMail($site, $error) {
        $to_name = 'TO_NAME';
        $to_email = env('ADMIN_EMAIL');
        $data = array('name'=> $site, "body" => $error);
        Mail::send('email', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Ошибка синхронизации на сайте');
            $message->from(env('MAIL_USERNAME'),'1cService');
        });
    }

}
