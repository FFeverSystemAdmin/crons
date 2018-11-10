<?php

require_once realpath(__DIR__."/../files/mailer/PHPMailerAutoload.php");
    
Class Mailer{

	private $mail;
	private $recipient;
	private $file;


	function __construct($recipient){
		$this->mail = new PHPMailer();
		$this->mail->SMTPDebug = 0;                                 // Enable verbose debug output
	    $this->mail->isSMTP();                                      // Set mailer to use SMTP
	    $this->mail->Host = "ffever.in";                            // Specify main and backup SMTP servers
	    $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $this->mail->Username = "system-admin@ffever.in";           // SMTP username
	    $this->mail->Password = "ffever@#123";                      // SMTP password
	    $this->mail->SMTPSecure = '';                            // Enable TLS encryption, `ssl` also accepted
	    $this->mail->SMTPAutoTLS = false;
	    $this->mail->Port = 25;                                     // TCP port to connect to
	    $this->mail->setFrom('system-admin@ffever.in', 'FFever System Admin');
    	$this->recipient=$recipient;
    	print_r("Info : Initialised recipient!!\n");
    	$this->mail->addAddress($this->recipient);
    	$this->mail->AddBCC("system-admin@ffever.in", "DST-REPORT-ADMIN");
    	$this->mail->isHTML(true);                                  // Set email format to HTML
    }

	function addAttachmentFile($file){
		$this->mail->addAttachment($file);
	}

	function addSubject($subject){
		$this->mail->Subject =$subject;
	}

	function addBody($body){
		$this->mail->Body =$body;
	}

	function addAttachment($file){
		$this->mail->addAttachment($file);
	}

	function send(){
		$status=$this->mail->send();
		print_r("Status".$status);
		if(!$status)
		print_r($this->mail->ErrorInfo);
		print_r("Email Sended!!\n");
		print_r("**********************************\n");
		print_r("\n");
	}

}
