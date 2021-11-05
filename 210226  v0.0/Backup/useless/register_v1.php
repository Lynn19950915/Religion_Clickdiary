<?php

?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<title>會員註冊</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	<style type="text/css">
		/* ---------------------------------------------------------------------------------------------------- */
		@import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css);
		@import url(https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.3/css/mdb.min.css);


		
		.info-text {
		    color: #33b5e5; 
		}
		.form-white .md-form label {
		  color: #fff; 
		}
		.form-white input[type=text]:focus:not([readonly]) {
		    border-bottom: 1px solid #fff;
		    -webkit-box-shadow: 0 1px 0 0 #fff;
		    box-shadow: 0 1px 0 0 #fff; 
		}
		.form-white input[type=text]:focus:not([readonly]) + label {
		    color: #fff; 
		}
		.form-white input[type=password]:focus:not([readonly]) {
		    border-bottom: 1px solid #fff;
		    -webkit-box-shadow: 0 1px 0 0 #fff;
		    box-shadow: 0 1px 0 0 #fff; 
		}
		.form-white input[type=password]:focus:not([readonly]) + label {
		    color: #fff; 
		}
		.form-white input[type=password], .form-white input[type=text] {
		    border-bottom: 1px solid #fff; 
		}
		.form-white .form-control:focus {
		    color: #fff;
		}
		.form-white .form-control {
		    color: #fff;
		}
		.form-white textarea.md-textarea:focus:not([readonly]) {
		    border-bottom: 1px solid #fff;
		    box-shadow: 0 1px 0 0 #fff;
		    color: #fff; 
		}
		.form-white textarea.md-textarea  {
		    border-bottom: 1px solid #fff;
		    color: #fff;
		}
		.form-white textarea.md-textarea:focus:not([readonly])+label {
		    color: #fff;
		}
		.near-moon-gradient {
		    /*background-image: linear-gradient(to bottom, #30cfd0 0%, #330867 100%);*/
		    background-image: linear-gradient(to top, #a3bded 0%, #6991c7 100%);

			/*background-image: linear-gradient(to bottom, #667eea 0%, #764ba2 100%);*/
		}
		/* ---------------------------------------------------------------------------------------------------- */
		html,body{
			min-height: 100%;
			padding-top: 2rem;
			/*background-color:  #e3eeff;*/
		}
		h3{
			color: white;
			font-weight: 700;
		}
		form{
			width: 80%;
			margin: auto;
		}
		.card-body{
		    letter-spacing: 0.5em;
		    line-height: 1.8em;
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


			$("#form").on("submit", function (evt) {
			    evt.preventDefault();

			    var username=$("input[id='username']").val(); 
	    		var password=$("input[id='password']").val(); 
	    		var password2=$("input[id='password2']").val(); 

				
				if (location.search) {
					var parts = location.search.substring(1).split('&');

					for (var i = 0; i < parts.length; i++) {
						var nv = parts[i].split('=');
						if (!nv[0]) continue;
						params[nv[0]] = nv[1] || true;
					}
				}
				var egoid_invite=params.egoid;
				var alterid_invite=params.alterid;
				var reg_param=params.reg_param;
				if(egoid_invite==undefined){ egoid_invite="null"; }
				if(alterid_invite==undefined){ alterid_invite="null"; }
	    		
				
	    		if (password != password2) {
    				alert("兩次輸入的密碼不一樣唷~請再次確認");
    		 		return false;
    			}else {
    				$.ajax({ 
						type: "POST",
						url: 'regist_v2.php',
						data: {
							username: username,
							password: password,
							egoid_invite:egoid_invite,
							alterid_invite:alterid_invite,
							reg_param:reg_param
						},beforeSend: function() { 
							$("#loadingtext").show();
							$("#submit").prop('disabled', true); // disable button
						},complete : function (){
							$("#loadingtext").hide();
							$("#submit").prop('disabled', false); // disable button,
						},success: function(data){
							alert("註冊成功，請前往信箱查收驗證信，並啟用帳號");
							window.location.href='login.html'; 
						},error: function(data){
							//console.log(data);
							alert("這個帳號/註冊連結已被使用囉，欲變更帳號請按右上角聯絡我們!!");
						}
					});
    			}
			});
		});
	</script>	
</head>
<body>
	<div class="container">
		<div id="page_1">
			<div class="card border-primary">
				<div class="card-header text-white bg-primary">點日記3.0簡介</div>
				<div class="card-body">
				台灣社會的宗教活動蓬勃發展，不論是佛教團體的志工，還是民間信仰信徒主動發心的儀式活動義工，都為台灣社會的宗教注入相當高的動能。隨著3C時代的來臨，新的溝通模式創造了更多組織動員的新可能，也讓宗教參與的可能樣貌更為豐富。<br><br>
				為瞭解這群發心自願參與宗教活動的義工，如何在宗教參與及日常生活間達到平衡？<br>
				平時如何獲得訊息？彼此如何溝通、互動？有何心靈上的收穫？<br><br>
				中研院統計所及社會所計畫進行一項線上填答的長期追蹤研究，希望(定期或不定期)參與宗教服務活動的人，能定期在線上填答簡單問卷，讓我們更瞭解台灣宗教發展背後的動能如何產生。本研究將提供微薄的回饋作為答謝，謝謝您發心參與!!<br>
				<!-- 相關訊息，請點選以下網址。 -->
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
 			<div class="row justify-content-center">
	            <div class="col-md-8 mb-4">
	                <div class="card near-moon-gradient form-white">
	                    <div class="card-body">
	                        <form>
	                            <h3 class="text-center py-4">點日記3.0會員註冊</h3>
	                            <div class="md-form">
	                                <i class="fa fa-user prefix white-text"></i>
	                                <input type="text" id="username" class="form-control" placeholder="請輸入帳號 (Email)">
	                                <label for="username"></label>
	                            </div>
	                            <div class="md-form">
	                                <i class="fa fa-lock prefix white-text"></i>
	                                <input type="password" id="password" class="form-control">
	                                <label for="password">請輸入密碼</label>
	                            </div>
	                            <div class="md-form">
	                                <i class="fa fa-lock prefix white-text"></i>
	                                <input type="password" id="password2" class="form-control">
	                                <label for="password2">請確認密碼</label>
	                            </div>
	                            <div class="text-center py-4">
	                                <button class="btn btn-indigo">送出 <i class="fa fa-paper-plane-o ml-1"></i></button>
	                            </div>
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
 		</div>
	</div>
</body>
<!--
<body class="h-100">
    <div class="container mt-4">
    	<div class="row justify-content-center">
    		
    	</div>
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="card near-moon-gradient form-white">
                    <div class="card-body">
                        <form>
                            <h3 class="text-center py-4">點日記3.0會員註冊</h3>
                            <div class="md-form">
                                <i class="fa fa-user prefix white-text"></i>
                                <input type="text" id="username" class="form-control">
                                <label for="username">請輸入帳號</label>
                            </div>
                            <div class="md-form">
                                <i class="fa fa-lock prefix white-text"></i>
                                <input type="password" id="password" class="form-control">
                                <label for="password">請輸入密碼</label>
                            </div>
                            <div class="md-form">
                                <i class="fa fa-lock prefix white-text"></i>
                                <input type="password" id="password2" class="form-control">
                                <label for="password2">請確認密碼</label>
                            </div>
                            <div class="text-center py-4">
                                <button class="btn btn-indigo">送出 <i class="fa fa-paper-plane-o ml-1"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/js/mdb.min.js"></script>
  
</body>
-->

</html>