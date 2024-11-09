<?php

namespace App\Services\Mails;


use App\Mail\GeneralNotificationMail;
use Illuminate\Support\Facades\Mail;


class GeneralMailTemplateService{

    protected $user;
    protected $subject ='No Subject';

    protected $url;
    protected $message;

    protected $messages=[];

    protected $senderName;
    protected $recipientName;
    protected $email;

    protected $redirectAction;
    public function __construct($user=null){

        $this->user=$user;

        if($user){
            $this->recipientName = $user->name;

        }

        $this->senderName='Peemco Team';
        $this->redirectAction='Go to Peemco';

    }

    public function send(){
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            Mail::to($this->email)->send(new GeneralNotificationMail($this));
        }

    }
    public function setSubject($subject){
        $this->subject=$subject;
        return $this;
    }

    public function setMessage( $message){
        $this->message =$message;
        return $this;
    }

    public function setOtherMessages(array $messages){
        $this->messages =$messages;
        return $this;
    }

    public function setUrl($url,$redirectAction){
        $this->redirectAction=$redirectAction;
        $this->url=$url;
        return $this;
    }


    public function setRecipentName($recipientName){
        $this->recipientName =$recipientName;
        return $this;
    }
    public function sendTo($email){

        $this->email = $email;
        return $this;
    }

    public function setSenderName($senderName){

        $this->senderName=$senderName;

        return $this;
    }

      // Getter Methods
      public function getUser()
      {
          return $this->user;
      }

      public function getSubject()
      {
          return $this->subject;
      }

      public function getMessage()
      {
          return $this->message;
      }

      public function getUrl()
      {
          return $this->url;
      }

      public function getSenderName()
      {
          return $this->senderName;
      }

      public function getRecipientName()
      {
          return $this->recipientName;
      }

      public function getRedirectAction(){
        return $this->redirectAction;
      }

      public function getOtherMessages(){
        return $this->messages;
      }




}
