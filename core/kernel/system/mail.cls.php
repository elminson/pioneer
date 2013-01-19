<?php

/**
    * class mail
    *
    * Description for class mail
    *
    * @author:
    */
class mailsender {

    
    public $encoding;
    public $from;
    public $to;
    public $cc;
    public $bcc;
    public $subject;
    public $templ;
    public $smtp_server;
    
    private $rms;
    
    public $mailerObject;

    /**
        * Constructor.  
        *
        * @param 
        * @return 
        */
    function mailsender($from = "", $to = "", $cc = "", $bcc = "", $subject = "", $template = "", $encoding = "") {
        global $core;
        $this->smtp_server = $core->sts->MAIL_SMTP;
        
        $this->from = $from;
        $this->to = $to;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->subject = $subject;
        $this->templ = $template;
        $this->encoding = $encoding;
        if($this->encoding == "")
            $this->encoding = $core->sts->MAIL_DEFAULT_ENCODING;
        
        $this->rms = new mailtemplate();
        
        $this->mailerObject = new PHPMailer();
        // $this->mailerObject->language = "ru";
        // $this->mailerObject->Mailer = "sendmail";
        $this->mailerObject->IsMail();
        
        
    }
    
    public function addrule($tag, $value) {
        $this->rms->add($tag, $value);
    }
    
    public function removerule($tag) {
        $this->rms->remove($tag);
    }
    
    public function addaddress($rec) {
        if(!empty($this->to)) {
            if(!is_array($this->to)) {
                $tto = $this->to;
                $this->to = array($tto);
            }
            $this->to[count($this->to)] = $rec;
        }
        else
            $this->to = $rec;
        
    }
    
    public function getBody() {
        return $this->rms->apply($this->templ); 
    }
    
    public function AddAttachment($path, $name = "", $encoding = "base64", $type = "application/octet-stream") {
        $this->mailerObject->AddAttachment($path, $name, $encoding, $type);
    }    
    
    public function send($actualysend = false) {
        global $core;
        
        
        $this->mailerObject->CharSet = $this->encoding;
        $this->mailerObject->Host     = $this->smtp_server;
        if(!is_empty($core->sts->MAIL_SMTP_DATA)) {
            
            $smtpdata = new Collection();
            $smtpdata->FromString($core->sts->MAIL_SMTP_DATA, "\r\n", "=");
            $this->mailerObject->IsSMTP();
            $this->mailerObject->SMTPAuth = $smtpdata->auth == "true" ? true : false;
            $this->mailerObject->Host = $smtpdata->server;
            $this->mailerObject->Port = $smtpdata->port;
            if($this->mailerObject->SMTPAuth) {
                $this->mailerObject->Username = $smtpdata->login;
                $this->mailerObject->Password = $smtpdata->password;
            }
            $this->mailerObject->SMTPSecure = $smtpdata->secure;
             //$this->mailerObject->SMTPDebug = true;
            
        }

        $tmp = $this->from;
        
        if(preg_match("/(\".*\")?(.*)/", $tmp, $matches) > 0) {
            $this->mailerObject->FromName = convert_string($this->encoding, trim($matches[1], "\""));
            $this->mailerObject->From = $matches[2];
        }
        
        if(!is_array($this->to))
            $this->mailerObject->AddAddress($this->to);
        else {
            for($i=0; $i < count($this->to); $i++) {
                $this->mailerObject->AddAddress($this->to[$i]);
            }
        }          

        $this->mailerObject->WordWrap = 50;
        $this->mailerObject->IsHTML(true);
        $this->mailerObject->Subject  =  convert_string($this->encoding, $this->subject);

        //$msg = $this->getBody();
        //$msg = '<meta http-equiv="Content-Type" content="text/html; charset='.$this->encoding.'" />'."\n".$msg;
        $this->mailerObject->Body =  convert_string($this->encoding, $this->getBody());
        if(!$this->mailerObject->Send($actualysend)) {
           trigger_error("Message was not sent <p>Mailer Error: " . $this->mailerObject->ErrorInfo);
        }
        
        
    }
}



?>