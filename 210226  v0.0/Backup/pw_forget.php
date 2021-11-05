<?php
	session_start();
	include("db.php");

	if(isset($_POST['pw_forget'])){
		$un = $_POST['un'];
		$sql = "SELECT * FROM account WHERE username = :v1";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':v1', $un);
		$stmt->execute();
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		$id = $rs['id'];
		$param = randomNumber();
		$valid_time = date('Y-m-d H:i:s', strtotime('15 minute'));
		
		if($stmt->rowCount() > 0){
			$sql = "INSERT INTO `pw_forget_param`
						(`id`, `param`, `valid_time`) 
					VALUES 
						(:v1, :v2, :v3)";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':v1', $id);
			$stmt->bindParam(':v2', $param);
			$stmt->bindParam(':v3', $valid_time);
			$stmt->execute();

			include_once("mail_function.php");
			$subject    = "中研院-點日記3.0: 密碼重置連結"; 
			$sendername = "中研院統計科學研究所_點日記團隊";

			$mail_body  = " 親愛的會員您好：<br>
							請於15分鐘內進入以下連結重置您的點日記3.0登入密碼<br>
				  			<a href='http://cdiary3.tw/pw_edit.php?v_param={$param}'>http://cdiary3.tw/pw_edit.php?v_param={$param}</a>";
			try {
				Send_GMail($subject, $mail_body, $sender = "***@gmail.com", $sendername, $un);
				Send_WebMail($subject, $mail_body, $sender = "***@stat.sinica.edu.tw", $sendername, $un);
				echo "Mail Sent";
			} catch (Exception $e) {
				echo $e->getMessage()."<br>";
			}
		}else{
			die(header("HTTP/1.0 404 Not Found"));
		}
		exit();
	}

	//生成隨機密碼
	function randomNumber($length = 10, $validCharacters = "0123456789") {
		$validCharNumber = strlen($validCharacters);
		$result = "";
		for ($i = 0; $i < $length; $i++) {
				$index = mt_rand(0, $validCharNumber - 1);
				$result .= $validCharacters[$index];
		}
		return $result;
	}  
?><!DOCTYPE html>
<html>
<head>
	<title>忘記密碼</title>
	<meta http-equiv="Content-Type" content="text/html"  charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>
	<!-- Jquery-Confirm -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<style type="text/css">
			/*For nav and footer*/
			html {
			  position: relative;
			  min-height: 100%;
			}
			body {
			  /*Avoid nav bar overlap web content*/
			  padding-top: 70px; 
			  /* Margin bottom by footer height ，avoid footer overlap web content*/
			  margin-bottom: 60px;
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
			
			label{font-weight:400}
			#submit{
				color: white;
			    background-color: #2e6da4;
			    border-color: #2e6da4;
			    height: 3em;
			}
			@media screen and (min-width: 550px) { 
				#submit{
					width: 30vw
				}
			}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#form").on("submit", function (event) {  //表單內的submit被點擊時
				event.preventDefault();
				var un = $("input[name='username']").val();
				$.ajax({ 
					type: "POST",
					url: '',
					data: {
						pw_forget: 1,
						un: un,
					},beforeSend: function() { 
						$("#loadingtext").empty().html("密碼重置信發送中...請稍候").attr({'style': 'color: red'})
						$("#loadingtext").show();
						$("#submit").prop('disabled', true);
					},complete : function (){
						$("#loadingtext").hide();
						$("#submit").prop('disabled', false);
					},success: function(data){
						console.log(data)
						$.alert("密碼重置信已寄出，請於15分鐘內利用信件中連結變更您的密碼");
						// window.location.href = 'http://mba.geohealth.tw';
					},error: function(e){
						// console.log(e)
						$.alert("您所填的Email帳號有誤\n 查無此帳號");
					}
				});

			});
		});
	</script>
</head>
<body>
	<?php include("header_b3.php");?>
	<div class="container">
		<form id="form" class="form-horizontal">
		<div class="panel panel-primary">
		  <div class="panel-heading">忘記密碼</div>
		  <div class="panel-body">		
		  <!-- 內容 -->
		  <p>請輸入註冊時的帳號(Email)，系統將寄出密碼重置信至您的信箱</p>
		  	<div class="form-group">
				<label class="col-sm-2 control-label" >帳號(Email):</label>
				<div class="col-sm-5">
					<input id="username" name="username" type="email" class="form-control" placeholder="請輸入註冊時的電子信箱" required> 
				</div> 
			</div>
		  </div>
		</div>
		<div class="submit_button" align="center">
			<div id="loadingtext"></div>
			<input class="btn btn-md btn-block " type="submit" id="submit" value="送出!!"  >
		</div>
		</form>
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