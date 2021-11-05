<?php
	include "db.php";

	if(isset($_POST['login'])){

		exit();
	}

?><!DOCTYPE html>
<html>
<head>
	<title>點日記3.0</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style type="text/css">
		  body {
		    padding-bottom: 40px;
		    background-color: #eee;
		  
		  }
		  .btn 
		  {
		   outline:0;
		   border:none;
		   border-top:none;
		   border-bottom:none;
		   border-left:none;
		   border-right:none;
		   box-shadow:inset 2px -3px rgba(0,0,0,0.15);
		  }
		  .btn:focus
		  {
		   outline:0;
		   -webkit-outline:0;
		   -moz-outline:0;
		  }
		  .fullscreen_bg {
		    position: fixed;
		    top: 0;
		    right: 0;
		    bottom: 0;
		    left: 0;
		    background-size: cover;
		    background-position: 50% 50%;
		    background-image: url('http://cleancanvas.herokuapp.com/img/backgrounds/color-splash.jpg');
		    background-repeat:repeat;
		  }
		  .form-signin {
		    max-width: 280px;
		    padding: 15px;
		    margin: 0 auto;
		      margin-top:50px;
		  }
		  .form-signin .form-signin-heading, .form-signin {
		    margin-bottom: 10px;
		  }
		  .form-signin .form-control {
		    position: relative;
		    font-size: 16px;
		    height: auto;
		    padding: 10px;
		    -webkit-box-sizing: border-box;
		    -moz-box-sizing: border-box;
		    box-sizing: border-box;
		  }
		  .form-signin .form-control:focus {
		    z-index: 2;
		  }
		  .form-signin input[type="text"] {
		    margin-bottom: -1px;
		    border-bottom-left-radius: 0;
		    border-bottom-right-radius: 0;
		    border-top-style: solid;
		    border-right-style: solid;
		    border-bottom-style: none;
		    border-left-style: solid;
		    border-color: #000;
		  }
		  .form-signin input[type="password"] {
		    margin-bottom: 10px;
		    border-top-left-radius: 0;
		    border-top-right-radius: 0;
		    border-top-style: none;
		    border-right-style: solid;
		    border-bottom-style: solid;
		    border-left-style: solid;
		    border-color: rgb(0,0,0);
		    border-top:1px solid rgba(0,0,0,0.08);
		  }
		  /* 表單標題 */
		  .form-signin-heading {
		    /*color: #fff;*/
		    text-align: center;
		    /*text-shadow: 0 2px 2px rgba(0,0,0,0.5);*/
		  }
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#login").on("click", function (event) {
			    event.preventDefault();
			    var username = $("input[id='username']").val(); 
	    		var password = $("input[id='password']").val(); 
    			$.ajax({ 
					type: 'POST',
					url: '',
					data: {
						username: username,
						password: password,
					},beforeSend: function(b){
						$("button").attr({'disabled':true});
					},done: function(d){
						$("button").attr({'disabled':false});
					},success: function(data){ 
						console.log(data)	 
						if (data == 2) {	
							// 帳號已啟用，並已填寫個人資料
							// window.location.href = 'main.php';
						}else if (data == 1) {
							// 帳號已啟用，尚未填寫個人資料
							// window.location.href = 'profile.php';
						}else if(data == 0) { 
							// 帳號未啟用
							// alert("尚未啟用帳號，請至信箱點擊驗證信件，或申請補發驗證信");
							// window.location.href = 'verifyagain.php';
						};  
					},error: function(e){
						console.log(e)
						alert("此帳號尚未註冊或密碼輸入錯誤");
					}
				});
			});
    	});
	</script>
</head>
<body>
	<div class="container">
		<form class="form-signin" id="form">
			<h1 class="form-signin-heading text-muted">點日記3.0</h1>
			<input type="text" class="form-control" placeholder="帳號" required="" autofocus="" id="username" name="username">
			<input type="password" class="form-control" placeholder="密碼" required="" id="password" name="password">
			<div class="row text-right">
				<a class="col-sm-12" href="">忘記密碼</a>
			</div>
			<div class="row">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<button id="login" class="btn btn-lg btn-primary btn-block">登入</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<button id="regist" class="btn btn-lg btn-primary btn-block">註冊</button>
				</div>
			</div>
		</form>
    </div>
</body>
</html>