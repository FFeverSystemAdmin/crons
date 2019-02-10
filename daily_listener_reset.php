<?php

$base = __DIR__."/" ;
include realpath($base."header.php");
$flag = false;
$msg = null;
try{
	$output = shell_exec('taskkill /IM "ffever_listener.exe" /F && cd C:\Users\Administrator\Desktop\prateek_listener\ && start ffever_listener.exe');
	$flag = true;
	$msg = $output;
}catch(Exception  $e){
	$flag = false;
	$msg = $e->getMessage();
}finally{
	$mail = new Mailer(["prateekr149@gmail.com","r.prateek11@gmail.com"]);
	$mail->addSubject('Daily Listener restarter Initiated');	
	$mail->addBody("Reported : <br/>".$msg);
	$mail->send();
}



?>