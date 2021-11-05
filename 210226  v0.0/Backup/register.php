<?php
	include "db.php";
	include("./PHPMailer/PHPMailerAutoload.php");

	if(isset($_POST['checkusername'])){
		$username = $_POST['username'];
		$sql = "SELECT * FROM account WHERE username = :v1";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $username);
		$stmt->execute();
		$num_row = $stmt->rowCount();
		echo $num_row;
		exit();
	}

	if(isset($_POST['register'])){
		$un  = $_POST['username'];
		$pw  = $_POST['password'];
		$pw_encoded = base64_encode($pw);
		$v_code 	= bchexdec($un);
		$now = date("Y-m-d H:i:s"); 

		$sql  = "SELECT * FROM account WHERE username = :v1";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $un);
		$stmt->execute();

		if($stmt->rowCount() == 0){
			$sql = "INSERT INTO
						`account`(
							`id`, `username`, `password`,
							`reg_status`, `reg_time`,
							`egoid_invite`, `alterid_invite`,
							`v_code`, `last_login`, `quit`
						)
					VALUES(
					  null, :v1, :v2,
					  0, :v3,
					  null, null,
					  :v4, null, 0
					)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':v1', $un);
			$stmt->bindParam(':v2', $pw_encoded);
			$stmt->bindParam(':v3', $now);
			$stmt->bindParam(':v4', $v_code);

			try {
				$stmt->execute();
				SendMail_Sinica($un, $v_code);
				SendMail_Gmail($un, $v_code);
				echo "Register Success";
			} catch (Exception $e) {
				echo $e->getMessage()."<br>";
			}
		}else {
			echo "Username Existed";
		}
		exit();
	}


	function SendMail_Sinica($freceiver, $fvcode){
		$mail= new PHPMailer();                             //初始化一個PHPMailer物件
	    $mail->Host = "***";        			            //SMTP主機 (這邊以gmail為例，所以填寫gmail stmp:smtp.gmail.com，sinica:webmail.stat.sinica.edu.tw)
	    $mail->IsSMTP();                                    //設定使用SMTP方式寄信
	    $mail->SMTPAuth = true;                             //啟用SMTP驗證模式
	    $mail->Username = "***";                           //您的 信箱 帳號
	    $mail->Password = "***";                           //您的 信箱 密碼
	    // $mail->SMTPSecure = "ssl";                       //SSL連線 (要使用gmail stmp需要設定ssl模式) ，用webmail sinica 則不須設定
	    $mail->Port = 25;                                   //Gamil的SMTP主機的port(Gmail為465，Sinica為25)。
	    $mail->CharSet = "utf-8";                           //郵件編碼
	      
	    $mail->From = "***";                               //寄件者信箱
	    $mail->FromName = "中央研究院-點日記團隊";              //寄件者姓名
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
	      
	    $mail->From = "***";         	                     // 寄件者信箱
	    $mail->FromName = "中央研究院-點日記團隊"; 	// 寄件者姓名
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

	function bchexdec($hex){
	    $dec = 0;
	    $len = strlen($hex);
	    for ($i = 1; $i <= $len; $i++) {
	        $dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
	    }
	    return $dec;
	}

?><!DOCTYPE html>
<html>
<head>
	<title>點日記3.0 - 會員註冊</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache">
	<!-- Bootsrap 4 CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!-- Fontawesome CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<style type="text/css">
		/* BASIC */
		html,body {
		  background-color: #f0f0f0;
		  height: 100%;
		}

		.container{
			height: 100%;
			align-content: center;
			padding-bottom: 5vw;
		}

		a {
		  /*color: #92badd;*/
		  display:inline-block;
		  text-decoration: none;
		  font-weight: 400;
		}

		/* STRUCTURE */

		.card-body{
		    letter-spacing: 0.5em;
		    line-height: 1.8em;
	        text-align: justify;
		}

		.wrapper {
		  display: flex;
		  align-items: center;
		  flex-direction: column; 
		  justify-content: center;
		  width: 100%;
		  min-height: 100%;
		  padding: 1.25em;
		}

		#formContent {
		  -webkit-border-radius: 10px 10px 10px 10px;
		  border-radius: 10px 10px 10px 10px;
		  background: #fff;
		  padding: 1em;
		  /*width: 90%;*/
		  /*max-width: 35em;*/
		  position: relative;
		  padding-top: 2em;
		  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
		  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
		  /*text-align: center;*/
		}

		#formFooter {
		  /*background-color: #f6f6f6;*/
		  border-top: 2px solid #dce8f1;
		  padding: 25px;
		  text-align: center;
		  -webkit-border-radius: 0 0 10px 10px;
		  border-radius: 0 0 10px 10px;
		}

		/* FORM TYPOGRAPHY*/
		.form-control{
			height: 3em;
		}

		.form-group{
		    justify-content: center;
		}

		.btn.disabled, .btn:disabled {
		    cursor: not-allowed;
		    opacity: .65;
		}

		input[type=text],input[type=password] {
		  background-color: #f6f6f6;
		  border: none;
		  color: #0d0d0d;
		  padding: 15px 32px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 1em;
		  /*margin: 5px;*/
		  width: 20em !important;
		  border: 2px solid #f6f6f6;
		  -webkit-transition: all 0.5s ease-in-out;
		  -moz-transition: all 0.5s ease-in-out;
		  -ms-transition: all 0.5s ease-in-out;
		  -o-transition: all 0.5s ease-in-out;
		  transition: all 0.5s ease-in-out;
		  -webkit-border-radius: 5px 5px 5px 5px;
		  border-radius: 5px 5px 5px 5px;
		}

		input[type=text]:focus,input[type=password]:focus {
		  background-color: #fff;
		  border-bottom: 2px solid #5fbae9;
		}

		input[type=text]:placeholder {
		  color: #cccccc;
		}

		/* OTHERS */

		*:focus {
		    outline: none;
		} 

		.icon{
			width: 10em;
		}
		/* Adjust For mobile */
		@media screen and (max-width: 550px) {

			h3{
				font-size: 1.5rem;
			}

			#formContent {
				width: 90%;
				padding: 0.5em;
			}

			.wrapper{
				padding: 0.25em;
			}

			input[type=text], input[type=password]{
				width: 12rem !important;
			}	

			.container {
				padding-left: 0.25rem;
				padding-right: 0.25rem;
			}
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#start_regist").on("click", function(evt){
				evt.preventDefault();
				var tmp = $("input[id='agree']").is(':checked')?1 :0;
				// console.log(tmp)
				if(tmp == 1){
					$("#page_1").hide()
					$("#page_2").show()
				}else{

				}
			})

			$("#username").on("focusout", function (event) {  
				// console.log(this.value)
				var username = this.value;
				// 進DB Query此帳號是否已被使用
				if (username) {			
					$.ajax({ 
						type: "POST",
						url: '',
						data: {
							checkusername:1,
							username: username,
						},success: function(data){
							// console.log("checkusername",data)
							if(data == 0){		
								// username is available
								$("#btn_register").attr('disabled', false);
								$("#username").removeClass("is-invalid");
								$("#username").addClass("is-valid");
								$(".invalid-feedback").empty()
							}else if(data != 0){  
								// username has been used
								$("#btn_register").attr('disabled', true); 
								$("#username").removeClass("is-valid");
								$("#username").addClass("is-invalid");
								$(".invalid-feedback").empty().html('此帳號已被使用!').attr({'style': 'text-align: center;'});
							}
						},error: function(e){
							console.log(e)
						}
					})
				}
			});

			$("#btn_register").on("click", function (event) {
			    event.preventDefault();
			    var username = $("input[id='username']").val(); 
	    		var password = $("input[id='password']").val(); 
	    		var password2 = $("input[id='password2']").val(); 

	    		if (password != password2) {
	    			$.alert({
					    title: '',
					    content: '兩次輸入密碼不一致<br> 請重新確認!',
					});
	    		}else {
	    			
	    			$.ajax({ 
						type: 'POST',
						url: '',
						data: {
							register: 1,
							username: username,
							password: password,
						},beforeSend: function(b){
							$("button").attr({'disabled':true});
						},done: function(d){
							$("button").attr({'disabled':false});
						},success: function(data){ 
							console.log(data)
							if (data == "Register Success") {
								$.confirm({
									title: '',
								    content: '帳號註冊成功，請至Email信箱點選驗證信件中的帳號啟用連結',
								    buttons: {
								        '好': function() {
								        	window.location.href = 'http://cdiary3.tw';
								        }
								    }
								});
							}else if (data == "Username Existed") {
								$.alert({
								    title: '',
								    content: '您輸入的Email帳號已被使用，請修正!',
								});
							}else { 

							};  
						},error: function(e){
							console.log(e)
							$.alert({
							    title: '',
							    content: '帳號註冊失敗，請確認Email是否正確',
							});
						}
					});
					
	    		}
			});

    	});
	</script>
</head>
<body>
	<div class="container">
		<div class="wrapper">
		  <div id="formContent">
		    <div id="page_1">
				<div class="card border-primary">
					<div class="card-header text-white bg-primary">點日記3.0簡介</div>
					<div class="card-body">
					台灣社會的宗教活動蓬勃發展，不論是佛教團體的志工，還是民間信仰信徒主動發心的儀式活動義工，都為台灣社會的宗教注入相當高的活力。隨著3C時代的來臨，新的溝通模式創造了更多組織動員的新可能，也讓宗教參與的型態更為豐富。<br><br>
					為瞭解這群發心自願參與宗教活動的義工，如何在宗教參與及日常生活間達到平衡？平時如何獲得訊息？彼此如何溝通、互動？有何心靈上的收穫？<br><br>
					中研院統計所及社會所計畫進行一項線上填答的研究，希望(定期或不定期)參與宗教服務活動的人，能定期在線上填答簡單問卷，讓我們更瞭解台灣宗教發展背後的活力如何產生。本研究將提供微薄的回饋作為答謝，謝謝您發心參與!!<br>					
					</div>
				</div>
				<div class="justify-content-center mt-2" style="text-align: center">
			 		<input type="checkbox"  id="agree"></input>
			 		<label for="agree">本人已詳閱以上說明同意書<br id="br_hide">並完全同意參與點日記研究計畫</label>
		 		</div>
		 		<div class="justify-content-center mt-2" style="text-align: center">
		 			<button id="start_regist" class="btn-primary btn-lg">開始註冊</button>
		 		</div>
	 		</div>
	 		<div id="page_2" style="display: none;">
			    <form class="needs-validation">
			    	<div class="input-group form-group">
			    		<h3>點日記3.0 - 會員註冊</h3>
			    	</div>
			    	<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input id="username" type="text" class="form-control" placeholder="請輸入帳號 (Email)">
						<div class="invalid-feedback"></div>
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input id="password" type="password" class="form-control" placeholder="請輸入密碼">
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input id="password2" type="password" class="form-control" placeholder="請確認密碼">
					</div>
					<div class="input-group form-group">
						<button id="btn_register" class="btn" disabled>
							<img src="/pic/btn_register.png" class="icon">
						</button>
					</div>
			    </form>
			</div>

		  </div>
		</div>
    </div>
</body>
</html>