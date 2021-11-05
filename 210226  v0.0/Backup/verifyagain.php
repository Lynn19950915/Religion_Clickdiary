<?php
	session_start();
	include("./PHPMailer/PHPMailerAutoload.php");
	ini_set('display_errors', 1);
	error_reporting(~0);
	// print_r($_SESSION['acc_info'][0]);

	if(isset($_POST['resent'])){
		$un =  $_SESSION['acc_info'][0]['username'];
		$v_code = $_SESSION['acc_info'][0]['v_code'];
		try {
			SendMail_Sinica($un, $v_code);
			SendMail_Gmail($un, $v_code);
		} catch (Exception $e) {
			echo $e->getMessage()."<br>";
		}
		exit();
	}

	function SendMail_Sinica($freceiver, $fvcode){
		$mail= new PHPMailer();                             //初始化一個PHPMailer物件
	    $mail->Host = "***";        			//SMTP主機 (這邊以gmail為例，所以填寫gmail stmp:smtp.gmail.com，sinica:webmail.stat.sinica.edu.tw)
	    $mail->IsSMTP();                                    //設定使用SMTP方式寄信
	    $mail->SMTPAuth = true;                             //啟用SMTP驗證模式
	    $mail->Username = "***";                           //您的 信箱 帳號
	    $mail->Password = "***";                           //您的 信箱 密碼
	    // $mail->SMTPSecure = "ssl";                       //SSL連線 (要使用gmail stmp需要設定ssl模式) ，用webmail sinica 則不須設定
	    $mail->Port = 25;                                   //Gamil的SMTP主機的port(Gmail為465，Sinica為25)。
	    $mail->CharSet = "utf-8";                           //郵件編碼
	      
	    $mail->From = "***";                               //寄件者信箱
	    $mail->FromName = "中研院統計科學研究所_點日記團隊";   //寄件者姓名
		$mail->AddAddress($freceiver);                    	//收件人郵件,收件人名稱(optional)
	    $mail->IsHTML(true);                                //郵件內容為html 
	    $mail->Subject = "歡迎加入點日記3.0";                //郵件標題
		$message       = "感謝您參與點日記3.0研究計畫，請點擊以下網址啟用會員帳號:
	    		  		  <a href='http://cdiary3.tw/verifyaccount.php?vcode={$fvcode}'>
	    				 http://cdiary3.tw/verifyaccount.php?vcode={$fvcode}</a>";
		$mail->Body    = $message;							//郵件內容
	    $mail->AltBody = "";								//當收件人的電子信箱不支援html時，會顯示這串~~
	    try {
	    	$mail->send();	
	    } catch (Exception $e) {
	    	echo 'Caught exception: ',  $e->getMessage(), "\n";
	    }
	}
		
	function SendMail_Gmail($freceiver, $fvcode){
		$mail = new PHPMailer();                             //初始化一個PHPMailer物件
	    $mail->Host = "***";                                //SMTP主機 (這邊以gmail為例，所以填寫gmail stmp)
	    $mail->IsSMTP();                                    //設定使用SMTP方式寄信
	    $mail->SMTPAuth = true;                             //啟用SMTP驗證模式
	    $mail->Username = "***";                           //您的 gamil 帳號
	    $mail->Password = "***";                           //您的 gmail 密碼
	    $mail->SMTPSecure = "ssl";                          // SSL連線 (要使用gmail stmp需要設定ssl模式) 
	    $mail->Port = 465;                                  //Gamil的SMTP主機的port(Gmail為465)。
	    $mail->CharSet = "utf-8";                           //郵件編碼
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
	      
	    $mail->From = "***";         	                  // 寄件者信箱
	    $mail->FromName = "中研院統計科學研究所_點日記團隊"; 	// 寄件者姓名
		$mail->AddAddress($freceiver);                    	 // 收件人郵件,收件人名稱(optional)
	    $mail->IsHTML(true);                                 // 郵件內容為html 
	    $mail->Subject = "歡迎加入點日記3.0";                	// 郵件標題
		$message       = "感謝您參與點日記3.0研究計畫，請點擊以下網址啟用會員帳號:
	    		  		  <a href='http://cdiary3.tw/verifyaccount.php?vcode={$fvcode}'>
	    				 http://cdiary3.tw/verifyaccount.php?vcode={$fvcode}</a>";
	 	$mail->Body =$message;                               // 郵件內容
	    $mail->AltBody = "";								 // 當收件人的電子信箱不支援html時，會顯示這串~~
	    $mail->send();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<title>會員帳號驗證信補發</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootsrap 4 CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<style type="text/css">
			html {
			  position: relative;
			  min-height: 100%;

			}
			body {
			  /*Avoid nav bar overlap web content*/
			  padding-top: 70px; 
			  /* Margin bottom by footer height ，avoid footer overlap web content*/
			  /*margin-bottom: 60px;*/
			  margin:0 auto;
			}
			.footer {
			  position: absolute;
			  bottom: 0;
			  width: 100%;
			  /* Set the fixed height of the footer here */
			  /*height: 60px;*/
			  /*line-height: 60px; */
			  /* Vertically center the text there */
			  background-color: #f5f5f5;
			  
			}
			.text{
				display: table-cell;
			    vertical-align: middle;
			    /*height: 100%;*/
			    font-size: 0.8em;
			    padding-top: 0.5em
			}
			#footerimg{
				float: left;
				height: 3em;
				padding-top: 0.5em;
			}
			#msg{
				font-size: 1.1em
			}
			#resentbtn{
				width: 10em
			}
			@media screen and (min-width: 350px) {
				#msg{
				font-size: 1.3em
			}
			}
	</style>
	<script type="text/javascript">
	
		function resent(){
			$.ajax({ 
				type: "POST",
				url: '',
				data: {
					resent: 1
				},success: function(data){ 	 
					$.confirm({
						title: '',
					    content: '已重新寄送會員驗證信，請至Email信箱查收~',
					    buttons: {
					        OK: function () {
					            window.location.href = 'http://cdiary3.tw';
					        }
					    }
					});
				},error: function(err){
					console.log(err)
				}
			});
		};
	</script>	
</head>
<body>
	<div id="msg" class="container">        
		親愛的<?php echo $_SESSION['acc_info']['id'];?>號會員您好:<br><br>
		您已使用以下信箱註冊，但尚未啟用帳號<br>
		<ul style="padding-left: 0;color: blue">帳號 : <?php echo $_SESSION['acc_info'][0]['username'] ;?></ul>
		<ul style="padding-left: 0">建議您將
			<span style="color: blue">***.asthma@gmail.com</span>
			與
			<span style="color: blue">***@stat.sinica.edu.tw</span> 
			加入通訊錄
		</ul>
		請至信箱點選驗證信中的連結，進行啟用

		<input id="resentbtn" type="button" value="點此補發驗證信" onclick="resent()" class="btn btn-primary btn-lg btn-block login-button">

	</div>
	<footer class="footer">
      		<div class="container">
      			<img id="footerimg"src="./pic/Academia_Sinica_Emblem.png" >
			    <div class="text">
				著作權©中研院統計科學研究所. 版權所有.<br>
			    Copyright© Institute of Statistical Science, Academia Sinica.
			    All rights reserved.
			    </div>
			</div>
   	</footer>
</body>
</html>