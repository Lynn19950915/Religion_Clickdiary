<?php
	session_start();
	include("db.php"); 
	

	if(isset($_GET['v_param'])){
		if(ctype_digit($_GET['v_param'])){
			$param = $_GET['v_param'];
		}else{
			die(header("HTTP/1.0 404 Not Found"));
		}
	}else{
		CheckAccInfo();
		$param = 0;
	}

	if (isset($_POST['Formsubmit'])) {
		$un      = $_POST['un'];
		$pw      = $_POST['pw'];
		$newpw   = $_POST['newpw'];
		$v_param = $_POST['v_param'];
		$pw_encoded    = base64_encode($pw);
		$newpw_encoded = base64_encode($newpw);

		if($v_param != 0){
			// 臨時驗證碼
			$sql  = "SELECT * FROM account where username=:username ";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':username', $un);
			$stmt->execute();
			if($stmt->rowCount() > 0){
				$rs = $stmt->fetch(PDO::FETCH_ASSOC);
				$sql  = "SELECT * FROM `pw_forget_param` WHERE id = :v1 AND param = :v2 AND valid_time >= NOW() ";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':v1', $rs['id']);
				$stmt->bindParam(':v2', $v_param);
				$stmt->execute();
				$n_row = $stmt->rowCount();	
			}
		}else{
			// 依照輸入的帳號密碼進行query 
		    $sql  = "SELECT * FROM account WHERE username = :username AND password = :pw";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':username', $un);
			$stmt->bindParam(':pw', $pw_encoded);
			$stmt->execute();
			$n_row = $stmt->rowCount();
		}
		
		
		if ($n_row > 0) {
			$sql_query1 = "UPDATE account set password=:newpw where username=:username ";
	        $stmt1=$db->prepare($sql_query1);
			$stmt1->bindParam(':username', $un);
			$stmt1->bindParam(':newpw', $newpw_encoded);
			$stmt1->execute();
	    }else{
			//帳號不存在，令ajax error
			die(header("HTTP/1.0 404 Not Found"));
		};	
	}
?><!DOCTYPE html>
<html>
<head>
	<title>修改密碼</title>
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
			var v_param = "<?php echo $param; ?>";
			console.log(v_param)

			if(v_param != 0){
				$("#pw_old").hide()
				$("#div_v_param").show()
				$("input[name='v_param']").val(v_param).attr({'disabled': true})
				alert_msg = "密碼重置連結有誤/已逾期\n 請重新進入忘記密碼畫面，獲取密碼重置連結";
			}else{
				$("#div_v_param").hide()
				alert_msg = "您所填的Email帳號或密碼有誤";
			}

			$("#form").on("submit", function (event) {  //表單內的submit被點擊時
				event.preventDefault();
				var un 		=$("input[name='username']").val();
				var pw 		=$("input[name='pw']").val();
				var newpw   =$("input[name='newpw']").val();
				var newpw2  =$("input[name='newpw2']").val();

				// console.log(username,pw,newpw,newpw2);
				if(newpw == newpw2){
					$.ajax({ 
						type: "POST",
						url: '',
						data: {
							Formsubmit: 1,
							un: un,
							pw: pw,
							newpw: newpw,
							v_param: v_param
						},success: function(data){
							// console.log(data)
							$.confirm({
								title: '',
							    content: '已為您變更密碼，請重新登入',
							    buttons: {
							        '好': function() {
							        	window.location.href = 'http://cdiary3.tw';
							        }
							    }
							});
						},error: function(e){
							// console.log(e)
							$.confirm({
								title: '',
							    content: alert_msg,
							    buttons: {
							        '好': function() {
							        	window.location.href = 'http://cdiary3.tw/pw_forget.php';
							        }
							    }
							});
						}
					});
				}else{
					$.alert("2次輸入的新密碼不同<br>請重新確認");
				}
			});
		});
	</script>
</head>
<body>
	<?php include("header_b3.php");?>
	<div class="container">
		<form id="form" class="form-horizontal">
		<div class="panel panel-primary">
		  <div class="panel-heading">修改密碼</div>
		  <div class="panel-body">		
		  <!-- 內容 -->
		  <p>請輸入以下資訊來變更您的密碼</p>
		  	<div class="form-group">
				<label class="col-sm-2 control-label" >帳號(Email):</label>
				<div class="col-sm-5">
					<input id="username" name="username" type="email" class="form-control" placeholder="請輸入註冊時的Email帳號" required> 
				</div> 
			</div>
			<div class="form-group" id="pw_old">
				<label class="col-sm-2 control-label" >舊密碼:</label>
				<div class="col-sm-5">
					<input id="pw" name="pw" type="password" class="form-control" placeholder=""> 
				</div> 
			</div>
			<div class="form-group" id="div_v_param">
				<label class="col-sm-2 control-label" >臨時驗證碼:</label>
				<div class="col-sm-5">
					<input id="v_param" name="v_param" type="text" class="form-control" placeholder=""> 
				</div> 
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" >輸入新密碼:</label>
				<div class="col-sm-5">
					<input id="newpw" name="newpw" type="password" class="form-control" placeholder="" required> 
				</div> 
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" >確認新密碼:</label>
				<div class="col-sm-5">
					<input id="newpw2" name="newpw2" type="password" class="form-control" placeholder="" required> 
				</div> 
			</div>

		  </div>
		</div>
		
		
		<div class="submit_button" align="center">
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