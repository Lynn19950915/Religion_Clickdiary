<?php
include("PHPMailerAutoload.php"); //匯入PHPMailer類別       

$mail= new PHPMailer(); //建立新物件        
$mail->IsSMTP(); //設定使用SMTP方式寄信        
$mail->SMTPAuth = true; //設定SMTP需要驗證        
$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線   
$mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
$mail->Port = 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        
$mail->CharSet = "big5"; //設定郵件編碼        

$mail->Username = "clickdiaryasthma@gmail.com"; //設定驗證帳號        
$mail->Password = "statstat"; //設定驗證密碼        
$mail->From = "clickdiaryasthma@gmail.com"; //設定寄件者信箱        
$mail->FromName = "測試人員"; //設定寄件者姓名        

$mail->Subject = "PHPMailer 測試信件"; //設定郵件標題        
$mail->Body = "大家好,       
這是一封測試信件!       
"; //設定郵件內容        
$mail->IsHTML(true); //設定郵件內容為HTML        
$mail->AddAddress("ken242310@gmail.com", "Ken"); //設定收件者郵件及名稱        

if(!$mail->Send()) {        
echo "Mailer Error: " . $mail->ErrorInfo;        
} else {        
echo "Message sent!";        
}    
?>