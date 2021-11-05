<?php
	include("./PHPMailer/PHPMailerAutoload.php");
	function Send_GMail($subject,$body,$sender,$sendername,$receiver){
		$mail = new PHPMailer();
	    $mail->Host = "***";
	    $mail->IsSMTP();
	    $mail->SMTPAuth = true;
	    $mail->Username = "***";
	    $mail->Password = "***";
	    $mail->SMTPSecure = "ssl";
	    $mail->Port    = 465;
	    $mail->CharSet = "utf-8";
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
	    $mail->From     = $sender;
	    $mail->FromName = $sendername;
		$mail->AddAddress($receiver);
	    $mail->IsHTML(true);
	    $mail->Subject = $subject;
		$mail->Body    = $body;
	    $mail->AltBody = "";
	    try {
	    	$mail->send();	
	    } catch (Exception $e) {
	    	echo $e->getMessage()."<br>";
	    	echo 'Mailer Error: ' . $mail->ErrorInfo."<br>";
	    }
	    
	}

	function Send_WebMail($subject,$body,$sender,$sendername,$receiver){
		$mail = new PHPMailer();
	    $mail->Host = "***";
	    $mail->IsSMTP();
	    $mail->SMTPAuth = true;
	    $mail->Username = "***";
	    $mail->Password = "***";
	    // $mail->SMTPSecure = "ssl";                       //SSL連線 (要使用gmail stmp需要設定ssl模式) ，用webmail sinica 則不須設定
	    $mail->Port    = 25;
	    $mail->CharSet = "utf-8";
	      
	    $mail->From     = $sender;
	    $mail->FromName = $sendername;
		$mail->AddAddress($receiver);
	    $mail->IsHTML(true);
	    $mail->Subject = $subject;
		$mail->Body    = $body;
	    $mail->AltBody = "";
	    try {
	    	$mail->send();	
	    } catch (Exception $e) {
	    	echo $e->getMessage()."<br>";
	    	echo 'Mailer Error: ' . $mail->ErrorInfo."<br>";
	    }
	}
?>