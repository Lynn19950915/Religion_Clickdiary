<?php
	session_start();
	include "db.php";

	if(isset($_POST['SignIn'])){
		$un  = $_POST['username'];
		$pw  = $_POST['password'];
		$pw_encoded = base64_encode($pw);

		$sql  = "SELECT * FROM `account` WHERE username = :v1 ";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $un);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($stmt->rowCount() == 0) {
			echo "Invalid Username";	// 查無帳號
		}else if ($pw_encoded != $rs['password']) {
			echo "Invalid Password";	// 密碼輸入錯誤
		}else{
			$_SESSION['acc_info'] = $rs;
			echo $rs['reg_status']; 	// 回傳帳號狀態
		}

		exit();
	}

?><!DOCTYPE html>
<html>
<head>
	<title>點日記3.0</title>
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

		.wrapper {
		  display: flex;
		  align-items: center;
		  flex-direction: column; 
		  justify-content: center;
		  width: 100%;
		  min-height: 100%;
		  padding: 2em;
		}

		#formContent {
		  -webkit-border-radius: 10px 10px 10px 10px;
		  border-radius: 10px 10px 10px 10px;
		  background: #fff;
		  padding: 1em;
		  width: 90%;
		  max-width: 35em;
		  position: relative;
		  padding-top: 2em;
		  -webkit-box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
		  box-shadow: 0 30px 60px 0 rgba(0,0,0,0.3);
		  text-align: center;
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
		.form-group{
		    justify-content: center;
		}

		input[type=button], input[type=submit], input[type=reset]  {
		  background-color: #56baed;
		  border: none;
		  color: white;
		  padding: 15px 80px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  text-transform: uppercase;
		  font-size: 13px;
		  -webkit-box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
		  box-shadow: 0 10px 30px 0 rgba(95,186,233,0.4);
		  -webkit-border-radius: 5px 5px 5px 5px;
		  border-radius: 5px 5px 5px 5px;
		  margin: 5px 20px 40px 20px;
		  -webkit-transition: all 0.3s ease-in-out;
		  -moz-transition: all 0.3s ease-in-out;
		  -ms-transition: all 0.3s ease-in-out;
		  -o-transition: all 0.3s ease-in-out;
		  transition: all 0.3s ease-in-out;
		}

		input[type=button]:hover, input[type=submit]:hover, input[type=reset]:hover  {
		  background-color: #39ace7;
		}

		input[type=button]:active, input[type=submit]:active, input[type=reset]:active  {
		  -moz-transform: scale(0.95);
		  -webkit-transform: scale(0.95);
		  -o-transform: scale(0.95);
		  -ms-transform: scale(0.95);
		  transform: scale(0.95);
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
		  width: 20em;
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

		/* ANIMATIONS */
		/* Simple CSS3 Fade-in-down Animation */
		.fadeInDown {
		  -webkit-animation-name: fadeInDown;
		  animation-name: fadeInDown;
		  -webkit-animation-duration: 0.5s;
		  animation-duration: 0.5s;
		  -webkit-animation-fill-mode: both;
		  animation-fill-mode: both;
		}

		@-webkit-keyframes fadeInDown {
		  0% {
		    opacity: 0;
		    -webkit-transform: translate3d(0, -100%, 0);
		    transform: translate3d(0, -100%, 0);
		  }
		  100% {
		    opacity: 1;
		    -webkit-transform: none;
		    transform: none;
		  }
		}

		@keyframes fadeInDown {
		  0% {
		    opacity: 0;
		    -webkit-transform: translate3d(0, -100%, 0);
		    transform: translate3d(0, -100%, 0);
		  }
		  100% {
		    opacity: 1;
		    -webkit-transform: none;
		    transform: none;
		  }
		}

		/* Simple CSS3 Fade-in Animation */
		@-webkit-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
		@-moz-keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
		@keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

		.fadeIn {
		  opacity:0;
		  -webkit-animation:fadeIn ease-in 1;
		  -moz-animation:fadeIn ease-in 1;
		  animation:fadeIn ease-in 1;

		  -webkit-animation-fill-mode:forwards;
		  -moz-animation-fill-mode:forwards;
		  animation-fill-mode:forwards;

		  -webkit-animation-duration:1s;
		  -moz-animation-duration:1s;
		  animation-duration:1s;
		}

		.fadeIn.first {
		  -webkit-animation-delay: 0.1s;
		  -moz-animation-delay: 0.1s;
		  animation-delay: 0.1s;
		}

		.fadeIn.second {
		  -webkit-animation-delay: 0.3s;
		  -moz-animation-delay: 0.3s;
		  animation-delay: 0.3s;
		}

		.fadeIn.third {
		  -webkit-animation-delay: 0.5s;
		  -moz-animation-delay: 0.5s;
		  animation-delay: 0.5s;
		}

		.fadeIn.fourth {
		  -webkit-animation-delay: 0.7s;
		  -moz-animation-delay: 0.7s;
		  animation-delay: 0.7s;
		}

		/* Simple CSS3 Fade-in Animation */
		.underlineHover:after {
		  display: block;
		  left: 0;
		  bottom: -10px;
		  width: 0;
		  height: 2px;
		  background-color: #56baed;
		  content: "";
		  transition: width 0.2s;
		}

		.underlineHover:hover {
		  color: #0d0d0d;
		}

		.underlineHover:hover:after{
		  width: 100%;
		}

		.logo_title{
		    /*color:#60a0ff;*/
		    color: black;
	        align-self: center;
	        margin-left: 0.5em;
		}

		/* OTHERS */

		*:focus {
		    outline: none;
		} 

		#logo {
			height: 5em;
		  	width: 5em;
		}

		.icon{
			width: 10em;
		}
		/* Adjust For mobile */
		@media screen and (max-width: 550px) {

			h2{
				font-size: 1.5rem;
			}

			#formContent {
				padding: 0.25em;
			}

			.wrapper{
				padding: 0.25em;
			}

			.icon{
				width: 6em;
			}

			input[type=text], input[type=password]{
				width: 12rem;
				padding: 1rem 0.5rem;
			}	
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){

			$("#btn_sign_in").on("click", function (event) {
			    event.preventDefault();
			    var username = $("input[id='username']").val(); 
	    		var password = $("input[id='password']").val(); 

    			$.ajax({ 
					type: 'POST',
					url: '',
					data: {
						SignIn: 1,
						username: username,
						password: password,
					},beforeSend: function(b){
						// $("button").attr({'disabled':true});
					},done: function(d){
						// $("button").attr({'disabled':false});
					},success: function(data){ 
						console.log(data)	 
						if (data == 2) {	
							// 帳號已啟用，並已填寫個人資料
							window.location.href = 'http://cdiary3.tw/hdiary.php';
						}else if (data == 1) {
							// 帳號已啟用，尚未填寫個人資料
							window.location.href = 'http://cdiary3.tw/profile.php';
						}else if (data == 0) { 
							// 帳號未啟用
							$.confirm({
								title: '',
							    content: '尚未啟用帳號，請至信箱點擊驗證信件，或申請補發驗證信',
							    buttons: {
							        OK: function () {
							            window.location.href = 'http://cdiary3.tw/verifyagain.php';
							        }
							    }
							});
						}else if (data == "Invalid Username") {
							$.alert({
							    title: '',
							    content: '此帳號尚未進行註冊',
							});
						}else if (data == "Invalid Password") {
							$.alert({
							    title: '',
							    content: '密碼輸入錯誤',

							});
						}

					},error: function(e){
						console.log(e)
						$.alert({
						    title: '',
						    content: '此帳號尚未註冊或密碼輸入錯誤',
						});
					}
				});
			});

			$("#btn_register").on("click", function (event) {
			    event.preventDefault();
			    window.location.href = "http://cdiary3.tw/register.php";
			})
    	});
	</script>
</head>
<body>
	<div class="container">
		<div class="wrapper fadeInDown">
		  <div id="formContent">

		    <!-- Icon -->
		    <div class="fadeIn first" style="display: inline-flex;">
		      <img src="http://cdiary3.tw/pic/logo.png" id="logo" alt="宗教點日記3.0" />
		      <h2 class="logo_title">宗教點日記3.0</h2>
		    </div>

		    <!-- Login Form -->
		    <form>
		    	<div class="input-group form-group fadeIn second ">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-user"></i></span>
					</div>
					<input id="username" type="text" placeholder="請輸入帳號 (Email)">
				</div>
				<div class="input-group form-group fadeIn second ">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-key"></i></span>
					</div>
					<input id="password" type="password" placeholder="請輸入密碼">
				</div>
				<button id="btn_sign_in" class="btn fadeIn third">
					<img src="/pic/btn_sign_in.png" class="icon">
				</button>
				<button id="btn_register" class="btn fadeIn third">
					<img src="/pic/btn_register.png" class="icon">
				</button>
		    </form>
		    <div id="formFooter" class="fadeIn fourth">
		    	<div class="mb-2">
		    		<a href="http://cdiary3.tw/desktop.php" style="color: red;" >點此前往建立手機桌面捷徑教學(Android / iOS) <i class="fas fa-file-download"></i></a>
		    	</div>
		    	<div class="mb-2">
		    		<a class="underlineHover" href="http://cdiary3.tw/pw_forget.php">忘記密碼<i class="fas fa-question-circle"></i></a>
		    	</div>
		    	<div>
		    		<a class="underlineHover" href="mailto:***@stat.sinica.edu.tw">若有任何疑問，歡迎來信至：***@stat.sinica.edu.tw</a>	
		    	</div>
		    </div>
		  </div>
		</div>
    </div>
</body>
</html>