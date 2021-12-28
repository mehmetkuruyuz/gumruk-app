<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InfoMailEvery extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullname,$email,$konu,$mesaj,$type='standart')
    {
        $this->data['fullname']=$fullname;
        $this->data['email']=$email;
        $this->data['konu']=$konu;
        $this->data['mesaj']=$mesaj;
        $this->data['zaman']=date('d-M-Y h:i');
        $this->data['type']=$type;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {//->replyTo($this->data['email'],$this->data['fullname'])
        if ($this->data['type']=='standart')
        {
        return $this->subject($this->data['konu'])->view('mail.mail',['data'=>$this->data]);
      }else {
        return $this->subject($this->data['konu'])->view('mail.mailektemplate',['data'=>$this->data]);
      }

    }
}
