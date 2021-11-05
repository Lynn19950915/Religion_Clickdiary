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
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Numans');

		html,body{
		/*background-image: url('http://cdiary3.tw/pic/index_bg.jpeg');*/
		/*background-image: url('http://cdiary3.tw/pic/p.png');*/
		background-image: url('http://getwallpapers.com/wallpaper/full/a/5/d/544750.jpg');
		/*background-image: url('http://getwallpapers.com/wallpaper/full/2/5/b/1320833-chinese-theme-wallpaper-1920x1200-smartphone.jpg');*/
		
		/*background-color: #f0f0f0;*/
		background-size: cover;
		background-repeat: no-repeat;
		height: 100%;
		font-family: 'Numans', sans-serif;
		padding-bottom: 5vw;
		}

		.container{
		height: 100%;
		align-content: center;
		}

		.card{
		height: 20rem;
		margin-top: auto;
		margin-bottom: auto;
		width: 400px;
		/*background-color: rgba(0,0,0,0.5) !important;*/
		background-color: rgba(255,255,255,0.3) !important;
		}

		.card-header h3{
		color: white;
		}

		.input-group-prepend span{
		width: 2.5rem;
		background-color: #FFC312;
		color: black;
		border:0 !important;
		}

		input:focus{
		outline: 0 0 0 0  !important;
		box-shadow: 0 0 0 0 !important;

		}

		.login_btn{
		color: black;
		/*background-color: #f0f0f0;*/
		margin: auto 0.5rem;
		/*background-color: #FFC312;*/
		/*width: 5rem;*/
		}

		.login_btn:hover{
		color: black;
		background-color: white;
		}

		.links{
		color: white;
		text-align: right;
		}

		.links a{
		margin-left: 4px;

		}
		.icon{
			height: 4em;
			/*width: 8em;*/
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
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>點日記3.0</h3>
			</div>
			<div class="card-body">
				<form>
					<div class="input-group form-group mb-4">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input type="text" class="form-control" placeholder="請輸入帳號 (Email)">
					</div>
					<div class="input-group form-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input type="password" class="form-control" placeholder="請輸入密碼">
					</div>
					<div class="form-group  links mb-1">
						<a class="" href="#">忘記密碼?</a>
					</div>
					<div class="form-group mt-1 " style="text-align: center;">
						<button class="btn login_btn">
							<img src="/pic/btn_register.png" class="icon">
						</button>
						<button class="btn login_btn">
							<img src="/pic/btn_sign_in.png" class="icon">
						</button>
					</div>
				</form>
			</div>
			<div class="card-footer">
				<!-- <div class="d-flex justify-content-center links"> -->
					<!-- Don't have an account?<a href="#">Sign Up</a> -->
				<!-- </div> -->
				
			</div>
		</div>
	</div>
</div>
</body>
</html>