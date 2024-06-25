<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Mail;
use PDF;

class SendMailController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function send_mailnew(Request $request)
    {   
        if ($this->isOnline()) {
           
            $maildata = [
            'email' => $request->email,
            'title' => $request->title,
            'content' => $request->content,
            'bookrep_file' => $request->bookrep_file,
            ];

            Mail::send('emails.sendemail',$maildata ,function($message)use ($maildata){
                $message->to($maildata['email'])
                ->subject($maildata['title'],$maildata['content']);
            });

        } else {
            return redirect()->back()->with('success','ok');
        }
        
        // $email  = $request->email;
        // $title  = $request->title;
        // $content  = $request->content; 
        // $data["email"] = $request->email;
        // $date["title"] = $request->title;
        // $data["content"] = $request->content; 
        // $data["bookrep_file"] = $request->bookrep_file; 
         
        // Mail::send(['text'=>'mail'],$data,function($message){
        //     $message->to($data["email"]);
        //     $message->subject($data["title"]);
        //     $message->attach($data["bookrep_file"],"text.pdf");
        // });
        // dd($pdfuploadsendemail);
        // $mailData = [
        //     'title' => $title,
        //     'content' => $content,
        //     'pdfuploadsendemail' => $pdfuploadsendemail,
        // ];

        // // $pdf = PDF::

        // Mail::to($email)->send(new SendMail($mailData));
           
        // dd("Email is sent successfully.");
    }
    public function send_mail(Request $request)
    {   
        $data["email"] = $request->email;
        $date["title"] = $request->title;
        $data["content"] = $request->content; 
        $pdf = PDF::loadView('book.book_sendemail_file');

        Mail::send('book.book_sendemail_file',$data,function($message)use($data,$pdf){
            $message->to($data["email"])
            ->subject($date["title"])
            ->attachData($pdf->output(),"text.pdf");
        });
                 
        dd("Email is sent successfully.");
    }
}
